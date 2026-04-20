# PanenHub

PanenHub adalah platform marketplace agrikultur yang menghubungkan petani lokal dengan pembeli (konsumen) secara langsung. Proyek ini bertujuan untuk membantu Mitra Tani menjual hasil panen mereka, terutama beras, dengan mudah dan aman.

## Fitur Utama

- **Pendaftaran Mitra Tani**: Petani dapat mendaftar dan mengelola profil mereka.
- **Manajemen Produk**: Mitra dapat menambah, mengedit, dan menghapus produk hasil panen.
- **Keranjang Belanja**: Pembeli dapat memilih produk dan memasukkannya ke keranjang.
- **Checkout & Pemesanan**: Sistem pemesanan yang terintegrasi (mendukung Multi-vendor).
- **Manajemen Pesanan**: Mitra dapat memproses pesanan dan mengubah status pengiriman.

## Instalasi

1. Clone repository ini.
2. Jalankan `composer install` untuk menginstall dependensi PHP.
3. Jalankan `npm install` untuk dependensi frontend.
4. Copy file `.env.example` ke `.env` dan sesuaikan konfigurasi database.
5. Jalankan `php artisan key:generate`.
6. Lakukan migrasi database dengan `php artisan migrate --seed`.
7. Jalankan server dengan `php artisan serve` dan `npm run dev`.

## Teknologi

- Laravel
- MySQL
- Bootstrap & TailwindCSS
- Vite
