# Mainkode Official Website

A modular PHP-based project by **Muhamad Naufal**.

## Struktur Proyek

```
mainkode/
├── admin/              # Panel admin / kontrol
├── assets/             # File statis (CSS, JS, images)
├── backend/            # Logika backend / koneksi DB
├── components/         # Komponen UI reusable
├── games/              # Modul / mini-games
├── page/               # Halaman utama (routing, view)
├── index.php           # Entry point
└── README.md           # Dokumentasi proyek
```

## Instalasi

1. Clone repo:
   ```bash
   git clone https://github.com/Muhamad-naufal/mainkode.git
   cd mainkode
   ```
2. Jalankan server lokal:
   ```bash
   php -S localhost:8000
   ```
   atau gunakan XAMPP/Laragon.

3. Sesuaikan konfigurasi database (jika ada) di folder `backend`.

## Teknologi

- **PHP** (>=7.4)
- HTML, CSS, JavaScript
- MySQL/MariaDB (opsional, untuk backend)

## Cara Penggunaan

- Akses `http://localhost:8000` di browser.
- Struktur modular:
  - Tambah halaman baru → simpan di folder `page/`
  - Tambah komponen → simpan di `components/`
  - Tambah logika server → simpan di `backend/`

## Kontribusi

1. Fork repo
2. Buat branch baru (`feature/nama-fitur`)
3. Commit & push perubahan
4. Buat Pull Request

## Lisensi

Proyek ini menggunakan lisensi **MIT**.  
Silakan gunakan, modifikasi, dan distribusikan dengan bebas.
