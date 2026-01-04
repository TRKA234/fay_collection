# Deployment Quick Start - Fay Collection

Panduan cepat untuk deploy aplikasi ke production server.

## 🚀 Quick Deployment (5 Menit)

### 1. Upload Files
```bash
# Via Git
git clone <repository-url>
cd fay_collection

# Atau upload via FTP/SFTP semua file kecuali:
# - node_modules/
# - vendor/
# - .env
# - storage/logs/*
```

### 2. Install Dependencies
```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

### 3. Setup Environment
```bash
# Copy template (lihat ENV_TEMPLATE.md)
cp ENV_TEMPLATE.md .env
# Edit .env dengan konfigurasi Anda

# Generate key
php artisan key:generate
```

### 4. Database Setup
```bash
# Buat database di MySQL
mysql -u root -p
CREATE DATABASE fay_collection;

# Run migrations
php artisan migrate --force

# Seed data
php artisan db:seed --force
```

### 5. Storage & Permissions
```bash
php artisan storage:link
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 6. Optimize
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 7. Web Server
- **Apache**: Set DocumentRoot ke `public/`
- **Nginx**: Lihat konfigurasi di `DEPLOYMENT.md`

## ✅ Verify

1. Akses website di browser
2. Login admin: `admin@faycollection.test` / `admin123`
3. Test fitur utama
4. Check logs: `storage/logs/laravel.log`

## 🔧 Troubleshooting

### 500 Error
```bash
php artisan config:clear
php artisan cache:clear
chmod -R 755 storage bootstrap/cache
```

### Permission Denied
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Database Error
- Check `.env` database credentials
- Verify database exists
- Check user permissions

## 📝 Important Notes

- **CHANGE ADMIN PASSWORD IMMEDIATELY!**
- Set `APP_DEBUG=false` in production
- Set `APP_ENV=production`
- Never commit `.env` file
- Regular database backups recommended

---

**Need Help?** Check `DEPLOYMENT.md` for detailed guide.

