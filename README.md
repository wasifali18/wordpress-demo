# WordPress Demo

A self-contained local WordPress demo. The custom theme owns the responsive landing page; the separate InterfaceX Foundation plugin provides the request form and workflow placeholders. The demo has no agent API connection: form entries stay in the browser and are neither transmitted nor saved.

## Git repository status

This project is maintained as a local Git repository on the primary branch `main`. No remote is configured; nothing is published. Do not add a guessed `origin` or push this project. A remote and repository URL must be supplied by the owner before any remote-based workflow is configured.

The `.gitignore` excludes the local `.env`, WordPress core/runtime files, database data and exports, uploads, dependency folders, caches, generated output, and local logs. `.env.example` contains replacement placeholders only. Keep real local credentials and WordPress runtime/database files out of commits.

The agent's existing Git workflow requires a clean working tree, checks out its configured main branch, then pulls from a configured remote/branch pair; its commit and apply paths also rely on Git state and a remote. The current agent WordPress profile has no `main_branch` or `remote`, and this repository has no remote, so that workflow is not ready. After the owner supplies a real remote, the agent profile and WordPress-specific safety, baseline/verification, and Git integration must be implemented and reviewed before considering agent runs. WordPress agent runs remain disabled; this local repository setup does not grant run permission.

## Prerequisites

- Windows 10/11 with Docker Desktop and Docker Compose v2.
- Docker Desktop must be running with its Linux container engine ready.

Docker Desktop and Compose are installed in the workspace used to prepare this project, but the Linux engine currently returns HTTP 500 for Docker Engine API requests. Compose configuration can be checked locally, but the WordPress containers and pages have not been started or browser-tested. Start or repair Docker Desktop's Linux engine before following the first-start steps.

## First start

From this directory in PowerShell:

```powershell
Copy-Item .env.example .env
notepad .env
```

Replace the example database, root, and WordPress admin passwords in `.env` with local-only values. Do not reuse real or production credentials. Then install/activate the theme and plugin and create the pages:

```powershell
.\scripts\setup.ps1
```

The script starts the database and WordPress, initializes WordPress on first run, activates both custom components, and creates or updates the tracked `home` and `interfacex` pages. It is repeatable; the bootstrap restores the project-owned titles and page content and sets Home as the static front page.

## URLs

- Landing page: <http://localhost:8080/>
- InterfaceX request workspace: <http://localhost:8080/interfacex/>
- WordPress admin: <http://localhost:8080/wp-admin/>

Change `WORDPRESS_PORT` in `.env` to use another local port.

## Start and stop

After the first setup, start the services with:

```powershell
docker compose up -d
```

Stop the containers and keep the database and WordPress files:

```powershell
docker compose down
```

To completely reset this demo, remove only its Compose-managed volumes:

```powershell
docker compose down --volumes
.\scripts\setup.ps1
```

This deletes the local WordPress installation, database, and uploads for this project. It does not delete the theme, plugin, scripts, or `.env`.

## If Docker Desktop cannot be used

No Windows PHP/Composer/WP-CLI or WSL WordPress runtime was available when this project was prepared, so a non-Docker setup has not been verified. The simplest Windows alternative is to install [Local](https://localwp.com/), create a local site, and copy `theme\wordpress-demo` and `plugin\interfacex-foundation` into that site's `app\public\wp-content\themes` and `app\public\wp-content\plugins` folders. Use Local's site shell to activate them and run the page bootstrap below. This alternative is untested here; Docker Compose remains the reproducible path maintained by this project.

To reuse the page bootstrap with Local, open that site's shell after copying the two folders and run:

```powershell
wp theme activate wordpress-demo
wp plugin activate interfacex-foundation
wp eval-file "C:\path\to\wordpress-demo\scripts\bootstrap.php"
```

Replace the example path with this project's actual location. Local's installation and shell are an untested alternative here; the Docker Compose setup is the reproducible path maintained by this project.

## Project structure

- `compose.yaml` defines WordPress, MySQL, and a one-shot WP-CLI setup service.
- `theme/wordpress-demo/` contains the custom landing-page theme.
- `plugin/interfacex-foundation/` contains the InterfaceX request form and its local-only submit feedback; its `assets/` directory contains the small interaction script.
- `scripts/setup.ps1` and `scripts/bootstrap.php` perform repeatable local setup.
- Edit the landing page in `theme/wordpress-demo/front-page.php` and its styles in `theme/wordpress-demo/style.css`. Edit the InterfaceX shell in `plugin/interfacex-foundation/interfacex-foundation.php`; rerun `.\scripts\setup.ps1` after changing the page bootstrap or plugin activation.
- The target selector and request text are intentionally unnamed form controls and have no network or persistence handler. The button only displays a local notice that the integration is not connected.
- WordPress core, the database, and uploaded files are stored in named Docker volumes, not in this source tree.
- `.env` is ignored by Git; `.env.example` contains placeholders only.
