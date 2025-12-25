# Instruksi Menambahkan Logo UCB

## Langkah-langkah:

1. **Simpan file logo** dengan nama `logo-ucb.png` di folder berikut:
   - `frontend/public/logo-ucb.png`
   - `cms/public/logo-ucb.png`

2. **Format logo yang direkomendasikan:**
   - Format: PNG dengan transparansi (background transparan)
   - Ukuran: Minimal 512x512px untuk kualitas tinggi
   - Nama file: `logo-ucb.png`

3. **Logo akan otomatis digunakan di:**
   - Header website (frontend)
   - Sidebar CMS
   - Login page CMS
   - Semua halaman yang menampilkan logo

4. **Fallback:**
   - Jika logo tidak ditemukan, akan menampilkan teks "UCB" sebagai fallback

## Lokasi File Logo:

```
UCBWebsite/
├── frontend/
│   └── public/
│       └── logo-ucb.png  ← Simpan logo di sini
└── cms/
    └── public/
        └── logo-ucb.png  ← Simpan logo di sini (copy yang sama)
```

## Catatan:

- Logo akan otomatis di-resize sesuai kebutuhan
- Pastikan logo memiliki background transparan untuk tampilan terbaik
- Logo akan terlihat di semua halaman website dan CMS setelah file ditambahkan

