# EHF KASIR - Sistem Point of Sale Restoran

Sistem informasi Point of Sale (POS) berbasis web untuk manajemen restoran dengan fitur pemesanan meja menggunakan QR Code.

---

## Daftar Isi

-   [Tentang Proyek](#tentang-proyek)
-   [Fitur Utama](#fitur-utama)
-   [Teknologi yang Digunakan](#teknologi-yang-digunakan)
-   [Persyaratan Sistem](#persyaratan-sistem)
-   [Instalasi](#instalasi)
-   [Konfigurasi](#konfigurasi)
-   [Penggunaan](#penggunaan)
-   [Struktur Proyek](#struktur-proyek)
-   [Lisensi](#lisensi)

---

## Tentang Proyek

EHF KASIR adalah aplikasi Point of Sale (POS) yang dirancang khusus untuk kebutuhan restoran. Sistem ini memungkinkan pelanggan untuk melakukan pemesanan secara mandiri dengan cara scan QR Code pada meja, sementara admin dapat mengelola menu, meja, pesanan, dan melihat laporan penjualan melalui panel administrasi.

---

## Fitur Utama

### A. Panel Administrasi

#### 1. Dashboard

-   Statistik total menu, meja, dan pesanan
-   Total pendapatan keseluruhan
-   Jumlah pesanan hari ini
-   Pendapatan hari ini
-   Daftar 5 pesanan terbaru

#### 2. Manajemen Menu

-   Tambah menu baru dengan gambar
-   Edit informasi menu (nama, harga, deskripsi)
-   Hapus menu
-   Atur kategori menu
-   Atur status ketersediaan menu (tersedia/tidak tersedia)

#### 3. Manajemen Kategori

-   Tambah kategori menu baru
-   Edit nama kategori
-   Hapus kategori
-   Lihat daftar menu per kategori

#### 4. Manajemen Meja

-   Tambah meja baru dengan nomor unik
-   Edit informasi meja
-   Hapus meja
-   Atur kapasitas meja
-   Atur status meja (tersedia/terisi/reserved)
-   Generate QR Code untuk setiap meja
-   Generate QR Code dengan logo
-   Download QR Code dalam format gambar
-   Regenerate semua QR Code sekaligus

#### 5. Manajemen Pesanan

-   Lihat daftar semua pesanan
-   Filter pesanan berdasarkan status
-   Lihat detail pesanan lengkap
-   Update status pesanan (pending, preparing, ready, completed, cancelled)
-   Update status pembayaran (unpaid, paid)
-   Quick action untuk aksi cepat
-   Bulk update status untuk multiple pesanan
-   Cetak struk pesanan

#### 6. Manajemen Metode Pembayaran

-   Tambah metode pembayaran baru
-   Edit informasi metode pembayaran
-   Hapus metode pembayaran
-   Atur status aktif/nonaktif

#### 7. Laporan Penjualan

-   Filter laporan berdasarkan rentang tanggal
-   Total pendapatan dalam periode
-   Total pesanan dalam periode
-   Pesanan yang sudah selesai
-   Rata-rata nilai pesanan
-   Tingkat penyelesaian pesanan
-   Grafik penjualan harian
-   Top 10 menu terlaris
-   Breakdown berdasarkan metode pembayaran
-   Export laporan ke PDF

#### 8. Autentikasi Admin

-   Halaman login admin
-   Logout admin
-   Proteksi route dengan middleware

### B. Sisi Pelanggan

#### 1. Halaman Utama

-   Informasi restoran
-   Panduan cara pemesanan
-   Instruksi scan QR Code

#### 2. Scan QR Code Meja

-   Akses menu otomatis setelah scan
-   Validasi status meja
-   Halaman meja tidak tersedia

#### 3. Pemesanan Menu

-   Tampilan daftar menu dengan gambar
-   Filter menu berdasarkan kategori
-   Tambah item ke keranjang
-   Atur jumlah pesanan
-   Input nama pelanggan
-   Input catatan pesanan
-   Pilih metode pembayaran
-   Konfirmasi pesanan

#### 4. Konfirmasi Pesanan

-   Detail pesanan lengkap
-   Nomor pesanan unik
-   Informasi meja
-   Daftar item yang dipesan
-   Total pembayaran

#### 5. Status Pesanan

-   Tracking status pesanan real-time
-   Status: Pending, Preparing, Ready, Completed

#### 6. Struk Digital

-   Tampilan struk pembayaran
-   Informasi lengkap pesanan
-   Opsi cetak struk

---

## Teknologi yang Digunakan

### Backend

| Teknologi         | Versi |
| ----------------- | ----- |
| PHP               | 8.2+  |
| Laravel Framework | 12.0  |
| Eloquent ORM      | -     |

### Frontend

| Teknologi      | Versi |
| -------------- | ----- |
| Tailwind CSS   | 4.0   |
| Vite           | 7.0   |
| Blade Template | -     |
| Font Awesome   | 6.4   |

### Database

| Teknologi | Keterangan  |
| --------- | ----------- |
| SQLite    | Development |
| MySQL     | Production  |

### Library Tambahan

| Library                        | Fungsi                |
| ------------------------------ | --------------------- |
| barryvdh/laravel-dompdf        | Generate PDF struk    |
| simplesoftwareio/simple-qrcode | Generate QR Code meja |

---

## Persyaratan Sistem

-   PHP >= 8.2
-   Composer
-   Node.js >= 18
-   NPM atau Yarn
-   MySQL / SQLite

---

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/pos-restoran.git
cd pos-restoran
```

### 2. Install Dependensi PHP

```bash
composer install
```

### 3. Install Dependensi JavaScript

```bash
npm install
```

### 4. Salin File Environment

```bash
cp .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pos_restoran
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Jalankan Migrasi dan Seeder

```bash
php artisan migrate --seed
```

### 8. Buat Symbolic Link Storage

```bash
php artisan storage:link
```

### 9. Build Asset Frontend

```bash
npm run build
```

---

## Konfigurasi

### Menjalankan Development Server

```bash
# Jalankan semua service sekaligus
composer dev

# Atau jalankan secara terpisah
php artisan serve
npm run dev
```

### Akses Aplikasi

| Halaman       | URL                               |
| ------------- | --------------------------------- |
| Halaman Utama | http://localhost:8000             |
| Panel Admin   | http://localhost:8000/admin/login |

---

## Penggunaan

### Login Admin

Gunakan kredensial default setelah menjalankan seeder:

```
Email: admin@example.com
Password: password
```

### Alur Kerja

1. **Admin** login dan mengatur menu, kategori, dan meja
2. **Admin** generate QR Code untuk setiap meja
3. **Pelanggan** scan QR Code pada meja
4. **Pelanggan** memilih menu dan melakukan pemesanan
5. **Admin** memproses pesanan dan mengubah status
6. **Pelanggan** melihat status dan mencetak struk

---

## Struktur Proyek

```
pos-restoran/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Controller panel admin
│   │   │   └── User/           # Controller sisi pelanggan
│   │   └── Middleware/
│   ├── Models/                 # Model Eloquent
│   └── Services/               # Service layer
├── database/
│   ├── migrations/             # File migrasi database
│   └── seeders/                # File seeder
├── resources/
│   ├── views/
│   │   ├── admin/              # View panel admin
│   │   └── user/               # View pelanggan
│   ├── css/
│   └── js/
├── routes/
│   └── web.php                 # Definisi routing
├── public/
│   └── storage/                # File upload dan QR Code
└── ...
```

---

## Testing

Jalankan unit test dengan perintah:

```bash
php artisan test
```

atau

```bash
composer test
```

---

## Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

Dibuat dengan Laravel
