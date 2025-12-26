Minimarket Laravel Skeleton

This folder contains a scaffolded Laravel application structure (models, migrations, API controllers, and seeders) inferred from the provided SQL dump `minimarketmakmurjayadb.sql`.

Important: This scaffold does NOT include the Laravel framework or vendor files. Follow the instructions below to create a runnable Laravel app locally.

Quick setup (PowerShell):

```powershell
# 1. Create a new Laravel project named "minimarket"
composer create-project laravel/laravel minimarket

# 2. Copy the files from this folder into the Laravel project root (merge the directories)

# 3. Configure .env DB settings (DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# 4. Install dependencies and generate app key
cd minimarket
composer install
php artisan key:generate

# Optional: install Breeze for basic auth & UI
composer require laravel/breeze --dev
php artisan breeze:install
npm install
npm run dev

# 5. Run migrations and seeders
php artisan migrate --seed

# 6. Start the dev server
php artisan serve

# API endpoints (example)
# GET /api/barang
# POST /api/barang
# GET /api/penjualan
```

Files included here:
- `app/Models/*` - Eloquent models with relationships
- `database/migrations/*` - migrations for all tables
- `database/seeders/*` - seeders with initial data from SQL dump
- `app/Http/Controllers/Api/*` - API controllers with CRUD (JSON)
- `routes/api.php` - API resource routes

If you want Blade CRUD views instead of API JSON endpoints, tell me and I will add simple Blade templates and web routes.
