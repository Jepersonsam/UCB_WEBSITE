# Panduan Deployment ke Railway

File-file ini sudah disiapkan untuk deployment aplikasi UCB Website ke Railway.

## 📋 File yang Dibutuhkan

File-file berikut sudah dibuat:
- `Dockerfile` - Multi-stage build untuk Laravel + Vue.js
- `nginx.conf` - Konfigurasi Nginx web server
- `supervisord.conf` - Konfigurasi Supervisor untuk menjalankan PHP-FPM dan Nginx
- `railway.json` - Konfigurasi Railway
- `.railwayignore` - File yang diabaikan saat deployment
- `.dockerignore` - File yang diabaikan saat build Docker

## 🚀 Langkah-langkah Deployment

### 1. Persiapan di Railway

1. Login ke [Railway](https://railway.app)
2. Buat project baru
3. Pilih "Deploy from GitHub repo" atau "Empty Project"

### 2. Setup Environment Variables

Di Railway dashboard, tambahkan environment variables berikut:

#### Database (pilih salah satu)

**Untuk PostgreSQL (Recommended):**
```
DB_CONNECTION=pgsql
DB_HOST=your-postgres-host.railway.app
DB_PORT=5432
DB_DATABASE=railway
DB_USERNAME=postgres
DB_PASSWORD=your-password
```

**Untuk MySQL:**
```
DB_CONNECTION=mysql
DB_HOST=your-mysql-host.railway.app
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=your-password
```

**Untuk SQLite (tidak disarankan untuk production):**
```
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite
```

#### Laravel Configuration
```
APP_NAME="UCB Website"
APP_ENV=production
APP_KEY=base64:your-app-key-here
APP_DEBUG=false
APP_URL=https://your-app.railway.app

LOG_CHANNEL=stderr
LOG_LEVEL=error
```

#### Mail Configuration (opsional)
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@ucbwebsite.com
MAIL_FROM_NAME="${APP_NAME}"
```

#### Frontend API URL
```
VITE_API_URL=https://your-app.railway.app/api
```

**Catatan:** Environment variable `VITE_API_URL` harus di-set di Railway, tapi karena Vite build di Dockerfile, pastikan untuk rebuild jika mengubah nilai ini.

### 3. Generate APP_KEY

Jika belum punya APP_KEY, jalankan di local:
```bash
cd backend
php artisan key:generate --show
```

Copy output-nya dan set sebagai `APP_KEY` di Railway.

### 4. Setup Database

Setelah deployment pertama kali, jalankan migration:
```bash
# Masuk ke Railway shell atau gunakan Railway CLI
railway run php artisan migrate --force
```

Atau bisa juga setup database service di Railway dan otomatis akan terhubung.

### 5. Deploy

1. Connect repository GitHub ke Railway
2. Railway akan otomatis detect `Dockerfile` dan `railway.json`
3. Build akan otomatis dimulai
4. Setelah build selesai, aplikasi akan otomatis deploy

### 6. Setup Custom Domain (Opsional)

1. Di Railway dashboard, pilih service Anda
2. Klik "Settings" > "Networking"
3. Tambahkan custom domain
4. Update `APP_URL` di environment variables

## 🔧 Troubleshooting

### Build Gagal

1. Cek logs di Railway dashboard
2. Pastikan semua environment variables sudah di-set
3. Pastikan `APP_KEY` sudah di-generate

### Database Connection Error

1. Pastikan database service sudah dibuat di Railway
2. Pastikan environment variables database sudah benar
3. Pastikan database sudah di-migrate

### Frontend Tidak Muncul

1. Pastikan build frontend berhasil (cek logs)
2. Pastikan file `public/frontend/index.html` ada
3. Cek nginx logs untuk error

### API Tidak Bekerja

1. Pastikan CORS sudah dikonfigurasi dengan benar
2. Pastikan `VITE_API_URL` sudah di-set dengan benar
3. Cek Laravel logs untuk error

## 📝 Catatan Penting

1. **Storage**: File upload akan disimpan di `/var/www/html/storage/app/public`. Untuk production, pertimbangkan menggunakan cloud storage (S3, dll).

2. **Environment Variables**: Pastikan semua environment variables sudah di-set sebelum deployment pertama kali.

3. **Database**: Railway menyediakan PostgreSQL dan MySQL. Pilih salah satu dan setup dengan benar.

4. **Build Time**: Build pertama kali mungkin memakan waktu lama karena harus install semua dependencies.

5. **Port**: Railway akan otomatis assign port. Aplikasi dikonfigurasi untuk listen di port 8080 (internal), Railway akan handle port mapping.

## 🔄 Update Deployment

Untuk update aplikasi:
1. Push perubahan ke GitHub
2. Railway akan otomatis detect perubahan dan rebuild
3. Atau bisa trigger manual rebuild di Railway dashboard

## 📚 Referensi

- [Railway Documentation](https://docs.railway.app)
- [Laravel Deployment](https://laravel.com/docs/deployment)
- [Vue.js Deployment](https://vuejs.org/guide/scaling-up/deployment.html)

