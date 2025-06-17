
# 🛠️ Langkah-langkah Penyiapan

Ikuti langkah-langkah berikut untuk menyiapkan proyek:

1. Kloning Repositori

Jalankan perintah berikut untuk mengkloning repositori proyek:

```git clone <repository_url>```

Ganti <repository_url> dengan URL repositori Git yang sebenarnya ```https://github.com/Alledanaralle/PBF.git```

2. Masuk ke Direktori Proyek

Pindah ke direktori proyek yang baru saja dikloning:

```cd <project_name>```

Ganti <project_name> dengan nama direktori proyek ```cd PBF```.

3. Salin File `env`

Salin file `env` menjadi `.env` untuk konfigurasi lingkungan:

```cp env .env```

4. Konfigurasi File `.env`

Buka file `.env` dengan editor teks dan atur variabel berikut:

- app.baseURL: Tetapkan URL dasar aplikasi, misalnya `http://localhost:8080` untuk pengembangan lokal.

- Pengaturan database:

- `database.default.hostname = localhost / 127.0.0.1`

- `database.default.database = nama_database_anda`

- `database.default.username = nama_pengguna_anda`

- `database.default.password = kata_sandi_anda`

- `database.default.DBDriver = MySQLi`

- `database.default.port = 3306`

Ganti `nama_database_anda`, `nama_pengguna_anda`, dan `kata_sandi_anda` dengan kredensial database Anda yang sebenarnya.

5. Instal Dependensi

Jalankan perintah berikut untuk menginstal dependensi proyek menggunakan Composer:

```composer install```

6. Buat Database
 impor dari DB Engineer (https://github.com/andinardelinaa/database). Pastikan nama database sesuai dengan yang ada di `.env`.

7. Jalankan Migrasi Database

Siapkan tabel database dengan menjalankan migrasi:

```php spark migrate```

# Clone
1. Masuk ke folder
   ```cd C:\laragon\www```
2. ```Buat Folder PBF-Baru```
3. clone repository
``` git clone https://github.com/Alledanaralle/PBF.git PBF-baru ```
4. Instal Composer
5. Buat model ```php spark make:model namaController```

# 🚀 Menjalankan Server

Untuk pengembangan lokal, Anda dapat menggunakan server PHP bawaan:

```php spark serve```

Server akan berjalan di http://localhost:8080 secara default. Anda dapat mengakses endpoint API dari URL ini.

Untuk Uji API di Postman

1. Mahasiswa

- GET: ```http://localhost:8080/mahasiswa```

- POST: ```http://localhost:8080/mahasiswa```

- PUT: ```http://localhost:8080/mahasiswa/{npm}```

- DELETE: ```http://localhost:8080/mahasiswa/{npm}```

2. Kajur

- GET ```http://localhost:8080/kajur```

- POST ```http://localhost:8080/kajur```

- PUT ```http://localhost:8080/kajur/{id_kajur}```

- DELETE ```http://localhost:8080/delete/{id_kajur}```

3. Cuti

- GET ```http://localhost:8080/cuti```

- POST ```http://localhost:8080/cuti```

- PUT ```http://localhost:8080/cuti/{npm}```

- DELETE ```http://localhost:8080/cuti/{npm}```

4. User

- GET ```http://localhost:8080/user```

- POST ```http://localhost:8080/user```

- PUT ```http://localhost:8080/user/{id_user}```

- DELETE ```http://localhost:8080/user/{id_user}```

5. Admin

- GET ```http://localhost:8080/admin```

- POST ```http://localhost:8080/admin```

- PUT ```http://localhost:8080/admin/{id_admin}```

- DELETE ```http://localhost:8080/admin/{id_admin}```

Selesai. Proyek backend API Anda sekarang seharusnya sudah berjalan. Jika Anda mengalami masalah, lihat Panduan Pengguna CodeIgniter 4 atau cari bantuan dari komunitas atau internet.
