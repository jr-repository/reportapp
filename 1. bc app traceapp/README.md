# TRACE

**TRACE** adalah aplikasi pelaporan harian proyek berbasis web yang dibangun dengan **CodeIgniter 4**.
Nama TRACE merupakan singkatan dari **Tracking Report & Activity Control Engine**.

Aplikasi ini dirancang untuk membantu tim lapangan dan manajemen dalam:

- mencatat laporan harian pekerjaan,
- memonitor progres aktivitas proyek,
- mengelola user berdasarkan peran,
- meninjau laporan dalam format ringkas maupun PDF,
- menyediakan endpoint API berbasis JWT untuk integrasi lanjutan.

## Ringkasan Proyek

TRACE menggunakan pendekatan role-based access sehingga setiap jenis pengguna mendapatkan fitur sesuai kebutuhan:

- **Admin**: mengelola user, memantau laporan, dan mengakses area administrasi.
- **Manager**: melihat monitoring laporan dan halaman ringkasan/trend.
- **Supervisor / PIC / Pelaksana**: melakukan self-register, mengisi laporan harian, upload foto profil, dan mengelola laporan pekerjaan.

## Fitur Utama

- Login dan logout berbasis session.
- Self registration untuk user lapangan.
- Manajemen hak akses berbasis role.
- Pembuatan laporan harian proyek.
- Review dan submit laporan.
- Export laporan ke PDF.
- Monitoring laporan untuk Admin dan Manager.
- Manajemen user untuk Admin.
- API token JWT untuk integrasi endpoint tertentu.
- UI mobile-first / PWA-style.

## Teknologi yang Digunakan

- PHP 8.2+
- CodeIgniter 4
- MySQL / MariaDB
- Dompdf
- Firebase JWT
- HTML, CSS, JavaScript

## Struktur Direktori Penting

- `app/Controllers` : controller utama aplikasi.
- `app/Views` : tampilan UI.
- `app/Services` : service bisnis aplikasi, termasuk autentikasi.
- `app/Filters` : filter autentikasi dan role access.
- `app/Config` : konfigurasi aplikasi, routes, database, dan environment.
- `db/` : file schema, dump database, dan seed data.
- `public/` : document root aplikasi dan aset publik.
- `writable/` : cache, session, log, dan file runtime lainnya.

## Kebutuhan Sistem

Sebelum menjalankan project di lokal, pastikan environment Anda memiliki:

- PHP **8.2** atau lebih tinggi
- Composer
- MySQL atau MariaDB
- Web server lokal atau gunakan `php spark serve`

Ekstensi PHP yang disarankan aktif:

- `intl`
- `mbstring`
- `json`
- `mysqli` / `mysqlnd`
- `curl`

## Cara Menjalankan Project di Lokal

### 1. Clone repository

```bash
git clone <url-repository>
cd "Project 1"
```

### 2. Install dependency

```bash
composer install
```

### 3. Buat file environment

Salin file `env` menjadi `.env`.

```bash
cp env .env
```

Lalu aktifkan konfigurasi yang dibutuhkan, minimal:

```dotenv
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = reportappdb
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

Catatan:

- Pastikan `app.baseURL` diakhiri dengan `/`.
- Sesuaikan nama database dengan file SQL yang Anda import.

## Setup Database Lokal

Project ini menyediakan beberapa file database di folder `db/`.

### Opsi database yang tersedia

- `db/DatabaseSchema.sql`
  Digunakan untuk setup database dasar yang lebih bersih. File ini sudah berisi:
  - struktur tabel,
  - role awal,
  - kategori pekerja,
  - kategori alat berat,
  - beberapa user awal.

- `db/u193610993_traceapp.sql`
  Dump database yang lebih lengkap. Cocok jika Anda ingin langsung mendapatkan data contoh yang lebih mendekati kondisi pengembangan, termasuk histori laporan, audit log, dan data tambahan lain.

- `db/dummy_reports_seed.sql`
  Seed dummy laporan harian. Gunakan hanya jika data referensi dan user yang dibutuhkan sudah tersedia.

- `db/update_profile_photo.sql`
  Script SQL tambahan terkait pembaruan kolom foto profil.

### Rekomendasi setup

Untuk local development, paling aman gunakan:

1. buat database baru,
2. import `db/DatabaseSchema.sql`,
3. jalankan aplikasi.

Contoh:

```sql
CREATE DATABASE reportappdb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Lalu import:

```bash
mysql -u root -p reportappdb < db/DatabaseSchema.sql
```

Jika Anda ingin langsung memakai data contoh yang lebih lengkap, gunakan dump penuh:

```bash
mysql -u root -p u193610993_traceapp < db/u193610993_traceapp.sql
```

Jika memakai dump penuh, sesuaikan `.env`:

```dotenv
database.default.database = u193610993_traceapp
```

## Menjalankan Aplikasi

Setelah dependency dan database siap, jalankan:

```bash
php spark serve
```

Secara default aplikasi akan tersedia di:

```text
http://localhost:8080
```

## Akses Awal

### Register user lapangan

Halaman register tersedia di:

```text
/register
```

User yang mendaftar dari halaman ini otomatis akan dibuat sebagai role:

- **Supervisor / PIC / Pelaksana**

Catatan penting:

- proses register membutuhkan data role `Supervisor` di database,
- role tersebut sudah tersedia jika Anda mengimport `db/DatabaseSchema.sql` atau dump lengkap.

### User contoh bawaan

File `db/DatabaseSchema.sql` sudah menyertakan user awal berikut:

- `admin`
- `supervisor`
- `manager`

Namun password plaintext user bawaan tidak didokumentasikan di repository ini.

Jika Anda ingin memakai user contoh tersebut, Anda bisa mengganti password secara manual:

1. buat hash password baru:

```bash
php -r "echo password_hash('admin123', PASSWORD_DEFAULT), PHP_EOL;"
```

2. update ke database:

```sql
UPDATE Users SET password_hash = 'HASIL_HASH_BARU' WHERE username = 'admin';
UPDATE Users SET password_hash = 'HASIL_HASH_BARU' WHERE username = 'manager';
UPDATE Users SET password_hash = 'HASIL_HASH_BARU' WHERE username = 'supervisor';
```

Atau, untuk pengujian fitur user lapangan, Anda cukup membuat akun baru lewat halaman register.

## Alur Fitur Utama

### Area umum

- `/login`
- `/register`

### Setelah login

- `/` : dashboard utama
- `/profile` : halaman profil
- `/reports/create` : membuat laporan harian
- `/reports/review/{id}` : review laporan
- `/reports/detail/{id}` : detail laporan
- `/reports/pdf/{id}` : export PDF laporan

### Area Admin

- `/admin/users`
- `/admin/reports`

### Area Manager

- `/manager`

### API

- `POST /api/auth/token`
- `POST /api/auth/refresh`
- `GET /api/reports/today`
- `GET /api/reports/detail/{id}`

## Menjalankan Test

Jika ingin menjalankan test:

```bash
composer test
```

## Catatan Penting untuk Development

- Pastikan folder `writable/` dapat ditulis.
- Jika ada fitur upload file/foto, pastikan folder upload juga memiliki permission yang sesuai.
- Jika aset tidak tampil benar, cek kembali `app.baseURL`.
- Jika route berjalan tetapi halaman kosong atau redirect aneh, periksa session dan konfigurasi database.
- Jika register gagal dengan pesan role tidak ditemukan, berarti data referensi database belum terimport dengan benar.

## Troubleshooting Singkat

### 1. Halaman tidak bisa dibuka setelah `php spark serve`

Periksa:

- apakah `.env` sudah aktif,
- apakah `app.baseURL` sesuai,
- apakah port `8080` sedang dipakai aplikasi lain.

### 2. Login gagal terus

Periksa:

- data user memang ada di tabel `Users`,
- password hash valid,
- user berstatus `Active`.

### 3. Register berhasil tapi akses fitur tertentu tidak muncul

Itu normal. User hasil self-register akan menjadi role **Supervisor**, bukan **Admin** atau **Manager**.

### 4. Error database

Periksa:

- host, username, password, port, dan nama database di `.env`,
- apakah file SQL sudah benar-benar terimport,
- apakah database yang dipakai sama dengan yang tertulis di `.env`.

## Penutup

TRACE ditujukan sebagai aplikasi pelaporan harian proyek yang ringkas, mobile-friendly, dan terstruktur.
Dokumentasi ini difokuskan agar project dapat dijalankan dengan cepat di lokal untuk kebutuhan development, testing, dan demonstrasi.
