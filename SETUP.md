# Setup Project (Vue + Laravel + MySQL)

## Prasyarat
- Node.js 18+ dan npm
- PHP 8.2+ dan Composer
- MySQL 8.0+

## 1) Inisialisasi Backend (Laravel)

```bash
cd backend
composer create-project laravel/laravel .

# Salin env dan set kunci
cp .env.example .env
php artisan key:generate
```

Edit `.env` untuk koneksi database:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ucb_website
DB_USERNAME=root
DB_PASSWORD=your_password
```

Jalankan migrasi awal (setelah model dibuat):
```bash
php artisan migrate
```

Jalankan server dev:
```bash
php artisan serve
# default: http://127.0.0.1:8000
```

Aktifkan CORS (contoh di `app/Http/Middleware/HandleCors` atau `config/cors.php`) untuk mengizinkan origin `http://localhost:5173`.

## 2) Inisialisasi Frontend (Vue + Vite)

```bash
cd ../frontend
npm create vite@latest . -- --template vue
npm install
```

Tambahkan Tailwind (opsional tapi direkomendasikan):
```bash
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```

Konfigurasi `tailwind.config.js` content jika memakai Tailwind:
```js
export default {
  content: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  theme: { extend: {} },
  plugins: [],
}
```

Buat file `src/assets/base.css` atau gunakan `src/style.css` untuk import Tailwind:
```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```

Jalankan dev server:
```bash
npm run dev
# default: http://localhost:5173
```

## 3) Environment Frontend

Buat `.env` atau `.env.local` di `frontend/`:
```
VITE_API_BASE_URL=http://127.0.0.1:8000/api
```

Gunakan `import.meta.env.VITE_API_BASE_URL` di client untuk memanggil API.

## 4) Inisialisasi CMS (Aplikasi Terpisah)

CMS adalah aplikasi Vue terpisah untuk admin panel:

```bash
cd ../cms
npm install
npm install -D tailwindcss postcss autoprefixer @vitejs/plugin-vue
npm install vue-router axios
npx tailwindcss init -p
```

Jalankan dev server CMS:
```bash
npm run dev
# default: http://localhost:5174
```

## 5) Struktur dasar setelah scaffold

```
backend/   # Laravel API backend
frontend/  # Vue.js website public (port 5173)
cms/       # Vue.js CMS admin panel (port 5174)
```

## 6) Mengakses CMS Admin Panel

Setelah backend dan CMS berjalan:

1. **Buka browser** dan akses: `http://localhost:5174/login`

2. **Login dengan kredensial admin** (setelah membuat user admin di backend):
   - Email: `admin@ucb.com` (atau sesuai yang dibuat)
   - Password: (password yang dibuat)

3. **Setelah login**, Anda akan diarahkan ke dashboard CMS di: `http://localhost:5174/dashboard`

4. **Fitur CMS yang tersedia:**
   - Dashboard - Overview statistik
   - Artikel - Kelola artikel dan berita
   - Galeri - Upload dan kelola foto
   - Video - Tambah dan kelola video
   - Event - Buat dan kelola jadwal event
   - Musik - Kelola repertoire musik
   - Media Library - Kelola semua media
   - Settings - Pengaturan website

## 7) Environment Variables

**Frontend (Website Public):**
Buat file `.env` di `frontend/`:
```
VITE_API_URL=http://127.0.0.1:8000/api
```

**CMS (Admin Panel):**
Buat file `.env` di `cms/`:
```
VITE_API_URL=http://127.0.0.1:8000/api
```

## 8) Langkah berikutnya

- Implementasi auth di backend (Laravel Sanctum)
- Buat user admin pertama melalui seeder atau register endpoint
- Tambah routes & controllers (artikel, galeri, jadwal, dsb.)
- Setup CORS & middleware auth
- Implementasi CRUD untuk setiap modul CMS

