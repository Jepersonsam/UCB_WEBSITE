# UCB Website - Frontend

Frontend aplikasi UCB Website menggunakan Vue.js 3 + TypeScript + Vite.

## 🛠️ Tech Stack

- **Framework**: Vue.js 3.5.26
- **Routing**: Vue Router 4.6.4
- **Language**: TypeScript ~5.9.3
- **Build Tool**: Vite 7.2.4
- **Styling**: Tailwind CSS 4.0.0
- **HTTP Client**: Axios
- **UI Libraries**: SweetAlert2, AOS (Animate On Scroll)

## 📁 Struktur Folder

```
frontend/
├── src/
│   ├── assets/          # Static assets (CSS, images)
│   │   └── css/
│   ├── components/     # Vue components (jika ada)
│   ├── layouts/        # Layout components
│   ├── lib/            # Utilities & libraries
│   │   └── api/        # API client
│   ├── router/         # Vue Router configuration
│   ├── utils/          # Utility functions
│   ├── views/          # Page views
│   │   ├── admin/      # Admin views
│   │   └── public/     # Public views
│   ├── App.vue         # Root component
│   ├── main.ts         # Entry point
│   └── bootstrap.js    # Bootstrap file
├── public/             # Public static files
├── index.html          # HTML entry point
├── package.json        # Dependencies
├── tsconfig.json       # TypeScript config
└── vite.config.js      # Vite configuration
```

## 🚀 Instalasi

### Prasyarat
- Node.js (v18 atau lebih baru)
- npm atau yarn

### Langkah Instalasi

1. **Install dependencies**
```bash
cd frontend
npm install
```

2. **Setup environment**
```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan URL backend API:
```env
VITE_API_URL=http://localhost:8000/api
```

## 🏃 Development

Jalankan development server:

```bash
npm run dev
```

Frontend akan berjalan di `http://localhost:5173`

**Catatan**: Pastikan backend API sudah berjalan di `http://localhost:8000`

## 🏗️ Build untuk Production

```bash
npm run build
```

Output build akan ada di folder `dist/`

Untuk preview build:
```bash
npm run preview
```

## 📝 Routes

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

## 🔌 API Integration

Frontend berkomunikasi dengan backend melalui REST API. Konfigurasi API URL ada di:
- Environment variable: `VITE_API_URL`
- Default: `http://localhost:8000/api`

API client ada di `src/lib/api/client.ts` yang menggunakan Axios dengan:
- Automatic token injection dari localStorage
- Error handling untuk 401 (unauthorized)
- Request/Response interceptors

## 📚 Dokumentasi Terkait

- [Backend README](../app/README.md) - Dokumentasi backend Laravel
- [Main README](../README.md) - Dokumentasi utama project
