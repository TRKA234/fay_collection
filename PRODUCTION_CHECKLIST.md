# Production Checklist - Fay Collection

## ✅ Pre-Deployment Checklist

### 1. Environment Configuration
- [ ] Copy `.env.example` to `.env`
- [ ] Generate application key: `php artisan key:generate`
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_URL` to your actual domain
- [ ] Configure database credentials
- [ ] Configure email/SMTP settings
- [ ] Set secure session configuration

### 2. Database Setup
- [ ] Create database
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Run seeders: `php artisan db:seed --force`
- [ ] Verify all tables created correctly
- [ ] Test database connection

### 3. File Permissions
```bash
# Linux/Mac
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Windows (if needed)
icacls storage /grant Users:F /T
icacls bootstrap\cache /grant Users:F /T
```

### 4. Storage Link
```bash
php artisan storage:link
```

### 5. Build Assets
```bash
npm install
npm run build
```

### 6. Optimize for Production
```bash
# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### 7. Security
- [ ] Change default admin password
- [ ] Verify `.env` is in `.gitignore`
- [ ] Check file permissions
- [ ] Enable HTTPS/SSL
- [ ] Configure firewall rules
- [ ] Set up backup strategy

### 8. Server Configuration

#### Apache (.htaccess sudah ada di public/.htaccess)
- [ ] Enable mod_rewrite
- [ ] Set document root to `public/` directory
- [ ] Verify .htaccess is working

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

### 9. Queue Worker (Optional)
Jika menggunakan queue untuk email:
```bash
php artisan queue:work --daemon
```

Atau setup supervisor:
```ini
[program:fay-collection-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/fay_collection/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/path/to/fay_collection/storage/logs/worker.log
```

### 10. Cron Job (Optional)
```bash
* * * * * cd /path/to/fay_collection && php artisan schedule:run >> /dev/null 2>&1
```

### 11. Testing
- [ ] Test homepage loads
- [ ] Test admin login
- [ ] Test customer registration
- [ ] Test product browsing
- [ ] Test cart functionality
- [ ] Test checkout process
- [ ] Test order management
- [ ] Test email notifications
- [ ] Test file uploads (if any)

### 12. Monitoring
- [ ] Set up error logging
- [ ] Monitor storage/logs/laravel.log
- [ ] Set up backup automation
- [ ] Monitor disk space
- [ ] Monitor database size

## 🚀 Post-Deployment

### Immediate Actions
1. Change admin password
2. Test all critical features
3. Monitor error logs
4. Verify email sending works
5. Check SSL certificate

### Regular Maintenance
- Weekly: Check error logs
- Monthly: Review and optimize database
- Quarterly: Update dependencies
- As needed: Backup database

## 📝 Notes

- Default admin: `admin@faycollection.test` / `admin123`
- **CHANGE ADMIN PASSWORD IMMEDIATELY!**
- All sensitive data in `.env` file
- Never commit `.env` to version control
- Keep `storage/` and `bootstrap/cache/` writable

## 🔗 Related Documentation

- `README.md` - General documentation
- `INSTALLATION.md` - Installation guide
- `DEPLOYMENT.md` - Deployment guide
- `EMAIL_CONFIG.md` - Email configuration

---

**Last Updated:** 2026-01-04
**Version:** 1.0.0

