# WordPress Demo

A self-contained local WordPress demo. The custom theme owns the responsive landing page; the separate InterfaceX Foundation plugin hosts the existing InterfaceX React UI on `/interfacex/`. The WordPress target remains unavailable for agent execution.

The `.gitignore` excludes the local `.env`, WordPress core/runtime files, database data and exports, uploads, dependency folders, caches, generated output, and local logs. `.env.example` contains replacement placeholders only. Keep real local credentials and WordPress runtime/database files out of commits.

The agent workflow has additional safety and Git readiness requirements. WordPress execution remains blocked; do not treat the repository remote as permission to run it.

## Prerequisites

- Windows 10/11 with Docker Desktop and Docker Compose v2.
- Docker Desktop must be running with its Linux container engine ready.

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

## InterfaceX integration

The `/interfacex/` page renders the existing InterfaceX React application from `demo_website`; it does not duplicate its workflow UI or use an iframe. The plugin enqueues the built JavaScript and stylesheet only when `[interfacex_request]` is rendered. The React app's API origin is fixed at build time to `http://localhost:8000`; it does not accept an API URL or target path from the browser.

Build or rebuild the WordPress assets from the `demo_website` project after changing its InterfaceX source:

```powershell
Push-Location ..\demo_website
npm.cmd run build:wordpress
Pop-Location
```

The generated `plugin\interfacex-foundation\assets\app\interfacex-app.js` and `.css` are the only frontend build files needed by the plugin and are tracked so a fresh WordPress checkout can serve the page. Do not copy `node_modules`, local configuration, or environment files.

The user must enter their own InterfaceX admin token in the embedded UI. It is handled by the existing frontend and stored in browser `sessionStorage` only; WordPress does not receive or store the token. The API must be running at `http://localhost:8000`, and its explicit CORS allowlist must include the WordPress page origin `http://localhost:8080`. For example, add that origin to the existing comma-separated `INTERFACEX_ALLOWED_ORIGINS` setting in the agent API's local environment, retaining only the origins you need, then restart the API. Do not use wildcard CORS. The build does not include or create credentials.

The API-provided target list controls availability. React remains the default; WordPress is displayed as unavailable and cannot be selected for execution while the API reports it as disabled/coming soon. No WordPress agent workflow is started by this page.

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
- `plugin/interfacex-foundation/` contains the shortcode that mounts the existing InterfaceX UI and its built frontend assets.
- `scripts/setup.ps1` and `scripts/bootstrap.php` perform repeatable local setup.
- Edit the landing page in `theme/wordpress-demo/front-page.php` and its styles in `theme/wordpress-demo/style.css`. Edit the InterfaceX mount point in `plugin/interfacex-foundation/interfacex-foundation.php`; rerun `.\scripts\setup.ps1` after changing the page bootstrap or plugin activation.
- WordPress core, the database, and uploaded files are stored in named Docker volumes, not in this source tree.
- `.env` is ignored by Git; `.env.example` contains placeholders only.
