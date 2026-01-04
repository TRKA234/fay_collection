# Installation Guide - Fay Collection

Panduan instalasi lengkap untuk aplikasi Fay Collection.

## 📋 Prerequisites

Sebelum memulai, pastikan Anda telah menginstall:

- **PHP** >= 8.2 dengan extensions:
  - BCMath
  - Ctype
  - cURL
  - DOM
  - Fileinfo
  - JSON
  - Mbstring
  - OpenSSL
  - PCRE
  - PDO
  - Tokenizer
  - XML
- **Composer** (https://getcomposer.org/)
- **Node.js** & **NPM** (https://nodejs.org/)
- **MySQL** atau **MariaDB**
- **Web Server** (Apache/Nginx) atau gunakan `php artisan serve` untuk development

## 🚀 Quick Start

### 1. Clone atau Download Project

```bash
git clone <repository-url>
cd fay_collection
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Setup Environment File

```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi:

```env
APP_NAME="Fay Collection"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fay_collection
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Fay Collection"
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Create Database

Buat database MySQL:

```sql
CREATE DATABASE fay_collection CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 7. Run Migrations

```bash
php artisan migrate
```

### 8. Seed Database

```bash
php artisan db:seed
```

Ini akan membuat:
- Admin user (email: admin@faycollection.test, password: admin123)
- 6 kategori produk
- 22 produk dengan gambar dummy

### 9. Create Storage Link

```bash
php artisan storage:link
```

### 10. Build Assets

```bash
npm run build
```

### 11. Start Development Server

```bash
php artisan serve
```

Akses aplikasi di: **http://localhost:8000**

## 🔑 Default Login

### Admin
- **URL:** http://localhost:8000/login
- **Email:** admin@faycollection.test
- **Password:** admin123

**⚠️ PENTING:** Ganti password setelah login pertama kali!

### Customer
Buat akun baru melalui: http://localhost:8000/register

## ✅ Verification

Setelah instalasi, verifikasi:

1. ✅ Homepage dapat diakses
2. ✅ Login admin berhasil
3. ✅ Dashboard admin muncul
4. ✅ Produk terlihat di homepage
5. ✅ Registrasi customer berhasil
6. ✅ Cart berfungsi
7. ✅ Checkout berfungsi

## 🐛 Troubleshooting

### Error: "Class not found"
```bash
composer dump-autoload
```

### Error: "Storage link not found"
```bash
php artisan storage:link
```

### Error: "Route not found"
```bash
php artisan route:clear
php artisan config:clear
```

### Error: "Database connection failed"
- Pastikan MySQL service berjalan
- Check credentials di `.env`
- Pastikan database sudah dibuat

### Error: "Permission denied"
```bash
# Linux/Mac
chmod -R 755 storage bootstrap/cache

# Windows (jika perlu)
icacls storage /grant Users:F /T
```

## 📝 Next Steps

Setelah instalasi berhasil:

1. Ganti password admin
2. Update informasi email di `.env`
3. Upload gambar produk asli (ganti URL dummy)
4. Konfigurasi email untuk notifikasi
5. Test semua fitur

## 📚 Documentation

- **README.md** - Dokumentasi umum
- **DEPLOYMENT.md** - Panduan deployment ke production
- **EMAIL_CONFIG.md** - Konfigurasi email

---

**Selamat! Aplikasi Fay Collection siap digunakan! 🎉**

