$ErrorActionPreference = 'Stop'

function Invoke-DockerCompose {
    param(
        [string[]]$Arguments,
        [string]$FailureMessage
    )

    $previousErrorActionPreference = $ErrorActionPreference
    try {
        $ErrorActionPreference = 'Continue'
        & docker compose @Arguments
        $commandExitCode = $LASTEXITCODE
    }
    finally {
        $ErrorActionPreference = $previousErrorActionPreference
    }

    if ($commandExitCode -ne 0) {
        throw $FailureMessage
    }
}

$projectRoot = Split-Path -Parent $PSScriptRoot
Push-Location $projectRoot
try {
    if (-not (Test-Path '.env')) {
        throw 'Missing .env. Copy .env.example to .env and set local passwords first.'
    }

    $previousErrorActionPreference = $ErrorActionPreference
    try {
        $ErrorActionPreference = 'Continue'
        & docker info --format '{{.ServerVersion}}' 2>&1 | Out-Null
        $dockerInfoExitCode = $LASTEXITCODE
    }
    finally {
        $ErrorActionPreference = $previousErrorActionPreference
    }

    if ($dockerInfoExitCode -ne 0) {
        throw 'Docker Engine is unavailable. Start Docker Desktop, wait for it to be ready, and run this script again.'
    }

    Invoke-DockerCompose -Arguments @('up', '-d', 'wordpress') -FailureMessage 'Could not start the WordPress services.'

    $envValues = @{}
    Get-Content -LiteralPath '.env' | ForEach-Object {
        if ($_ -match '^\s*#' -or $_ -match '^\s*$') {
            return
        }

        $key, $value = $_ -split '=', 2
        $envValues[$key.Trim()] = $value.Trim()
    }

    $siteUrl = "http://localhost:$($envValues['WORDPRESS_PORT'])"
    $siteTitle = $envValues['WORDPRESS_SITE_TITLE']
    $adminUser = $envValues['WORDPRESS_ADMIN_USER']
    $adminPassword = $envValues['WORDPRESS_ADMIN_PASSWORD']
    $adminEmail = $envValues['WORDPRESS_ADMIN_EMAIL']

    & docker compose --env-file .env run --rm wpcli wp core is-installed
    if ($LASTEXITCODE -ne 0) {
        & docker compose --env-file .env run --rm wpcli wp core install --url=$siteUrl --title=$siteTitle --admin_user=$adminUser --admin_password=$adminPassword --admin_email=$adminEmail --skip-email
        if ($LASTEXITCODE -ne 0) {
            throw 'WordPress installation failed during bootstrap.'
        }
    }

    & docker compose --env-file .env run --rm wpcli wp theme activate wordpress-demo
    if ($LASTEXITCODE -ne 0) {
        throw 'WordPress theme activation failed during bootstrap.'
    }

    & docker compose --env-file .env run --rm wpcli wp plugin activate interfacex-foundation
    if ($LASTEXITCODE -ne 0) {
        throw 'WordPress plugin activation failed during bootstrap.'
    }

    & docker compose --env-file .env run --rm wpcli wp option update permalink_structure '/%postname%/' --quiet
    if ($LASTEXITCODE -ne 0) {
        throw 'Permalink setup failed during bootstrap.'
    }

    & docker compose --env-file .env run --rm wpcli wp rewrite flush --hard
    if ($LASTEXITCODE -ne 0) {
        throw 'Permalink rewrite flush failed during bootstrap.'
    }

    & docker compose --env-file .env run --rm wpcli wp eval-file /opt/project/scripts/bootstrap.php
    if ($LASTEXITCODE -ne 0) {
        throw 'Bootstrap page setup failed.'
    }

    Write-Output 'WordPress is ready. Open http://localhost:8080/ and http://localhost:8080/interfacex/ (default port).'
    Write-Output 'If WORDPRESS_PORT differs in .env, use that port in both URLs.'
}
finally {
    Pop-Location
}
