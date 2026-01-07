# 🛠️ Backend API - SIM Sekolah

Repository ini berisi source code **Web Service (RESTful API)** untuk Sistem Informasi Manajemen Sekolah. Aplikasi ini dibangun menggunakan Framework **Laravel** dan berfungsi sebagai penyedia data (Server-side) untuk aplikasi Frontend.

Proyek ini dibuat untuk memenuhi tugas mata kuliah Pemrograman Web / Tugas Akhir.

## 🚀 Teknologi

* **Framework:** Laravel 10.x / 11.x
* **Bahasa:** PHP 8.1+
* **Database:** MySQL / MariaDB
* **Authentication:** Laravel Sanctum (Token Based)
* **API Resource:** JsonResource untuk format response standar.

## ✨ Fitur API

1.  **Autentikasi (Auth):**
    * Login (Mendapatkan Bearer Token).
    * Logout (Menghapus Token).
2.  **Manajemen Siswa (Students):**
    * Menampilkan daftar siswa (untuk dropdown).
    * Relasi ke Tabel User & Kelas.
3.  **Manajemen Nilai (Grades):**
    * **CRUD Lengkap** (Create, Read, Update, Delete).
    * **Eager Loading:** Data nilai otomatis memuat nama siswa, nama guru, dan nama mapel dalam satu request (mengoptimalkan performa).
4.  **Validasi Data:**
    * Mencegah input nilai negatif atau di atas 100.
    * Memastikan ID siswa/guru valid sebelum disimpan.

## 📦 Daftar Endpoint (API Routes)

Berikut adalah daftar URL yang tersedia untuk diakses oleh Frontend/Postman:

| Method | Endpoint | Deskripsi | Auth Wajib? |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/login` | Login Admin/Guru | Tidak |
| `POST` | `/api/logout` | Logout sistem | Ya |
| `GET` | `/api/students` | Ambil semua data siswa | Tidak |
| `GET` | `/api/grades` | Ambil semua data nilai | Tidak |
| `POST` | `/api/grades` | Input nilai baru | Tidak* |
| `GET` | `/api/grades/{id}` | Lihat detail 1 nilai | Tidak |
| `PUT` | `/api/grades/{id}` | Update data nilai | Tidak* |
| `DELETE` | `/api/grades/{id}` | Hapus data nilai | Tidak* |

*> Catatan: Authentication middleware dapat diaktifkan di `routes/api.php` jika diperlukan.*

## ⚙️ Cara Instalasi (Localhost)

Ikuti langkah ini jika Anda ingin menjalankan project ini di komputer baru:

1.  **Clone Repository**
    ```bash
    git clone [https://github.com/USERNAME_ANDA/NAMA_REPO.git](https://github.com/USERNAME_ANDA/NAMA_REPO.git)
    cd NAMA_REPO
    ```

2.  **Install Dependencies**
    Wajib menjalankan Composer untuk mengunduh library Laravel.
    ```bash
    composer install
    ```

3.  **Setup Environment**
    Duplikat file `.env.example` menjadi `.env`.
    ```bash
    cp .env.example .env
    ```

4.  **Generate Key**
    ```bash
    php artisan key:generate
    ```

5.  **Konfigurasi Database**
    Buka file `.env`, lalu sesuaikan setting database Anda:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_anda
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6.  **Migrasi & Seeder (PENTING)**
    Jalankan perintah ini untuk membuat tabel dan mengisi data dummy (Siswa, Guru, Mapel).
    ```bash
    php artisan migrate:fresh --seed
    ```

7.  **Jalankan Server**
    ```bash
    php artisan serve
    ```
    API akan berjalan di: `http://127.0.0.1:8000`

## 📝 Dokumentasi Postman

File koleksi Postman untuk pengujian API ini disertakan dalam folder `docs/` (jika ada) atau dapat diminta kepada pengembang.

---
**Dibuat oleh:** DANAN NURDIANSYAH 24.01.53.7005 SEBAGAI TUGAS UAS WEBSERVICE