# UCB Website - Backend API (Laravel)

Backend API untuk UCB Website menggunakan Laravel. Frontend terpisah di folder `../frontend/`.

## Struktur

Backend ini hanya menyediakan REST API. Frontend SPA (Vue.js) ada di folder `../frontend/` yang terpisah.

- **API Routes** (`/api/v1/*`): REST API endpoints
- **Health Check** (`/api/health`): Health check endpoint

## Instalasi

### Install Dependencies

```bash
composer install
```

**Catatan**: Backend ini hanya menggunakan Composer (PHP). Frontend menggunakan npm dan ada di folder `../frontend/`.

### Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### Setup Database

Untuk development lokal (SQLite):
```env
DB_CONNECTION=sqlite
```

Kemudian jalankan migration:
```bash
php artisan migrate
php artisan db:seed
```

## Menjalankan Development Server

**Backend (Laravel API)**:
```bash
php artisan serve
```

Backend API akan berjalan di: `http://localhost:8000`

**Catatan**: Frontend terpisah di folder `../frontend/`. Jalankan frontend dengan:
```bash
cd ../frontend
npm install
npm run dev
```

## Build untuk Production

**Backend:**
```bash
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Frontend:**
```bash
cd ../frontend
npm install
npm run build
```

## Struktur Folder Laravel

```
app/
├── app/                    # Application core
│   ├── Http/Controllers/   # Controllers
│   ├── Models/             # Eloquent models
│   ├── Mail/               # Mail classes
│   └── Exports/            # Excel/PDF exports
├── config/                 # Configuration files
├── database/               # Migrations, seeders, factories
├── public/                 # Public entry point & assets
├── resources/              # Views & assets
│   └── views/              # Blade templates (untuk email, dll)
├── routes/                 # Route definitions
├── storage/                # Storage files
└── tests/                  # Test files
```

## API Routes

Semua endpoint API tersedia di `/api/v1/*`. Lihat file `routes/api.php` untuk detail lengkap.

### Public Endpoints (tidak memerlukan autentikasi)
- `GET /api/v1/articles` - List articles
- `GET /api/v1/articles/{id}` - Article detail
- `GET /api/v1/gallery` - List gallery albums
- `GET /api/v1/videos` - List videos
- `GET /api/v1/events` - List events
- `GET /api/v1/members` - List members
- `POST /api/v1/contact-messages` - Submit contact message
- `POST /api/v1/join-applications` - Submit join application
- Dan lainnya...

### Protected Endpoints (memerlukan autentikasi Bearer token)
- Semua endpoint CRUD untuk admin (articles, gallery, videos, events, members, dll)
- Lihat `routes/api.php` untuk detail lengkap

## Catatan

- Backend ini hanya menyediakan REST API
- Frontend SPA ada di folder `../frontend/`
- Authentication menggunakan Laravel Sanctum (Bearer token)


