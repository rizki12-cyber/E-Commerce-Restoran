# CASA RASA — E-Commerce Restoran

**CASA RASA** merupakan aplikasi e-commerce restoran berbasis web yang dirancang untuk memudahkan pelanggan dalam melihat katalog produk dan melakukan pemesanan makanan secara online.

Project ini dikembangkan menggunakan Laravel dengan tampilan antarmuka modern, bersih, dan responsif.

## Fitur Utama

- **Katalog Produk** — Menampilkan berbagai pilihan produk makanan dan minuman.
- **Detail Produk** — Menyediakan informasi mengenai produk yang dipilih.
- **Pemesanan Online** — Memungkinkan pelanggan melakukan pemesanan melalui website.
- **Keranjang Belanja** — Mengelola produk yang akan dipesan.
- **Checkout** — Proses penyelesaian pesanan pelanggan.
- **Manajemen Admin** — Area pengelolaan aplikasi restoran.

## Teknologi yang Digunakan

| Teknologi | Kegunaan |
|---|---|
| PHP | Bahasa pemrograman backend |
| Laravel 12 | Framework aplikasi |
| MySQL | Basis data |
| Bootstrap 5 | Framework antarmuka |
| JavaScript | Interaksi antarmuka |
| HTML5 & CSS3 | Struktur dan tampilan website |

## Persyaratan Sistem

- PHP 8.2 atau lebih baru
- Composer
- MySQL
- Node.js dan NPM
- Web browser

## Instalasi

1. Clone repository:

   ```bash
   git clone https://github.com/rizki12-cyber/E-Commerce-Restoran.git
   ```

2. Masuk ke direktori project:

   ```bash
   cd E-Commerce-Restoran
   ```

3. Install dependency:

   ```bash
   composer install
   npm install
   ```

4. Salin file konfigurasi:

   ```bash
   cp .env.example .env
   ```

   Untuk Windows PowerShell:

   ```powershell
   Copy-Item .env.example .env
   ```

5. Buat application key:

   ```bash
   php artisan key:generate
   ```

6. Atur konfigurasi database pada file `.env`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. Jalankan migrasi database:

   ```bash
   php artisan migrate
   ```

8. Build asset frontend:

   ```bash
   npm run build
   ```

9. Jalankan aplikasi:

   ```bash
   php artisan serve
   ```

10. Buka aplikasi melalui:

   ```text
   http://127.0.0.1:8000
   ```

## Pengembang

**Rizki**

Project ini dikembangkan sebagai bagian dari pengembangan kemampuan dalam membangun aplikasi web menggunakan Laravel, PHP, dan MySQL.

## Lisensi

Project ini merupakan project pengembangan dan portofolio pribadi.