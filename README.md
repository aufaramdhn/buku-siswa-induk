# 📚 Sistem Informasi Buku Induk Siswa Digital

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-8.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)

Aplikasi Web Manajemen **Buku Induk Siswa Digital** adalah platform modern yang dirancang khusus untuk mempermudah institusi pendidikan/sekolah dalam mengelola arsip dan data induk peserta didik secara terintegrasi, aman, akurat, dan efisien sesuai standar administrasi pendidikan nasional.

---

## 🎯 Tujuan & Gambaran Proyek

Buku Induk Siswa merupakan dokumen vital sekolah yang mencatat riwayat lengkap siswa sejak masuk hingga lulus. Sistem ini hadir untuk mentransformasi pencatatan manual berbasis kertas menjadi sistem digital terpadu dengan keunggulan:

* **Sentralisasi Data Siswa:** Menyimpan data identitas pribadi, kontak, domisili, orang tua/wali, akademik, riwayat fisik, hingga program bantuan sosial dalam satu basis data terstruktur.
* **Standarisasi Dokumen Cetak:** Menyediakan format lembar cetak Buku Induk Siswa resmi standar nasional dan lembar rekapitulasi data massal siap arsip.
* **Keamanan & Akuntabilitas:** Dilengkapi sistem *Role-Based Access Control* (RBAC) serta pencatatan jejak aktivitas operator (*Audit Log*) secara *real-time*.
* **Pengalaman Pengguna Interaktif (Smart UX):** Meminimalisir kesalahan input dengan validasi ketat, fitur draf otomatis (*Smart Draft*), deteksi perubahan data, dan navigasi pencarian instan.

---

## ✨ Fitur & Modul Utama

### 👨‍🎓 1. Manajemen Data Induk Siswa (4 Tab Interaktif)
Formulir input data siswa dirancang modular dengan pemisahan 4 tab terstruktur:
1. **Info Pribadi & Kontak:**
   Nama Lengkap, NIPD, NISN, NIK, Tempat & Tanggal Lahir, Jenis Kelamin, Agama, Nomor Handphone, Email, dan Telepon Rumah.
2. **Alamat Lengkap & Domisili:**
   Alamat Jalan, RT/RW, Dusun, Desa/Kelurahan, Kecamatan, Kode Pos, Jenis Tempat Tinggal, dan Moda Transportasi.
3. **Data Orang Tua & Wali:**
   Rincian lengkap data Ayah Kandung, Ibu Kandung, dan Wali (Nama, NIK, Tahun Lahir, Jenjang Pendidikan, Pekerjaan, Penghasilan Bulanan), serta Informasi Keluarga (Jumlah Saudara Kandung & Anak Ke-).
4. **Akademik, Fisik & Program Bantuan:**
   Rombel/Kelas, Tahun Masuk, Sekolah Asal, No. Seri Ijazah, No. SKHUN, No. Registrasi Akta Lahir, Data Fisik (Tinggi Badan, Berat Badan, Lingkar Kepala), Jarak & Waktu Tempuh ke Sekolah, serta Status Kartu Bantuan Sosial (KPS, KKS, KIP, PIP).

---

### ⚡ 2. Validasi Cerdas & UX Formulir (Smart Form Handling)
* **Smart Draft Autosave (`sessionStorage`):** Menyimpan draf isian formulir siswa secara lokal untuk mencegah kehilangan data jika halaman tidak sengaja tertutup atau berpindah tab.
* **Pencegah Keluar Halaman (`beforeunload`):** Notifikasi konfirmasi otomatis saat pengguna mencoba merefresh atau meninggalkan halaman ketika ada perubahan data yang belum tersimpan.
* **Auto-Tab Switch & Smooth Scroll:** Otomatis berpindah ke tab yang memuat kolom bermasalah dan mengarahkan kursor (*focus*) langsung ke input yang wajib diisi saat validasi formulir gagal.
* **Modal Dialog Konfirmasi & Peringatan:** Peringatan validasi yang informatif dan modal konfirmasi keamanan sebelum aksi penyimpanan atau penghapusan data.
* **Sanitasi Angka Positif (Non-Negative Integer Guard):** Pembatasan input numerik secara global pada kolom NIK, NISN, NIPD, Telepon, HP, Kode Pos, dan data fisik.

---

### 🖨️ 3. Cetak Dokumen Standar Nasional (Print-Ready Module)
* **Cetak Lembar Buku Induk Siswa (Individu):** Format cetak resmi lembar Buku Induk per siswa lengkap dengan pasfoto, kop profil sekolah, data lengkap siswa, orang tua, wali, akademik, dan kolom tanda tangan Kepala Sekolah & Petugas.
* **Cetak Rekapitulasi Data Seluruh Siswa (Massal):** Format rekapitulasi data seluruh siswa dalam tabel cetak bersih dan rapi untuk pelaporan arsip dinas atau kebutuhan administrasi sekolah.

---

### 🏢 4. Manajemen Profil Sekolah (School Settings)
* Pengaturan identitas dan legalitas sekolah: Nama Sekolah, NPSN, NSS, Jenjang Pendidikan, Status Sekolah, Alamat, Kontak Resmi, Tahun Ajaran Aktif, dan Semester Aktif.
* Pengaturan data Pejabat Penandatangan Dokumen resmi (Nama & NIP Kepala Sekolah serta Kepala Tata Usaha).
* **Mode Read-Only Default:** Fitur perlindungan data konfigurasi sekolah untuk mencegah perubahan tidak disengaja, yang dapat dibuka melalui tombol toggle *Ubah Profil Sekolah*.

---

### 📚 5. Referensi Mata Pelajaran & Ekstrakurikuler
* **Master Mata Pelajaran:** Manajemen daftar mata pelajaran, kode pelajaran, dan kelompok/kategori mapel.
* **Master Ekstrakurikuler:** Pengelolaan daftar kegiatan ekstrakurikuler sekolah beserta data guru pembina/instruktur.

---

### 🛡️ 6. Manajemen Operator & Log Audit (Security & Audit Trail)
* **Manajemen Pengguna (User Operators):** Pengelolaan akun operator dengan pembagian peran `Admin` dan `Staff`.
* **Sistem Log Audit (Audit Trail):** Pencatatan riwayat aktivitas operator (Create, Update, Delete) lengkap dengan informasi User ID, Alamat IP, User-Agent browser, waktu eksekusi, serta rekaman perubahan data (*payload changes* JSON).

---

### 🔍 7. Pencarian Cerdas Topbar (Quick Search API)
* Pencarian *real-time* terintegrasi pada topbar navigasi yang dapat langsung mendeteksi **Nama Siswa, NIPD, NISN**, serta pintasan navigasi menu sistem secara cepat dan responsif.

---

## 🔑 Kredensial & Hak Akses Akun (Default User Roles)

Sistem menerapkan pemisahan hak akses berbasis peran (*Role-Based Access Control*):

| Peran (Role) | Username | Password | Hak Akses |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin` | `password` | Akses Penuh (Siswa, Profil Sekolah, Operator, Audit Log, Mata Pelajaran, Ekskul) |
| **Staff** | `staff` | `password` | Akses Terbatas (Manajemen Data Siswa & Cetak Laporan) |

---

## 🛠️ Teknologi yang Digunakan (Tech Stack)

| Sektor | Komponen / Teknologi | Deskripsi |
| :--- | :--- | :--- |
| **Backend Framework** | [Laravel 12.x](https://laravel.com) | Framework PHP modern dengan arsitektur MVC, Eloquent ORM, dan Blade Templating |
| **Bahasa Pemrograman** | [PHP 8.2+](https://php.net) | Bahasa backend utama dengan fitur keamanan dan performa tipe data modern |
| **Frontend Styling** | [Tailwind CSS v4](https://tailwindcss.com) | Utility-first CSS framework untuk antarmuka yang modern, responsif, dan konsisten |
| **Asset Bundler** | [Vite 8.x](https://vitejs.dev) | Build tool performa tinggi untuk kompilasi modul CSS dan JavaScript |
| **Interaktivitas UI** | Vanilla JavaScript (ES Modules) | Modul JS kustom ringan (Smart Draft, Custom Select, Datepicker, Modal System) |
| **Database** | MySQL / MariaDB / SQLite | Sistem manajemen basis data relasional untuk penyimpanan data terstruktur |
| **Tipografi & Ikon** | Geist Sans & Plus Jakarta Sans | Tipografi modern dengan ikonografi SVG yang bersih |

---

## 📂 Struktur Utama Proyek

```text
buku-induk-siswa/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Controller Utama (Student, School, Subject, Extracurricular, User, AuditLog, Auth)
│   │   └── Requests/          # Validasi Form Request (Server-side validation)
│   └── Models/                # Model Eloquent (Student, School, User, AuditLog, Subject, Extracurricular, dll)
├── database/
│   ├── migrations/            # Skema Migrasi Struktur Tabel Database
│   ├── seeders/               # Data Seeder Default (Pengguna, Profil Sekolah, Siswa Contoh)
│   └── buku_induk_siswa.sql   # Cadangan Dump Database SQL
├── resources/
│   ├── css/                   # Stylesheet Tailwind CSS v4 (app.css)
│   ├── js/
│   │   └── modules/           # Modul Vanilla JS (smart-draft, custom-select, validation, number-guard, dll)
│   └── views/
│       ├── components/        # Komponen UI & Form Reusable Blade
│       ├── layouts/           # Master Layout & Sidebar Navigation
│       ├── settings/          # Tampilan Pengaturan Profil Sekolah
│       ├── students/          # Manajemen & Cetak Lembar Buku Induk Siswa
│       ├── subjects/          # Manajemen Data Mata Pelajaran
│       ├── extracurriculars/  # Manajemen Data Ekstrakurikuler
│       ├── users/             # Manajemen Operator Sekolah
│       └── audit_logs/        # Tampilan Rekaman Log Audit
└── routes/
    └── web.php                # Rute Navigasi & Proteksi Hak Akses Web
```

---

## 📝 Lisensi

Proyek ini dilisensikan di bawah lisensi [MIT License](LICENSE).
