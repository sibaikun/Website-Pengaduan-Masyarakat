# Sistem Pengaduan Masyarakat - Laravel

Aplikasi web untuk pengaduan masyarakat berbasis Laravel, ini adalah hasil magang saya di Kantor Kelurahan Sawah Besar, Kecamatan Gayamsari, Kota Semarang.

---

##  Fitur Utama
- Autentikasi User & Admin  
- Role-based Dashboard (User vs Admin)  
- CRUD Pengaduan dengan Upload Foto + preview  
- Admin dapat update status dan memberikan balasan  
- Dashboard menampilkan statistik & keluhan terbaru untuk Admin  
- Status keluhan: Pending / Processing / Resolved / Rejected

---

##  Prasyarat
Pastikan kamu sudah menginstall:
- **PHP ≥ 8.1**  
- **Composer**  
- **MySQL/MariaDB**  
- **Node.js & npm** (opsional, kalau pakai asset build)  
- **Git**

---

##  Instalasi

1. Clone repo dan pindah ke direktori project:
   ```bash
   git clone https://github.com/sibaikun/Website-Pengaduan-Masyarakat.git
   cd Website-Pengaduan-Masyarakat

2. Install dependency backend:
   ```bash
   composer install

3. Jika memakai frontend tooling (Vite/Tailwind), juga jalankan:
   ```bash
   npm install
   npm run dev

4. Copy contoh .env dan generate key:
   ```bash
   cp .env.example .env
   php artisan key:generate

5. Setup .env:
   - Atur DB (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
   - Pastikan host & port sesuai (biasanya 127.0.0.1:3306)

6. Migrasi database:
   ```bash
   php artisan migrate

7. Buat symbolic link untuk upload foto:
   ```bash
   php artisan storage:link

8. Jalankan server:
   ```bash
   php artisan serve
