# CMS Admin Panel - Unceasing Cantica Bandung

## Setup

1. **Install dependencies:**
   ```bash
   npm install
   ```

2. **Buat file `.env` di folder `cms/`:**
   ```
   VITE_API_URL=http://localhost:8000/api
   ```

3. **Pastikan backend Laravel berjalan:**
   ```bash
   cd ../backend
   php artisan serve
   # Backend akan berjalan di http://localhost:8000
   ```

4. **Jalankan dev server CMS:**
   ```bash
   npm run dev
   # CMS akan berjalan di http://localhost:5174
   ```

## Troubleshooting

### Error: "The route api/v1/auth/login could not be found"

**Solusi:**
1. Pastikan file `.env` ada di folder `cms/` dengan isi:
   ```
   VITE_API_URL=http://localhost:8000/api
   ```

2. Pastikan backend Laravel berjalan di port 8000:
   ```bash
   cd backend
   php artisan serve
   ```

3. Restart dev server CMS setelah membuat/mengubah file `.env`:
   ```bash
   # Hentikan server (Ctrl+C)
   # Jalankan lagi
   npm run dev
   ```

4. Cek console browser untuk melihat URL yang digunakan (harus `http://localhost:8000/api`)

### Error: "Cannot connect to server"

- Pastikan backend Laravel sudah berjalan
- Cek apakah port 8000 tidak digunakan aplikasi lain
- Pastikan CORS sudah dikonfigurasi di backend Laravel

## Login

Setelah backend dan CMS berjalan:
- Buka: `http://localhost:5174/login`
- Login dengan kredensial admin yang sudah dibuat di backend

