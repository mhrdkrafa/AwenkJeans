# 👖 Awenk Jeans — Sistem Manajemen Toko

Sistem informasi berbasis web untuk manajemen toko Awenk Jeans yang mencakup Point of Sale (POS), katalog produk online, manajemen stok, laporan penjualan, serta fitur interaksi pelanggan seperti review dan komplain.

---

## 📋 Daftar Isi

- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi](#-instalasi)
- [Role Pengguna](#-role-pengguna)
- [Panduan Penggunaan](#-panduan-penggunaan)
  - [Katalog Publik](#1-katalog-publik-tanpa-login)
  - [Panel Administrator](#2-panel-administrator)
  - [Panel Karyawan](#3-panel-karyawan)
  - [Panel Kasir](#4-panel-kasir)
  - [Panel Owner](#5-panel-owner)
  - [Panel Pelanggan](#6-panel-pelanggan)
- [Integrasi Midtrans](#-integrasi-midtrans)

---

## 💻 Persyaratan Sistem

| Komponen     | Versi Minimum |
|--------------|---------------|
| PHP          | 8.1           |
| Composer     | 2.x           |
| Node.js      | 18.x          |
| MySQL/MariaDB| 8.0 / 10.x   |
| Laravel      | 10.x          |

---

## 🚀 Instalasi

```bash
# 1. Clone repository
git clone <repository-url>
cd AwenkJeans

# 2. Install dependensi PHP
composer install

# 3. Install dependensi frontend
npm install

# 4. Salin file environment
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Konfigurasi database di file .env
#    Sesuaikan DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 7. Jalankan migrasi dan seeder
php artisan migrate --seed

# 8. Build asset frontend
npm run build

# 9. Jalankan server development
php artisan serve
```

Aplikasi akan berjalan di `http://127.0.0.1:8000`.

---

## 👥 Role Pengguna

Sistem memiliki **5 role** pengguna dengan hak akses yang berbeda:

| Role            | Deskripsi                                                         |
|-----------------|-------------------------------------------------------------------|
| **Administrator** | Mengelola produk, kategori, dan akun pengguna                   |
| **Karyawan**      | Mengelola stok, melihat transaksi, review, komplain, dan laporan |
| **Kasir**         | Mengoperasikan Point of Sale (POS) dan mencetak nota            |
| **Owner**         | Melihat dashboard ringkasan dan laporan penjualan               |
| **Pelanggan**     | Melihat riwayat pembelian, memberikan review, dan mengajukan komplain |

---

## 📖 Panduan Penggunaan

### 1. Katalog Publik (Tanpa Login)

Halaman katalog dapat diakses oleh siapa saja tanpa perlu login.

**Akses:** Buka `http://127.0.0.1:8000/katalog`

| Fitur                | Cara Penggunaan                                                                 |
|----------------------|---------------------------------------------------------------------------------|
| **Lihat Katalog**    | Buka halaman utama untuk melihat seluruh produk yang tersedia.                  |
| **Cari Produk**      | Gunakan kolom pencarian di bagian atas. Sistem akan memberikan saran pencarian secara otomatis. |
| **Detail Produk**    | Klik pada produk untuk melihat deskripsi lengkap, harga, ukuran, dan review.   |
| **Tulis Review**     | Di halaman detail produk, login terlebih dahulu lalu isi form review.           |

**Halaman Informasi Tambahan:**
- `/tentang-kami` — Tentang Awenk Jeans
- `/cara-pembelian` — Panduan cara membeli produk
- `/konsultasi-ukuran` — Panduan ukuran celana
- `/kebijakan-privasi` — Kebijakan privasi
- `/syarat-ketentuan` — Syarat dan ketentuan

---

### 2. Panel Administrator

**Akses:** Login → otomatis diarahkan ke `/administrator/dashboard`

Administrator bertanggung jawab atas pengelolaan data master (produk, kategori) dan manajemen akun pengguna.

#### 📦 Manajemen Produk
| Aksi                | Langkah                                                                           |
|---------------------|-----------------------------------------------------------------------------------|
| **Lihat Produk**    | Buka menu **Produk** di sidebar untuk melihat daftar semua produk.                |
| **Tambah Produk**   | Klik tombol **Tambah Produk** → Isi form (nama, kategori, harga, ukuran, deskripsi, foto) → Klik **Simpan**. |
| **Edit Produk**     | Pada daftar produk, klik tombol **Edit** pada produk yang ingin diubah → Ubah data → Klik **Simpan**. |
| **Hapus Produk**    | Pada daftar produk, klik tombol **Hapus** → Konfirmasi penghapusan.              |

#### 🏷️ Manajemen Kategori
| Aksi                  | Langkah                                                                       |
|-----------------------|-------------------------------------------------------------------------------|
| **Lihat Kategori**    | Buka menu **Kategori** di sidebar.                                            |
| **Tambah Kategori**   | Klik **Tambah Kategori** → Isi nama kategori → Klik **Simpan**.              |
| **Edit Kategori**     | Klik **Edit** pada kategori → Ubah nama → Klik **Simpan**.                   |
| **Hapus Kategori**    | Klik **Hapus** → Konfirmasi. Kategori hanya bisa dihapus jika tidak memiliki produk terkait. |

#### 👤 Manajemen Akun Pengguna
| Aksi                | Langkah                                                                           |
|---------------------|-----------------------------------------------------------------------------------|
| **Lihat Akun**      | Buka menu **Kelola Akun** di sidebar untuk melihat daftar semua pengguna.         |
| **Tambah Akun**     | Klik **Tambah Akun** → Isi data (nama, email, password, role) → Klik **Simpan**. |
| **Edit Akun**       | Klik **Edit** pada pengguna → Ubah data yang diperlukan → Klik **Simpan**.       |
| **Hapus Akun**      | Klik **Hapus** → Konfirmasi penghapusan akun.                                    |

---

### 3. Panel Karyawan

**Akses:** Login → otomatis diarahkan ke `/karyawan/dashboard`

Karyawan memiliki akses paling luas untuk operasional harian toko.

#### 📊 Dashboard
- Menampilkan ringkasan data toko: total penjualan, produk terlaris, stok menipis, dan grafik penjualan.

#### 📦 Produk & Kategori (Lihat Saja)
- Karyawan dapat melihat daftar dan detail produk serta kategori, tetapi **tidak bisa menambah, mengedit, atau menghapus**.

#### 📋 Manajemen Stok
| Aksi                    | Langkah                                                                      |
|-------------------------|------------------------------------------------------------------------------|
| **Lihat Stok**          | Buka menu **Manajemen Stok** di sidebar untuk melihat stok semua produk.     |
| **Tambah Stok Masuk**   | Klik **Tambah Stok** → Pilih produk → Isi jumlah → Klik **Simpan**.        |
| **Riwayat Pergerakan**  | Buka menu **Riwayat Pergerakan Stok** untuk melihat log masuk/keluar stok.  |

#### 💰 Data Transaksi
| Aksi                    | Langkah                                                                      |
|-------------------------|------------------------------------------------------------------------------|
| **Lihat Transaksi**     | Buka menu **Data Transaksi** di sidebar. Ditampilkan 5 transaksi per halaman dengan navigasi halaman. |
| **Detail Transaksi**    | Klik **Detail** pada transaksi untuk melihat informasi lengkap.              |
| **Download Nota PDF**   | Di halaman detail transaksi, klik tombol **Download Nota PDF**.              |
| **Export Laporan**      | Klik tombol **Export Laporan Penjualan** untuk membuka halaman laporan.       |

#### ⭐ Review Pelanggan
| Aksi                | Langkah                                                                           |
|---------------------|-----------------------------------------------------------------------------------|
| **Lihat Review**    | Buka menu **Review Pelanggan** di sidebar untuk melihat semua review yang masuk.  |
| **Hapus Review**    | Klik tombol **Hapus** pada review yang tidak pantas → Konfirmasi penghapusan.     |

#### 📢 Komplain Pelanggan
| Aksi                    | Langkah                                                                      |
|-------------------------|------------------------------------------------------------------------------|
| **Lihat Komplain**      | Buka menu **Komplain Pelanggan** di sidebar. Terdapat statistik per status (Menunggu, Diproses, Selesai). |
| **Detail Komplain**     | Klik pada komplain untuk melihat detail dan riwayat percakapan.              |
| **Update Status**       | Di halaman detail, ubah status komplain (Menunggu → Diproses → Selesai).    |
| **Balas Komplain**      | Di halaman detail, ketik balasan → Klik **Kirim Balasan**.                   |

#### 👁️ Aktivitas Pengunjung
- Buka menu **Aktivitas Pengunjung** untuk melihat data kunjungan website.

#### 📈 Laporan
| Aksi                    | Langkah                                                                      |
|-------------------------|------------------------------------------------------------------------------|
| **Laporan Penjualan**   | Buka menu **Laporan** → Pilih **Laporan Penjualan**. Filter berdasarkan tanggal jika diperlukan. |
| **Laporan Stok**        | Buka menu **Laporan** → Pilih **Laporan Stok**.                             |
| **Pergerakan Stok**     | Buka menu **Laporan** → Pilih **Pergerakan Stok**.                          |
| **Download PDF**        | Klik tombol **Download PDF** di halaman laporan penjualan atau stok.         |

---

### 4. Panel Kasir

**Akses:** Login → otomatis diarahkan ke `/kasir/dashboard`

Kasir mengoperasikan sistem Point of Sale untuk memproses penjualan.

#### 📊 Dashboard
- Menampilkan ringkasan penjualan hari ini dan transaksi terbaru.

#### 🛒 Point of Sale (POS)
| Langkah | Cara Penggunaan                                                                           |
|---------|-------------------------------------------------------------------------------------------|
| **1**   | Buka menu **POS** di sidebar.                                                             |
| **2**   | Cari dan pilih produk yang ingin dijual. Produk akan masuk ke keranjang.                  |
| **3**   | Atur jumlah (quantity) produk di keranjang sesuai kebutuhan.                              |
| **4**   | *(Opsional)* Cari dan pilih pelanggan jika pelanggan sudah terdaftar.                    |
| **5**   | Pilih metode pembayaran: **Cash** atau **QRIS** (via Midtrans).                          |
| **6**   | Klik **Proses Pembayaran**.                                                               |
| **7**   | Setelah pembayaran berhasil, halaman nota akan ditampilkan.                               |

#### 🧾 Nota / Struk
| Aksi                | Langkah                                                                           |
|---------------------|-----------------------------------------------------------------------------------|
| **Lihat Nota**      | Setelah transaksi berhasil, nota otomatis ditampilkan.                            |
| **Download PDF**    | Klik tombol **Download PDF** untuk mengunduh nota dalam format PDF.               |

---

### 5. Panel Owner

**Akses:** Login → otomatis diarahkan ke `/owner/dashboard`

Owner hanya memiliki akses **baca saja** untuk memantau performa bisnis.

#### 📊 Dashboard
- Menampilkan ringkasan bisnis: total pendapatan, jumlah transaksi, produk terlaris, dan grafik.

#### 📈 Laporan
| Aksi                    | Langkah                                                                      |
|-------------------------|------------------------------------------------------------------------------|
| **Laporan Penjualan**   | Buka menu **Laporan Penjualan** untuk melihat data penjualan per periode.    |
| **Laporan Stok**        | Buka menu **Laporan Stok** untuk melihat kondisi stok saat ini.              |
| **Pergerakan Stok**     | Buka menu **Pergerakan Stok** untuk melihat riwayat keluar/masuk stok.      |
| **Download PDF**        | Klik tombol **Download PDF** untuk mengunduh laporan.                        |

---

### 6. Panel Pelanggan

**Akses:** Login → otomatis diarahkan ke `/pelanggan/orders`

Pelanggan yang sudah terdaftar dapat mengakses riwayat pembelian dan fitur komplain.

#### 🛍️ Riwayat Pembelian
| Aksi                    | Langkah                                                                      |
|-------------------------|------------------------------------------------------------------------------|
| **Lihat Riwayat**       | Setelah login, halaman riwayat pembelian otomatis ditampilkan.               |
| **Detail Pembelian**    | Klik pada transaksi untuk melihat detail produk yang dibeli dan status pembayaran. |

#### 📢 Komplain
| Aksi                    | Langkah                                                                      |
|-------------------------|------------------------------------------------------------------------------|
| **Lihat Komplain**      | Buka menu **Komplain** untuk melihat daftar komplain yang pernah diajukan.   |
| **Ajukan Komplain**     | Klik **Ajukan Komplain** → Isi judul dan deskripsi masalah → Klik **Kirim**.|
| **Detail Komplain**     | Klik pada komplain untuk melihat status dan balasan dari karyawan.           |
| **Balas Percakapan**    | Di halaman detail, ketik balasan → Klik **Kirim** untuk melanjutkan diskusi. |

#### ⭐ Review Produk
| Aksi                | Langkah                                                                           |
|---------------------|-----------------------------------------------------------------------------------|
| **Tulis Review**    | Buka halaman detail produk di katalog → Scroll ke bagian review → Isi rating dan komentar → Klik **Kirim Review**. |

---

## 💳 Integrasi Midtrans

Sistem menggunakan **Midtrans** sebagai payment gateway untuk pembayaran QRIS.

### Konfigurasi
Pastikan variabel berikut sudah diisi di file `.env`:

```env
MIDTRANS_SERVER_KEY=your-server-key
MIDTRANS_CLIENT_KEY=your-client-key
MIDTRANS_IS_PRODUCTION=false
```

### Alur Pembayaran QRIS
1. Kasir memilih metode pembayaran **QRIS** di POS.
2. Sistem membuat transaksi ke Midtrans dan menampilkan QR code.
3. Pelanggan scan QR code untuk membayar.
4. Midtrans mengirim notifikasi ke callback URL (`/midtrans/notification`).
5. Status pembayaran otomatis diperbarui di sistem.

---

## 📝 Catatan Tambahan

- **Profil Pengguna:** Semua pengguna yang sudah login dapat mengedit profil (nama, email, password) melalui menu **Profil**.
- **Registrasi:** Pengguna baru yang mendaftar secara mandiri akan otomatis mendapat role **Pelanggan**.
- **Keamanan:** Setiap role hanya bisa mengakses halaman sesuai hak aksesnya. Akses ke halaman yang tidak diizinkan akan ditolak secara otomatis.

---

<p align="center">
  <strong>Awenk Jeans</strong> — Sistem Manajemen Toko<br>
  Dibangun dengan ❤️ menggunakan Laravel
</p>
