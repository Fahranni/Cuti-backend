# Backend API Project - CodeIgniter 4

Selamat datang di proyek Backend API yang dibangun menggunakan CodeIgniter 4. README ini berisi panduan langkah demi langkah untuk menyiapkan dan menjalankan proyek ini di mesin lokal Anda.

# Prasyarat

Sebelum memulai, pastikan Anda telah menginstal perangkat lunak berikut:

- PHP 7.3 atau lebih tinggi

- Composer (untuk mengelola dependensi)

- MySQL (untuk database)

- Apache (opsional, untuk lingkungan produksi)

# Langkah-langkah Penyiapan

Ikuti langkah-langkah berikut untuk menyiapkan proyek:

1. Kloning Repositori

Jalankan perintah berikut untuk mengkloning repositori proyek:

`git clone <repository_url>`

Ganti <repository_url> dengan URL repositori Git yang sebenarnya.

2. Masuk ke Direktori Proyek

Pindah ke direktori proyek yang baru saja dikloning:

`cd <project_name>`

Ganti <project_name> dengan nama direktori proyek Anda.

3. Salin File `env`

Salin file `env` menjadi `.env` untuk konfigurasi lingkungan:

`cp env .env`

4. Konfigurasi File `.env`

Buka file `.env` dengan editor teks dan atur variabel berikut:

- app.baseURL: Tetapkan URL dasar aplikasi, misalnya `http://localhost:8080` untuk pengembangan lokal.

- Pengaturan database:

- `database.default.hostname = localhost`

- `database.default.database = nama_database_anda`

- `database.default.username = nama_pengguna_anda`

- `database.default.password = kata_sandi_anda`

- `database.default.DBDriver = MySQLi`

- `database.default.port = 3306`

Ganti `nama_database_anda`, `nama_pengguna_anda`, dan `kata_sandi_anda` dengan kredensial database Anda yang sebenarnya.

5. Instal Dependensi

Jalankan perintah berikut untuk menginstal dependensi proyek menggunakan Composer:

`composer install`

6. Buat Database

Buat database secara manual di MySQL menggunakan alat seperti phpMyAdmin atau perintah MySQL di terminal. Pastikan nama database sesuai dengan yang ditentukan di file `.env`.

7. Jalankan Migrasi Database

Siapkan tabel database dengan menjalankan migrasi:

`php spark migrate`

# Menjalankan Server

Untuk pengembangan lokal, Anda dapat menggunakan server PHP bawaan:

`php spark serve`

Server akan berjalan di http://localhost:8080 secara default. Anda dapat mengakses endpoint API dari URL ini.

Untuk lingkungan produksi, konfigurasikan Apache untuk melayani direktori public dari proyek. Pastikan document root mengarah ke direktori public dan atur virtual host jika diperlukan.

# Menguji API

Uji endpoint API menggunakan alat seperti Postman atau curl. Contohnya, untuk membuat permintaan GET ke /api/users, gunakan:

`curl http://localhost:8080/api/users`

Ganti /api/users dengan endpoint API yang ingin Anda uji misal `http://localhost:8080/mahasiswa`.

Untuk Uji API di Postman

- GET: `http://localhost:8080/mahasiswa`

- POST: `http://localhost:8080/mahasiswa`

- PUT: `http://localhost:8080/mahasiswa/{npm}`

- DELETE: `http://localhost:8080/mahasiswa/{npm}`

Selesai. Proyek backend API Anda sekarang seharusnya sudah berjalan. Jika Anda mengalami masalah, lihat Panduan Pengguna CodeIgniter 4 atau cari bantuan dari komunitas atau internet.
