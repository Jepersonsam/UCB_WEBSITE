# UCB Website – Vue (Vite) + Laravel + MySQL

Stack yang akan digunakan:

- Frontend: Vue 3 (Vite, SPA), npm
- Backend: Laravel (PHP)
- Database: MySQL

## Langkah cepat

1) Inisialisasi backend (Laravel)  
2) Inisialisasi frontend (Vite + Vue)  
3) Konfigurasi `.env` untuk MySQL dan API base URL  
4) Jalankan dev servers

Detail perintah ada di `SETUP.md`.

## Struktur folder yang disarankan

```
UCBWebsite/
├── backend/   # Laravel API
└── frontend/  # Vue SPA (Vite)
```

## Apa selanjutnya

- Jalankan langkah di `SETUP.md` untuk bootstrap project.
- Setelah scaffold, tambahkan konfigurasi CORS di Laravel agar mengizinkan origin `http://localhost:5173`.
- Mulai dari auth dan halaman dasar (home) di frontend.

