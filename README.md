
# projek adspl
projek adspl kelompok 4


# 📦 Aplikasi Gudang & Kasir - Panduan Penggunaan

Ini adalah aplikasi sederhana untuk belajar manajemen stok barang dengan fitur gudang dan kasir yang terhubung langsung ke database.

## 📋 Daftar File

1. **config.php** - File konfigurasi koneksi database
2. **gudang.php** - Aplikasi untuk mengelola stok barang (tambah, update, hapus)
3. **kasir.php** - Aplikasi untuk menggunakan barang & mengurangi stok secara real-time

## 🗄️ Struktur Database

Database: `Percobaan`
Tabel: `products`

```sql
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## 🚀 Cara Instalasi & Penggunaan

### 1. Setup Database
```bash
# Masuk ke MySQL
mysql -u root -p

# Buat database (jika belum ada)
CREATE DATABASE Percobaan;

# Gunakan database
USE Percobaan;

# Buat tabel
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 2. Konfigurasi Database (config.php)
Sesuaikan dengan credentials MySQL Anda:
```php
$host = 'localhost';
$user = 'root';          // Username MySQL Anda
$password = '';          // Password MySQL Anda (kosong jika tidak ada)
$database = 'Percobaan'; // Nama database
```

### 3. Jalankan di Local Server
Letakkan semua file di folder project Anda (misalnya: `C:\xampp\htdocs\gudang-kasir\`)

Akses melalui browser:
- **Gudang** : http://localhost/gudang-kasir/gudang.php
- **Kasir** : http://localhost/gudang-kasir/kasir.php

## 💻 Fitur Aplikasi

### 📦 Gudang (gudang.php)
✅ **Tambah Barang**
- Input nama barang dan jumlah stock awal
- Barang langsung tersimpan di database

✅ **Lihat Daftar Barang**
- Tampilan tabel semua barang
- Menampilkan status (Aman/Menipis/Habis)
- Timestamp kapan terakhir diupdate

✅ **Update Stock**
- Ubah jumlah stock barang
- Status otomatis berubah berdasarkan jumlah

✅ **Hapus Barang**
- Menghapus barang dari database
- Konfirmasi sebelum hapus

---

### 💳 Kasir (kasir.php)
✅ **Lihat Barang Tersedia**
- Tampilan card modern yang menarik
- Menampilkan stock saat ini
- Status barang (Aman/Menipis/Habis)

✅ **Pakai/Gunakan Barang**
- Input jumlah barang yang akan dipakai
- Stock di gudang otomatis berkurang
- Validasi: tidak bisa pakai lebih dari stock tersedia

✅ **Real-time Update**
- Setiap kali ada penggunaan barang di kasir
- Stock di gudang langsung terupdate
- Timestamp diupdate secara otomatis

✅ **Tampilan Ganda**
- Card view (modern & user-friendly)
- Tabel view (alternatif sederhana)

## 🔄 Alur Penggunaan

```
┌─────────────────┐
│   GUDANG (📦)   │
├─────────────────┤
│ ▪ Tambah Barang │
│ ▪ Edit Stock    │
│ ▪ Hapus Barang  │
│ ▪ Lihat Semua   │
└────────┬────────┘
         │ [Database: products table]
         ▼
┌─────────────────┐
│    KASIR (💳)   │
├─────────────────┤
│ ▪ Lihat Barang  │
│ ▪ Pakai Barang  │
│ ▪ Stock Berkurang
└─────────────────┘
```

## 📊 Contoh Penggunaan

### Scenario 1: Menambah Barang
1. Buka **gudang.php**
2. Isi "Nama Barang": **Laptop**
3. Isi "Jumlah Stock": **5**
4. Klik "Tambah Barang"
5. Barang muncul di tabel dengan stock 5

### Scenario 2: Menggunakan Barang
1. Buka **kasir.php**
2. Cari barang "Laptop"
3. Isi "Jumlah Pakai": **2**
4. Klik "Pakai Barang"
5. Stock di kasir berkurang dari 5 menjadi 3
6. Buka kembali gudang → stock Laptop sudah otomatis berkurang!

## 🎨 Fitur Desain

✨ **Responsive Design**
- Tampilan bagus di desktop maupun mobile
- Card grid yang rapi di kasir
- Tabel yang mudah dibaca

🌈 **Color Coding**
- **Hijau (Aman)** : Stock > 10
- **Orange (Menipis)** : Stock 1-10
- **Merah (Habis)** : Stock 0

⏱️ **Timestamp**
- Setiap update barang dicatat waktu & tanggalnya
- Format: dd/mm/yyyy HH:mm

## 🐛 Troubleshooting

### Koneksi Database Gagal
```
Error: Koneksi gagal: ...
```
✅ Solusi:
- Pastikan MySQL sudah running
- Check konfigurasi di `config.php` (host, user, password, database)
- Pastikan database `Percobaan` sudah dibuat

### Database Kosong di Aplikasi
✅ Solusi:
- Pastikan tabel `products` sudah dibuat dengan struktur yang benar
- Check apakah database name benar (case-sensitive)

### Stock Tidak Berkurang
✅ Solusi:
- Refresh halaman kasir
- Check apakah form sudah disubmit
- Buka gudang untuk verifikasi stock

## 💡 Tips Pembelajaran

📚 **Materi yang Bisa Dipelajari:**
1. **PHP Dasar** - Form, POST request, session
2. **MySQL** - CRUD operations, SELECT, INSERT, UPDATE, DELETE
3. **HTML/CSS** - Form styling, responsive design
4. **Database Logic** - Real-time update, validasi stock

🔧 **Latihan Lanjutan:**
- Tambah fitur: History/Log penggunaan barang
- Tambah user login
- Tambah kategori barang
- Export data ke Excel
- Filter & search barang
- Laporan stok perbulan

## 📝 Catatan Penting

⚠️ **Untuk Production:**
- Jangan gunakan `root` tanpa password
- Gunakan prepared statements untuk keamanan (prevent SQL injection)
- Tambah authentication/login
- Tambah validation yang lebih ketat
- Gunakan HTTPS

✅ **File ini cocok untuk:**
- Belajar dasar PHP & MySQL
- Praktik CRUD operations
- Memahami real-time database update
- Portfolio/latihan coding

---

**Happy Learning! 🚀**

Jika ada pertanyaan, bisa tambahi fitur atau ubah sesuai kebutuhan belajar Anda!
