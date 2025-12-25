# UCB Website – Vue (Vite) + Laravel + MySQL

Stack yang digunakan:

- Frontend: Vue 3 (Vite, SPA) dengan Tailwind CSS v4
- Backend: Laravel 12 (PHP)
- Database: SQLite/MySQL

## Struktur Project

Setelah migrasi, struktur project menjadi:

```
UCBWebsite/
├── app/              # Laravel + Vue.js (unified structure)
│   ├── app/          # Laravel application
│   ├── resources/
│   │   ├── js/       # Frontend Vue.js (public + admin)
│   │   └── views/    # Blade templates
│   ├── routes/       # Laravel routes
│   └── public/       # Public assets
├── backend/          # Backup (dapat dihapus setelah yakin)
├── frontend/          # Backup (dapat dihapus setelah yakin)
└── cms/              # Backup (dapat dihapus setelah yakin)
```

## Instalasi

1. **Install dependencies:**
   ```bash
   cd app
   composer install
   npm install
   ```

2. **Setup environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Jalankan migrasi:**
   ```bash
   php artisan migrate
   ```

4. **Jalankan aplikasi:**
   ```bash
   # Terminal 1: Laravel server
   php artisan serve
   
   # Terminal 2: Vite dev server
   npm run dev
   ```

## Akses

- **Website Public:** http://127.0.0.1:8000
- **Admin Panel:** http://127.0.0.1:8000/admin/login

## Detail Setup

Lihat `SETUP.md` untuk instruksi setup lengkap.

