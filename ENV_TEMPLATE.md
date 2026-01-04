# Environment Variables Template

Copy isi file ini ke file `.env` di root project.

```env
APP_NAME="Fay Collection"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_TIMEZONE=Asia/Jakarta
APP_URL=https://yourdomain.com

APP_LOCALE=id
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=id_ID

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fay_collection
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=anandokardiko1122@gmail.com
MAIL_PASSWORD=zjtwoowluzovtslc
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=anandokardiko1122@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Catatan Penting

1. **APP_KEY**: Generate dengan `php artisan key:generate`
2. **APP_URL**: Ganti dengan domain production Anda
3. **Database**: Sesuaikan dengan kredensial database Anda
4. **Email**: Gunakan App Password Gmail, bukan password biasa
5. **APP_DEBUG**: Harus `false` di production
6. **APP_ENV**: Harus `production` di production

