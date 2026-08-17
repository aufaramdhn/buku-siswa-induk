# 📚 Sistem Informasi Buku Induk Siswa Digital

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-8.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)

Aplikasi Web Manajemen **Buku Induk Siswa Digital** terintegrasi berbasis **Laravel 12** dan **Tailwind CSS v4**. Aplikasi ini dirancang khusus untuk mempermudah sekolah dalam mengelola data induk siswa, pencetakan dokumen fisik standar nasional, pengelolaan data akademik, profil sekolah, serta pemantauan log audit operator secara aman dan efisien.

---

## ✨ Fitur Utama (Key Features)

### 👨‍🎓 1. Manajemen Data Induk Siswa
* **Formulir 4 Tab Interaktif:**
  1. *Info Pribadi & Kontak:* Nama, NIPD, NISN, Jenis Kelamin, Tempat & Tanggal Lahir, Agama, No. KK, No. HP, Email, Telepon.
  2. *Alamat Lengkap:* Alamat Jalan, RT, RW, Dusun, Desa/Kelurahan, Kecamatan, Kode Pos, Jenis Tempat Tinggal, Transportasi.
  3. *Orang Tua & Wali:* Data Ayah Kandung, Ibu Kandung, Wali, dan Hubungan Keluarga (Jumlah Saudara & Anak Ke-).
  4. *Akademik & Bantuan:* Kelas (Rombel), Sekolah Asal, SKHUN, No. Ijazah, Akta Lahir, Fisik Siswa (Tinggi, Berat, Lingkar Kepala), Jarak Sekolah, serta Kartu Bantuan Sosial (KPS/KKS/KIP/PIP).
* **Validasi Keketatan Data & Indikator Required (`*`):**
  * Penanda visual bintang merah (`*`) pada seluruh kolom wajib.
  * *Highlight error* berupa border merah solid dan focus ring danger (`border-danger focus:ring-danger/10`).
  * **Modal Peringatan General** (*"Formulir Belum Lengkap"*) jika ada kolom wajib yang kosong saat submit.
  * **Auto-Tab Switching & Smooth Scroll:** Otomatis mengarahkan ke tab dan fokus kursor pada kolom yang belum terisi.
  * **Modal Konfirmasi Simpan Data:** Konfirmasi keamanan sebelum menyimpan perubahan data ke database.

---

### 🖨️ 2. Cetak Dokumen & Laporan Standar Nasional
* **Cetak Lembar Buku Induk Siswa (Individu):** Format halaman cetak resmi Buku Induk Siswa lengkap dengan header profil sekolah, pasfoto, data pribadi, alamat, orang tua/wali, serta kolom tanda tangan pejabat.
* **Cetak Rekapitulasi Seluruh Siswa (Massal / All Students):** Format cetak daftar tabel seluruh siswa yang dapat disesuaikan untuk kebutuhan laporan arsip sekolah.

---

### 🏢 3. Profil Sekolah (School Settings)
* **Mode Read-Only Default:** Mencegah perubahan data konfigurasi sekolah secara tidak sengaja.
* **Mode Pengeditan Interaktif:** Tombol **`Ubah Profil Sekolah`** (varian warning) di bagian footer untuk mengaktifkan pengeditan.
* Pengelolaan data NPSN, NSS, Tahun Pelajaran Aktif, Alamat Sekolah, serta Pejabat Penandatangan (Kepala Sekolah & Kepala TU).

---

### 🔍 4. Pencarian Cerdas Topbar (Quick Search API)
* Pencarian *realtime* pada topbar navigasi atas yang dapat mencari **Nama Siswa, NIPD, NISN**, serta **Pintasan Menu Aplikasi** secara instan.

---

### 🛡️ 5. Manajemen Operator & Log Audit
* **Manajemen User Operator:** Pengelolaan akun pengguna dengan peran `Admin` dan `Staff`.
* **Sistem Audit Log:** Pencatatan seluruh riwayat aktivitas penambahan, pengubahan, dan penghapusan data oleh operator.

---

## 🛠️ Teknologi yang Digunakan (Tech Stack)

| Sektor | Teknologi |
| :--- | :--- |
| **Backend Framework** | [Laravel 12.x](https://laravel.com) (PHP 8.2+) |
| **Frontend Styling** | [Tailwind CSS v4](https://tailwindcss.com) |
| **Build Tool & Asset Bundler** | [Vite 8.x](https://vitejs.dev) |
| **Interaktivitas UI** | Vanilla JavaScript Modules (Custom Select, Custom Datepicker, Validation Modal) |
| **Database** | MySQL / MariaDB / SQLite |

---

## 🚀 Panduan Instalasi & Setup Proyek

### 📋 Prasyarat Sistem
Pastikan perangkat Anda telah terinstall:
* PHP versi `>= 8.2`
* Composer versi `>= 2.x`
* Node.js versi `>= 18.x` & NPM
* Database Server (MySQL / MariaDB / SQLite)

---

### 📥 Langkah-Langkah Instalasi

1. **Clone Repository:**
   ```bash
   git clone https://github.com/username/buku-induk-siswa.git
   cd buku-induk-siswa
   ```

2. **Install Dependensi PHP (Composer):**
   ```bash
   composer install
   ```

3. **Install Dependensi JavaScript (NPM):**
   ```bash
   npm install
   ```

4. **Konfigurasi Environment (`.env`):**
   Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Atur konfigurasi database pada file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=buku_induk_siswa
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

6. **Jalankan Database Migration & Seeder:**
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Build Aset Frontend (Tailwind CSS & JS):**
   * Untuk Mode Pengembangan (Development):
     ```bash
     npm run dev
     ```
   * Untuk Mode Produksi (Production Build):
     ```bash
     npm run build
     ```

8. **Jalankan Server Lokal (Development Server):**
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui browser di: `http://localhost:8000`

---

## 🔑 Kredensial Akun Default (Login Dummy)

Setelah menjalankan `php artisan migrate:fresh --seed`, Anda dapat menggunakan akun bawaan berikut:

| Peran (Role) | Username | Password | Hak Akses |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin` | `password` | Akses Penuh (Siswa, Profil Sekolah, Operator, Audit Log, Mata Pelajaran, Ekskul) |
| **Staff** | `staff` | `password` | Akses Terbatas (Manajemen Data Siswa & Cetak Laporan) |

---

## 📂 Struktur Utama Proyek

```text
buku-induk-siswa/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Controller Utama (Student, School, Dashboard, dll)
│   │   └── Requests/          # Server-side Form Request Validation
│   └── Models/                # Model Eloquent (Student, School, User, AuditLog, dll)
├── database/
│   ├── migrations/            # Skema Tabel Database
│   └── seeders/               # Data Seed Dummy (Siswa, Sekolah, Users)
├── resources/
│   ├── css/                   # Stylesheet Tailwind CSS v4 (app.css)
│   ├── js/
│   │   └── modules/           # Modul Vanilla JS (custom-select, form-validation, dll)
│   └── views/
│       ├── components/        # Blade UI & Form Components Reusable
│       ├── settings/          # View Profil Sekolah
│       └── students/          # View Manajemen & Cetak Buku Induk Siswa
└── routes/
    └── web.php                # Deklarasi Rute Aplikasi
```

---

## 📝 Lisensi

Proyek ini dilisensikan di bawah lisensi [MIT License](LICENSE).
