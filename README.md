# FoxholeProject: Live War Stats Dashboard

A full-stack web application that pulls live data from the official [Foxhole](https://www.foxholegame.com/) API and displays real-time war statistics, map control, and town hall ownership across both game shards.

Built with Laravel 12, Livewire, and Tailwind CSS.

---

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Getting Started](#getting-started)
- [Artisan Commands](#artisan-commands)
- [Environment Variables](#environment-variables)
- [What I Learned](#what-i-learned)

---

## Features

- **Live war data:** Syncs war state, map reports, map icons, and location labels directly from the Foxhole API
- **Dual-shard support:** Toggle between the Able and Baker game shards at any time; all data is stored and displayed per-shard
- **Home dashboard:** Displays current war number, war day, total town hall counts, Warden vs. Colonial ownership breakdown, and victory progress
- **War status page:** Detailed live war state including conquest start time, required victory towns, and per-map stats
- **War maps list:** Browses all active maps with visual Warden/Colonial control percentage bars
- **Map viewer:** Renders town halls (T1/T2/T3) and relic bases on a selected map with team color coding and location labels
- **ETag caching:** Uses HTTP ETags to avoid re-fetching unchanged API data, keeping sync fast and respectful of the API
- **Server-side caching:** Livewire components cache query results (5-minute TTL) so the UI stays snappy between syncs

---

## Tech Stack

### Backend
| Technology | Purpose |
|---|---|
| PHP 8.2+ | Server-side language |
| Laravel 12 | Application framework (routing, ORM, caching, CLI) |
| Livewire 3 + Flux | Reactive server-rendered UI components |
| Livewire Volt | Single-file Livewire components |
| MySQL / SQLite | Relational database for persisted war data |
| Laravel HTTP Client | Consuming the Foxhole REST API with ETag support |

### Frontend
| Technology | Purpose |
|---|---|
| Tailwind CSS 4 | Utility-first styling |
| Vite | Asset bundling and hot-reload in development |
| Blade | Server-side templating |

### Tooling
| Technology | Purpose |
|---|---|
| Pest | Testing framework |
| Laravel Pint | PHP code style fixer |
| Laravel Sail | Docker-based local dev environment (optional) |
| Laravel Pail | Real-time log tailing in the terminal |

---

## Project Structure

```
FoxholeProject-/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       ├── FoxholeUpdate.php     # Artisan command: sync API data for one or both shards
│   │       ├── FoxholeCleanup.php    # Artisan command: prune old war data from the DB
│   │       └── FoxholeTest.php       # Artisan command: ad-hoc testing helper
│   ├── Http/
│   │   └── Middleware/
│   │       └── SetShardFromRoute.php # Reads shard from URL and stores it in session
│   ├── Livewire/
│   │   ├── HomePage.php              # War overview stats dashboard
│   │   ├── WarStatus.php             # Live war state details
│   │   ├── MapList.php               # All maps with control percentage bars
│   │   └── MapViewer.php             # Town hall and relic base map viewer
│   ├── Models/
│   │   ├── ApiEtag.php               # Stores ETags per API endpoint to avoid redundant fetches
│   │   ├── Map.php                   # Map records per shard
│   │   ├── MapIcon.php               # Live map icons (town halls, relic bases, etc.)
│   │   ├── MapReport.php             # Per-map war report stats
│   │   ├── MapTextItem.php           # Static location name labels
│   │   └── WarState.php              # Current war state (war number, conquest times, VP threshold)
│   └── Services/
│       ├── FoxholeApi.php            # HTTP client wrapper around the Foxhole API with ETag support
│       └── FoxholeSyncService.php    # Orchestrates full sync: war → maps → reports → icons → labels
├── config/
│   └── hex_positions.php             # Static hex map positional data
├── resources/views/livewire/         # Blade templates for each Livewire component
├── routes/
│   └── web.php                       # Shard-prefixed routes (/{shard}/) + shard toggle endpoint
├── database/migrations/              # Schema for maps, war_states, map_reports, map_icons, etc.
├── vite.config.js
└── package.json
```

---

## Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- Node.js v18+ and npm
- MySQL (or SQLite for quick local dev)

### 1. Clone the repository

```bash
git clone https://github.com/AdrianMorack/FoxholeProject.git
cd FoxholeProject-
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install Node dependencies

```bash
npm install
```

### 4. Set up environment variables

```bash
cp .env.example .env
php artisan key:generate
```

Then edit `.env` and configure your database connection (see [Environment Variables](#environment-variables)).

### 5. Run migrations

```bash
php artisan migrate
```

### 6. Seed the database with live Foxhole data

```bash
php artisan foxhole:update
```

This fetches the current war state, all maps, war reports, map icons, and location labels from the Foxhole API for both shards and stores them in your database.

### 7. Start the development servers

```bash
# In one terminal — PHP dev server
php artisan serve

# In another terminal — Vite asset bundler
npm run dev
```

The app will be available at [http://localhost:8000](http://localhost:8000).

### Available Scripts

| Command | Description |
|---|---|
| `php artisan serve` | Start the Laravel development server |
| `npm run dev` | Start Vite in watch/HMR mode |
| `npm run build` | Build frontend assets for production |
| `php artisan foxhole:update` | Sync all Foxhole API data into the database |
| `php artisan foxhole:update --shard=able` | Sync only the Able shard |
| `php artisan foxhole:update --all` | Explicitly sync both shards |
| `php artisan foxhole:cleanup` | Remove old war data (keeps 1 most recent war by default) |
| `php artisan foxhole:cleanup --keep-wars=2` | Keep the 2 most recent wars per shard |

---

## Artisan Commands

### `foxhole:update`
Fetches data from the Foxhole API and upserts it into the database. Runs the full pipeline per shard:
1. War state (war number, conquest start, required victory towns)
2. Map list
3. War reports (per-map casualty and resource stats)
4. Static map data (location name labels)
5. Dynamic map data (live town hall and structure icons)

Flushes the application cache after syncing so Livewire picks up fresh data immediately.

```bash
php artisan foxhole:update              # sync both shards (default)
php artisan foxhole:update --shard=baker
php artisan foxhole:update --all
```

### `foxhole:cleanup`
Prunes map icon and war state records for old wars to keep the database lean.

```bash
php artisan foxhole:cleanup             # keep 1 most recent war
php artisan foxhole:cleanup --keep-wars=3
```

---

## Environment Variables

Copy `.env.example` to `.env` and fill in the required values:

```env
APP_NAME=FoxholeProject
APP_ENV=local
APP_KEY=                        # generated by php artisan key:generate
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql             # or sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=foxhole
DB_USERNAME=root
DB_PASSWORD=
```

| Variable | Description |
|---|---|
| `APP_KEY` | Laravel application encryption key — generate with `php artisan key:generate` |
| `DB_CONNECTION` | Database driver (`mysql` or `sqlite`) |
| `DB_DATABASE` | Database name (or path to `.sqlite` file) |
| `DB_USERNAME` / `DB_PASSWORD` | Database credentials |

No external API keys are required — the Foxhole API is public and unauthenticated.

---

## What I Learned

### Laravel Service Layer
Building the `FoxholeApi` and `FoxholeSyncService` classes taught me how to separate concerns properly in Laravel. The API client handles HTTP details and ETag logic; the sync service orchestrates the full pipeline. This made the code far easier to test and reason about than putting everything in a controller.

### ETag-Based API Caching
The Foxhole API returns ETag headers. I learned how to store these in the database and send `If-None-Match` headers on subsequent requests, so the server responds with `304 Not Modified` when nothing has changed. This cuts down unnecessary data transfer and speeds up syncs significantly.

### Livewire Reactive Components
Livewire let me build a reactive, dynamic UI without writing a separate JavaScript frontend. I learned how Livewire serializes PHP component state, handles re-renders, and integrates cleanly with Blade templates. The shard toggle — which swaps a session value and redirects — was a good exercise in thinking about server-driven state.

### Multi-Shard Data Architecture
Every model in the database is scoped by a `shard` column (`able` / `baker`). Designing the schema and queries to handle both shards cleanly — including fallback logic in the map viewer when one shard is offline — required careful thought about data isolation.

### Artisan Commands for Data Pipelines
Writing Artisan commands to drive ETL-style workflows (fetch → transform → upsert → cache flush) showed me how useful Laravel's CLI tooling is for background jobs and on-demand data ops beyond just web requests.

### Database Deduplication
Live map data can contain duplicate icon entries at the same coordinates across syncs. I learned how to handle this with `groupBy` and `sortByDesc('updated_at')->first()` to keep only the latest icon per location, keeping the displayed data clean.

They use things in app/Livewire as the backend

We also have things in resources/views/layouts to be a base layout that our pages will utilize

Routes is what we will use to add pages in and then code in the transitions in there.