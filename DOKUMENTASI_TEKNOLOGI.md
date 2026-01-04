# DOKUMENTASI TEKNOLOGI SISTEM INFORMASI POINT OF SALE RESTORAN

## BAB III - ANALISIS TEKNOLOGI YANG DIGUNAKAN

---

### 3.1 Spesifikasi Perangkat Lunak

Berikut adalah daftar perangkat lunak yang digunakan dalam pengembangan Sistem Informasi Point of Sale Restoran:

| No  | Perangkat Lunak    | Versi | Keterangan                                    |
| --- | ------------------ | ----- | --------------------------------------------- |
| 1   | PHP                | 8.2   | Bahasa pemrograman server-side                |
| 2   | Laravel Framework  | 12.0  | Framework PHP untuk pengembangan aplikasi web |
| 3   | MySQL/SQLite       | -     | Sistem manajemen basis data relasional        |
| 4   | Composer           | -     | Dependency manager untuk PHP                  |
| 5   | Node.js            | -     | Runtime JavaScript untuk build tools          |
| 6   | NPM                | -     | Package manager untuk JavaScript              |
| 7   | Visual Studio Code | -     | Integrated Development Environment (IDE)      |
| 8   | Git                | -     | Version control system                        |

---

### 3.2 Teknologi Backend

#### 3.2.1 Laravel Framework

Laravel merupakan framework PHP yang digunakan sebagai fondasi utama pengembangan sistem ini. Laravel dipilih karena menyediakan arsitektur MVC (Model-View-Controller) yang terstruktur, fitur keamanan bawaan, dan ekosistem yang lengkap.

**Komponen Laravel yang Digunakan:**

| No  | Komponen              | Fungsi                                                    |
| --- | --------------------- | --------------------------------------------------------- |
| 1   | Eloquent ORM          | Object-Relational Mapping untuk interaksi dengan database |
| 2   | Blade Template Engine | Template engine untuk rendering tampilan                  |
| 3   | Laravel Migration     | Pengelolaan versi skema database                          |
| 4   | Laravel Seeder        | Pengisian data awal (seeding) database                    |
| 5   | Laravel Middleware    | Lapisan penanganan request HTTP                           |
| 6   | Laravel Routing       | Sistem routing URL aplikasi                               |
| 7   | Laravel Tinker        | REPL (Read-Eval-Print Loop) untuk debugging               |

#### 3.2.2 Library Tambahan Backend

| No  | Library                        | Versi | Fungsi                                       |
| --- | ------------------------------ | ----- | -------------------------------------------- |
| 1   | barryvdh/laravel-dompdf        | 3.1   | Pembuatan dokumen PDF untuk struk pembayaran |
| 2   | simplesoftwareio/simple-qrcode | 4.2   | Pembuatan QR Code untuk identifikasi meja    |

---

### 3.3 Teknologi Frontend

#### 3.3.1 Tailwind CSS

Tailwind CSS versi 4.0 digunakan sebagai framework CSS utama. Tailwind CSS merupakan utility-first CSS framework yang memungkinkan pengembangan antarmuka pengguna yang responsif dan modern.

#### 3.3.2 Komponen Frontend

| No  | Teknologi           | Versi  | Fungsi                            |
| --- | ------------------- | ------ | --------------------------------- |
| 1   | Tailwind CSS        | 4.0.0  | Framework CSS utility-first       |
| 2   | Vite                | 7.0.4  | Build tool dan development server |
| 3   | Axios               | 1.11.0 | HTTP client untuk komunikasi AJAX |
| 4   | Font Awesome        | 6.4.0  | Library ikon antarmuka pengguna   |
| 5   | Laravel Vite Plugin | 2.0.0  | Integrasi Vite dengan Laravel     |

#### 3.3.3 Blade Template Engine

Blade merupakan template engine bawaan Laravel yang digunakan untuk membuat tampilan dinamis. Blade menyediakan fitur seperti template inheritance, komponen, dan direktif yang memudahkan pengembangan antarmuka.

---

### 3.4 Sistem Basis Data

#### 3.4.1 Konfigurasi Database

Sistem ini mendukung beberapa driver database, yaitu:

| No  | Database   | Keterangan                                    |
| --- | ---------- | --------------------------------------------- |
| 1   | SQLite     | Database ringan untuk pengembangan lokal      |
| 2   | MySQL      | Database relasional untuk lingkungan produksi |
| 3   | MariaDB    | Alternatif MySQL dengan kompatibilitas penuh  |
| 4   | PostgreSQL | Database relasional tingkat enterprise        |

#### 3.4.2 Struktur Tabel Database

Berikut adalah tabel-tabel yang digunakan dalam sistem:

| No  | Nama Tabel      | Keterangan                                |
| --- | --------------- | ----------------------------------------- |
| 1   | users           | Menyimpan data pengguna/admin sistem      |
| 2   | categories      | Menyimpan data kategori menu              |
| 3   | menus           | Menyimpan data menu makanan dan minuman   |
| 4   | tables          | Menyimpan data meja restoran              |
| 5   | orders          | Menyimpan data pesanan pelanggan          |
| 6   | order_items     | Menyimpan detail item dalam pesanan       |
| 7   | payment_methods | Menyimpan metode pembayaran yang tersedia |
| 8   | transactions    | Menyimpan data transaksi pembayaran       |
| 9   | sessions        | Menyimpan data sesi pengguna              |

---

### 3.5 Arsitektur Sistem

#### 3.5.1 Pola Arsitektur MVC

Sistem ini mengimplementasikan pola arsitektur Model-View-Controller (MVC) yang terdiri dari:

**A. Model**

Model bertanggung jawab untuk mengelola data dan logika bisnis. Berikut adalah model yang digunakan:

| No  | Model         | Fungsi                         |
| --- | ------------- | ------------------------------ |
| 1   | User          | Mengelola data pengguna sistem |
| 2   | Category      | Mengelola data kategori menu   |
| 3   | Menu          | Mengelola data menu restoran   |
| 4   | Table         | Mengelola data meja restoran   |
| 5   | Order         | Mengelola data pesanan         |
| 6   | OrderItem     | Mengelola detail item pesanan  |
| 7   | PaymentMethod | Mengelola metode pembayaran    |
| 8   | Transaction   | Mengelola data transaksi       |

**B. View**

View bertanggung jawab untuk menampilkan data kepada pengguna. Struktur view terbagi menjadi:

| No  | Direktori           | Keterangan                        |
| --- | ------------------- | --------------------------------- |
| 1   | views/admin         | Tampilan untuk panel administrasi |
| 2   | views/user          | Tampilan untuk pelanggan          |
| 3   | views/admin/layouts | Template layout admin             |

**C. Controller**

Controller bertanggung jawab sebagai penghubung antara Model dan View. Berikut adalah controller yang digunakan:

| No  | Controller              | Fungsi                             |
| --- | ----------------------- | ---------------------------------- |
| 1   | AuthController          | Menangani autentikasi admin        |
| 2   | DashboardController     | Mengelola halaman dashboard        |
| 3   | MenuController          | Mengelola operasi CRUD menu        |
| 4   | CategoryController      | Mengelola operasi CRUD kategori    |
| 5   | TableController         | Mengelola operasi CRUD meja        |
| 6   | OrderController         | Mengelola pesanan (admin)          |
| 7   | PaymentMethodController | Mengelola metode pembayaran        |
| 8   | ReportController        | Mengelola laporan penjualan        |
| 9   | HomeController          | Mengelola halaman utama pelanggan  |
| 10  | UserOrderController     | Mengelola pemesanan oleh pelanggan |

#### 3.5.2 Service Layer

Sistem ini juga mengimplementasikan Service Layer untuk memisahkan logika bisnis kompleks:

| No  | Service        | Fungsi                                 |
| --- | -------------- | -------------------------------------- |
| 1   | BarcodeService | Menangani pembuatan QR Code untuk meja |

---

### 3.6 Perangkat Pengujian

| No  | Tools                | Versi  | Fungsi                                 |
| --- | -------------------- | ------ | -------------------------------------- |
| 1   | PHPUnit              | 11.5.3 | Framework pengujian unit untuk PHP     |
| 2   | Mockery              | 1.6    | Library untuk membuat mock object      |
| 3   | FakerPHP             | 1.23   | Library untuk menghasilkan data dummy  |
| 4   | Laravel Pint         | 1.24   | Code style fixer sesuai standar PSR-12 |
| 5   | Nunomaduro/Collision | 8.6    | Pelaporan error yang lebih informatif  |

---

### 3.7 Perangkat Development

| No  | Tools        | Versi | Fungsi                                     |
| --- | ------------ | ----- | ------------------------------------------ |
| 1   | Laravel Sail | 1.41  | Docker development environment             |
| 2   | Laravel Pail | 1.2.2 | Real-time log viewer                       |
| 3   | Concurrently | 9.0.1 | Menjalankan multiple script secara paralel |

---

### 3.8 Fitur Utama Sistem

Berdasarkan analisis struktur proyek, sistem Point of Sale Restoran ini memiliki fitur-fitur sebagai berikut:

| No  | Fitur              | Deskripsi                                        |
| --- | ------------------ | ------------------------------------------------ |
| 1   | Manajemen Menu     | Pengelolaan data menu makanan dan minuman (CRUD) |
| 2   | Manajemen Kategori | Pengelolaan kategori menu                        |
| 3   | Manajemen Meja     | Pengelolaan data meja dengan QR Code unik        |
| 4   | Sistem Pemesanan   | Proses pemesanan dengan tracking status          |
| 5   | Metode Pembayaran  | Pengelolaan berbagai metode pembayaran           |
| 6   | Laporan Penjualan  | Pembuatan laporan transaksi                      |
| 7   | Cetak Struk PDF    | Pembuatan struk pembayaran dalam format PDF      |
| 8   | Scan QR Code Meja  | Pelanggan dapat scan QR meja untuk memesan       |
| 9   | Autentikasi Admin  | Sistem login untuk administrator                 |
| 10  | Dashboard          | Ringkasan informasi dan statistik                |

---

### 3.9 Alur Kerja Sistem

#### 3.9.1 Alur Pemesanan Pelanggan

1. Pelanggan melakukan scan QR Code pada meja
2. Sistem menampilkan halaman pemesanan dengan daftar menu
3. Pelanggan memilih menu dan memasukkan data pesanan
4. Sistem menyimpan pesanan dan menampilkan konfirmasi
5. Pelanggan dapat melihat status pesanan secara real-time
6. Setelah selesai, pelanggan dapat melihat dan mencetak struk

#### 3.9.2 Alur Pengelolaan Admin

1. Admin melakukan login ke sistem
2. Admin dapat mengelola menu, kategori, meja, dan metode pembayaran
3. Admin dapat melihat dan memproses pesanan yang masuk
4. Admin dapat mengubah status pesanan dan pembayaran
5. Admin dapat melihat laporan penjualan

---

### 3.10 Kesimpulan Teknologi

Sistem Informasi Point of Sale Restoran ini dibangun menggunakan teknologi modern berbasis web dengan arsitektur yang terstruktur. Penggunaan Laravel Framework sebagai backend memberikan fondasi yang kuat untuk pengembangan fitur-fitur kompleks, sementara Tailwind CSS dan Vite menyediakan pengalaman pengembangan frontend yang efisien. Integrasi dengan library tambahan seperti DomPDF dan Simple QRCode mendukung fitur-fitur khusus seperti pencetakan struk dan pembuatan kode QR untuk identifikasi meja.

---

_Dokumen ini dibuat sebagai bagian dari dokumentasi teknis Sistem Informasi Point of Sale Restoran._
