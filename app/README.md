# UCB Website - Aplikasi Gabungan

Aplikasi Vue.js yang menggabungkan frontend website dan CMS admin dalam satu aplikasi.

## Struktur

- **Public Routes** (`/`): Website publik untuk pengunjung
- **Admin Routes** (`/admin/*`): CMS untuk administrator

## Instalasi

```bash
npm install
```

## Menjalankan Development Server

```bash
npm run dev
```

Aplikasi akan berjalan di `http://localhost:5173`

- Website publik: `http://localhost:5173/`
- CMS Admin: `http://localhost:5173/admin/login`

## Build untuk Production

```bash
npm run build
```

## Struktur Folder

```
app/
├── src/
│   ├── views/
│   │   ├── public/     # Views untuk website publik
│   │   └── admin/      # Views untuk CMS admin
│   ├── layouts/        # Layout components
│   ├── lib/           # API client dan utilities
│   ├── router/        # Vue Router configuration
│   └── utils/         # Utility functions
├── public/            # Static assets
└── package.json
```

## Routing

### Public Routes
- `/` - Homepage
- `/gallery` - Gallery
- `/videos` - Videos
- `/schedule` - Schedule & Events
- `/news` - News/Articles
- `/news/:slug` - Article Detail
- `/members` - Members
- `/contact` - Contact
- `/join` - Join Application

### Admin Routes (memerlukan autentikasi)
- `/admin/login` - Login page
- `/admin/dashboard` - Dashboard
- `/admin/articles` - Manage Articles
- `/admin/gallery` - Manage Gallery
- `/admin/videos` - Manage Videos
- `/admin/events` - Manage Events
- `/admin/members` - Manage Members
- `/admin/promosi` - Manage Promotions
- Dan lainnya...

## Environment Variables

Buat file `.env` di root folder `app/`:

```
VITE_API_URL=http://localhost:8000/api
```

## Catatan

- Semua route admin memerlukan autentikasi (token di localStorage)
- Jika token tidak ada, user akan di-redirect ke `/admin/login`
- Website publik tidak memerlukan autentikasi


