# Laporan Progres Tugas Besar

Tanggal: 2025-12-07

## 1. Deskripsi Tugas
- Tujuan: Membuat sebuah aplikasi minimarket sederhana dengan fungsi CRUD minimal menggunakan framework (Laravel).
- Ruang lingkup minimum: manajemen produk (CRUD), pelanggan, keranjang belanja, proses checkout, otentikasi pengguna (customer/admin), dan antarmuka web responsif (TailwindCSS).

## 2. Perancangan (Ringkas)
- Arsitektur: Laravel (MVC) dengan database MySQL.
- Komponen utama:
  - Models: `Barang`, `Pelanggan`, `Penjualan`, `DetailPenjualan`, `User`, `CartItem`, `ProductLike`.
  - Controllers: Web product, Cart, Checkout, Auth (customer/admin), Profile, Admin.
  - Views: Blade templates dengan Tailwind (landing, shop, product, cart, checkout, profile, admin).
  - Routes: `web.php` mendefinisikan route publik, auth, dan admin.
  - Migrations & Seeders: Buat skema tabel dari dump SQL + tabel tambahan (users, cart_items, product_likes, kolom profile, status/admin_note pada penjualan).

## 3. Progres Pengerjaan sampai Hari Ini
- Scaffold Laravel + struktur proyek: selesai (models, migrations, controllers, views ditambahkan).
- Produk: field `description` dan `image_url` ditambahkan; seeder produk tersedia.
- Tailwind: layout dasar dan halaman shop/product dibuat.
- Keranjang: `cart_items` table dibuat; logika untuk menyimpan keranjang per-user (serta fallback session untuk guest) diimplementasikan.
- Checkout:
  - Mendukung guest checkout dan checkout untuk user terotentikasi.
  - Checkout membuat `penjualan` dan `detail_penjualan` dan mengurangi stok.
  - Menyimpan koordinat lokasi (latitude/longitude) dan menambah reverse-geocoding untuk mengisi alamat dari klik peta (Leaflet + Nominatim).
- Auth & Profile:
  - Autentikasi sederhana berbasis session (customer/admin) dibuat.
  - Halaman profil (lihat/edit) ditambahkan, termasuk upload foto (disimpan di `storage/app/public/profiles`).
  - Session disegarkan setelah edit profil supaya nama & avatar tampil di nav.
- Likes: Implementasi `product_likes` dan tombol (ikon hati) pada halaman produk yang berubah tampilan saat liked.
- Admin: Halaman admin untuk melihat dan memperbarui status pesanan; `admin_note` field ditambahkan di `penjualan`.

## 4. Status Debug & Penyempurnaan (Saat Ini)
- Selesai / Terverifikasi:
  - Banyak file dan fitur dasar berfungsi (tampilan, CRUD produk minimal, tambah ke keranjang, checkout dasar, profile edit, like toggle via form reload).
  - Global submit-guard ditambahkan agar mencegah double-submit form.
  - Leaflet peta ditambahkan pada halaman checkout dan reverse-geocode diimplementasikan untuk mengisi alamat ketika user mengklik peta.
- Masih dalam penyempurnaan / diketahui issue:
  - Sinkronisasi keranjang saat login (merge session cart → `cart_items`) belum otomatis; ini direkomendasikan untuk ditambahkan.
  - Notifikasi ketika admin menambahkan `admin_note` belum dikirimkan ke pelanggan (email atau in-app belum diimplementasikan).
  - Beberapa flow masih menggunakan fallback session; perlu konsolidasi penuh ke `cart_items` untuk user terautentikasi.
  - Untuk menampilkan foto profil, pastikan `php artisan storage:link` dijalankan sehingga `storage` dapat diakses via web.

## 5. Perbaikan yang Telah Dilakukan untuk Bug yang Dilaporkan
- Menghilangkan duplikasi render pada view checkout (duplikat `@extends` dan `@section`) sehingga form tidak dirender ganda.
- Menambahkan `type="submit"` pada tombol checkout dan global submit-guard (mencegah submit berulang).
- Menambahkan `@stack('styles')` dan `@stack('scripts')` pada layout agar skrip Leaflet dan inisialisasi peta dieksekusi.
- Menambahkan reverse-geocoding (Nominatim) untuk mengisi field alamat saat peta diklik.
- Memperbaiki logika profil/penjualan agar jika `pelanggan.user_id` belum diisi, sistem mencoba mencocokkan berdasarkan nama sehingga histori pesanan lama muncul.
- Pada view admin, placeholder seperti `customer`/`guest` disembunyikan untuk tampilan yang lebih bersih.

## 6. Langkah Selanjutnya yang Direkomendasikan
1. Implementasikan merge session cart → `cart_items` saat user login (mencegah kehilangan keranjang saat login).
2. Tambahkan AJAX untuk toggle like (UI tanpa reload) untuk UX yang lebih baik.
3. Implementasikan notifikasi ketika admin menambahkan `admin_note` (pilih: email atau in-app).
4. Backfill/repair data: jalankan skrip safe untuk mengaitkan `pelanggan.user_id` berdasarkan kecocokan nama/no_telp untuk memperbaiki histori lama.
5. Tambahkan validasi dan sanitasi lebih kuat pada input alamat/koordinat dan tambahkan test end-to-end untuk proses checkout.

## 7. Cara Menjalankan / Verifikasi Singkat
1. Pastikan `.env` terkonfigurasi ke MySQL dan database dibuat/import dump jika diperlukan.
2. Jalankan migrasi dan seeder:
```powershell
php artisan migrate
php artisan db:seed
```
3. Jika Anda menggunakan session driver `database`, buat tabel sessions:
```powershell
php artisan session:table
php artisan migrate
```
Atau ubah `SESSION_DRIVER=file` di `.env` untuk menghindari kebutuhan tabel `sessions`.
4. Buat link storage agar foto profil dapat diakses:
```powershell
php artisan storage:link
```
5. Jalankan server:
```powershell
php artisan serve
```

## 8. Kesimpulan Singkat
Proyek sudah memiliki fondasi yang lengkap: models, controllers, views, Tailwind UI, serta alur utama belanja dan checkout. Saat ini pekerjaan memasuki fase debug dan penyempurnaan (perbaikan UX, sync cart, notifikasi, dan backfill data historis). Langkah-langkah prioritas yang disarankan adalah: merge cart-on-login, notifikasi admin-note, dan perbaikan data pelanggan agar histori pesanan tampil konsisten.

---
Jika Anda mau, saya bisa langsung mengimplementasikan salah satu langkah prioritas di atas sekarang (mis. merge cart-on-login). Pilih yang mau diprioritaskan.
