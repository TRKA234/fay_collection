# Fay Collection - E-Commerce Platform

Platform e-commerce untuk UMKM produk rajut handmade dengan sistem manajemen pesanan lengkap.

## 🚀 Fitur Utama

### Untuk Customer
- ✅ Browse produk dengan kategori
- ✅ Keranjang belanja (Shopping Cart)
- ✅ Checkout dengan pilihan pengiriman (JNT / Ambil di Lokasi)
- ✅ Tracking pesanan
- ✅ Notifikasi email untuk setiap status pesanan
- ✅ Registrasi dan login

### Untuk Admin
- ✅ Dashboard dengan statistik pesanan
- ✅ Manajemen produk (CRUD)
- ✅ Manajemen kategori
- ✅ Manajemen pesanan dengan update status real-time
- ✅ Update ongkos kirim langsung di halaman detail pesanan
- ✅ Notifikasi email untuk setiap aktivitas
- ✅ Informasi pembayaran dan pengiriman

## 📋 Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/MariaDB
- Web Server (Apache/Nginx)

## 🔧 Installation

### 1. Clone Repository
```bash
git clone <repository-url>
cd fay_collection
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fay_collection
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Konfigurasi Email (Opsional)
Untuk mengaktifkan notifikasi email, edit file `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Fay Collection"
```

**Catatan:** Gunakan App Password Gmail, bukan password akun biasa.

### 6. Run Migrations & Seeders
```bash
php artisan migrate
php artisan db:seed
```

### 7. Create Storage Link
```bash
php artisan storage:link
```

### 8. Build Assets
```bash
npm run build
```

### 9. Run Development Server
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## 👤 Default Credentials

### Admin
- **Email:** admin@faycollection.test
- **Password:** admin123

**⚠️ PENTING:** Ganti password setelah login pertama kali!

### Customer
Buat akun baru melalui halaman registrasi.

## 📁 Struktur Proyek

```
fay_collection/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Controller untuk admin
│   │   │   ├── Front/          # Controller untuk frontend
│   │   │   └── AuthController.php
│   │   └── Middleware/
│   ├── Mail/                   # Email notifications
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── admin/              # View untuk admin panel
│       ├── front/               # View untuk customer
│       ├── auth/                # Login & Register
│       ├── emails/              # Email templates
│       └── layouts/
├── routes/
│   └── web.php
└── public/
```

## 🔐 Role & Permission

- **Admin:** Akses penuh ke admin panel
- **Customer:** Akses untuk belanja dan melihat pesanan sendiri

## 📧 Email Notifications

Sistem mengirim email otomatis untuk:
- Customer: Pesanan dibuat, status berubah (paid, shipped, completed, cancelled)
- Admin: Pesanan baru, perubahan status pesanan

Lihat `EMAIL_CONFIG.md` untuk detail konfigurasi.

## 🚢 Shipping & Payment

- **Metode Pengiriman:**
  - JNT Express (dengan alamat lengkap)
  - Ambil di Lokasi Produksi

- **Pembayaran:**
  - Dilakukan di luar sistem (transfer manual)
  - Admin mengisi informasi rekening di sistem
  - Customer mendapat info rekening via email dan WhatsApp

- **Ongkos Kirim:**
  - Ditentukan oleh admin setelah pesanan dibuat
  - Dapat diupdate langsung di halaman detail pesanan

## 🗄️ Database Schema

### Tables
- `users` - User accounts (admin & customer)
- `categories` - Kategori produk
- `products` - Produk
- `orders` - Pesanan
- `order_product` - Pivot table untuk produk dalam pesanan

## 🛠️ Development

### Run Tests
```bash
php artisan test
```

### Code Style
```bash
./vendor/bin/pint
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

## 📦 Production Deployment

### 1. Optimize for Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
npm run build
```

### 2. Set Environment
```env
APP_ENV=production
APP_DEBUG=false
```

### 3. Set Permissions
```bash
chmod -R 755 storage bootstrap/cache
```

### 4. Web Server Configuration
Pastikan web server mengarah ke folder `public/` sebagai document root.

### 5. Queue Worker (Jika menggunakan queue)
```bash
php artisan queue:work
```

## 📝 License

MIT License

## 👥 Support

Untuk pertanyaan atau dukungan, silakan hubungi tim development.

---

**Fay Collection** - Handmade Crochet Products E-Commerce Platform
