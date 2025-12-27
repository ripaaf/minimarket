# Minimarket Laravel App

Panduan singkat untuk menjalankan proyek Laravel ini secara lokal.

## Prasyarat
- PHP 8.1+ dengan ekstensi umum Laravel (openssl, pdo, mbstring, tokenizer, xml, ctype, json, gd jika perlu gambar)
- Composer
- MySQL/MariaDB (atau DB lain yang dikonfigurasi di `config/database.php`)

## Langkah Setup
1) **Masuk folder proyek**
```bash
cd minimarket
```

2) **Salin env**
```bash
cp .env.example .env
```

3) **Set kunci aplikasi**
```bash
php artisan key:generate
```

4) **Konfigurasi database**
Edit `.env` untuk `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` sesuai koneksi lokal Anda.

5) **Install dependencies**
```bash
composer install
```

6) **Jalankan migrasi & seed** (mengisi data dasar, tanpa order bawaan)
```bash
php artisan migrate --seed
```
Jika ingin reset total:
```bash
php artisan migrate:fresh --seed
```

7) **Buat symlink storage publik**
```bash
php artisan storage:link
```

8) **Jalankan server lokal**
```bash
php artisan serve
```
Aplikasi aktif di http://127.0.0.1:8000 (atau port yang tertera).

## Ringkas Perintah Utama
```bash
# migrasi
php artisan migrate

# seed data contoh
php artisan db:seed

# buat symlink storage publik
php artisan storage:link

# jalankan server lokal
php artisan serve
```

## Akun & Data Awal
- Seeder membuat user dasar (lihat `database/seeders/UserSeeder.php`).
- Produk contoh beserta URL gambar ada di `database/seeders/BarangSeeder.php`.
- Seeder **tidak** membuat order bawaan (penjualan/detail_penjualan tidak dipanggil di DatabaseSeeder).

## Testing
```bash
php artisan test
```

## Tip Pengembangan
- Jika mengubah env/konfigurasi cache, jalankan: `php artisan config:clear` dan `php artisan cache:clear`.
- Jika storage symlink dibutuhkan untuk file upload: `php artisan storage:link`.
- Untuk cek log: `storage/logs/laravel.log`.

## Masalah Umum
- Aset tidak muncul: pastikan `npm run dev`/`build` sudah jalan dan URL Vite sesuai di `.env` (`VITE_APP_URL`).
- Error DB: cek kredensial `.env` dan pastikan DB sudah dibuat.
