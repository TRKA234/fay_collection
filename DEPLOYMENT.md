# Deployment Guide - Fay Collection

Panduan lengkap untuk deploy aplikasi Fay Collection ke production server.

## 📋 Pre-Deployment Checklist

- [ ] Semua migration sudah dijalankan
- [ ] Environment variables sudah dikonfigurasi
- [ ] Storage link sudah dibuat
- [ ] Assets sudah di-build
- [ ] Email configuration sudah diatur
- [ ] Database backup sudah dibuat
- [ ] SSL certificate sudah terpasang (untuk HTTPS)

## 🚀 Step-by-Step Deployment

### 1. Server Requirements

Pastikan server memenuhi requirements:
- PHP >= 8.2 dengan extensions: BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PCRE, PDO, Tokenizer, XML
- MySQL/MariaDB >= 5.7
- Composer
- Node.js & NPM
- Web Server (Apache/Nginx)

### 2. Upload Files

Upload semua file ke server (kecuali `node_modules`, `vendor`, `.env`):
```bash
# Gunakan git untuk clone atau upload via FTP/SFTP
git clone <repository-url>
cd fay_collection
```

### 3. Install Dependencies

```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

### 4. Setup Environment

```bash
cp .env.example .env
nano .env  # Edit konfigurasi
```

**Konfigurasi penting di `.env`:**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

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

### 6. Run Migrations

```bash
php artisan migrate --force
```

### 7. Seed Database (Opsional)

```bash
php artisan db:seed --force
```

### 8. Create Storage Link

```bash
php artisan storage:link
```

### 9. Set Permissions

```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 10. Optimize Application

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 11. Setup Web Server

#### Apache (.htaccess sudah ada di public/)

Pastikan `DocumentRoot` mengarah ke folder `public/`:
```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /path/to/fay_collection/public
    
    <Directory /path/to/fay_collection/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

#### Nginx

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/fay_collection/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 12. Setup Queue Worker (Opsional)

Jika menggunakan queue untuk email, setup supervisor:

```bash
# Install supervisor
sudo apt-get install supervisor

# Create config file
sudo nano /etc/supervisor/conf.d/fay-collection-worker.conf
```

Isi file:
```ini
[program:fay-collection-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/fay_collection/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/path/to/fay_collection/storage/logs/worker.log
stopwaitsecs=3600
```

Start supervisor:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start fay-collection-worker:*
```

### 13. Setup Cron Job

Tambahkan ke crontab untuk scheduled tasks:
```bash
* * * * * cd /path/to/fay_collection && php artisan schedule:run >> /dev/null 2>&1
```

### 14. SSL Certificate (Let's Encrypt)

```bash
sudo apt-get install certbot python3-certbot-apache
# atau untuk nginx:
sudo apt-get install certbot python3-certbot-nginx

sudo certbot --apache -d yourdomain.com
# atau:
sudo certbot --nginx -d yourdomain.com
```

## 🔄 Update Deployment

Untuk update aplikasi:

```bash
git pull origin main
composer install --optimize-autoloader --no-dev
npm install
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🛡️ Security Checklist

- [ ] `APP_DEBUG=false` di production
- [ ] `APP_ENV=production`
- [ ] Strong database password
- [ ] SSL certificate terpasang
- [ ] File permissions sudah benar
- [ ] `.env` file tidak accessible dari web
- [ ] Storage folder tidak accessible langsung
- [ ] Regular backups database

## 📊 Monitoring

### Log Files
- Application logs: `storage/logs/laravel.log`
- Web server logs: `/var/log/apache2/` atau `/var/log/nginx/`

### Health Check
Aplikasi memiliki health check endpoint: `/up`

## 🆘 Troubleshooting

### Permission Denied
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 500 Error
1. Check log: `storage/logs/laravel.log`
2. Clear cache: `php artisan config:clear`
3. Check permissions
4. Check `.env` configuration

### Database Connection Error
1. Verify database credentials di `.env`
2. Check database server is running
3. Verify user permissions

### Email Not Sending
1. Verify SMTP credentials
2. Check firewall allows SMTP port
3. Verify App Password (untuk Gmail)

## 📞 Support

Jika mengalami masalah, check:
1. Laravel logs: `storage/logs/laravel.log`
2. Web server logs
3. PHP error logs

---

**Happy Deploying! 🚀**

