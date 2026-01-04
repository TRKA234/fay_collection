# Konfigurasi Email - Fay Collection

## Setup Email SMTP Gmail

Untuk mengaktifkan notifikasi email, tambahkan konfigurasi berikut ke file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=anandokardiko1122@gmail.com
MAIL_PASSWORD=zjtwoowluzovtslc
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=anandokardiko1122@gmail.com
MAIL_FROM_NAME="Fay Collection"
```

**Catatan:** Pastikan App Password Gmail sudah diaktifkan. Password di atas adalah App Password, bukan password akun Gmail biasa.

## Notifikasi Email yang Tersedia

### Untuk Customer:

1. **Order Created** - Dikirim saat pesanan dibuat
2. **Order Status Changed** - Dikirim saat status berubah:
    - Paid (Pembayaran Dikonfirmasi)
    - Shipped (Pesanan Dikirim)
    - Completed (Pesanan Selesai)
    - Cancelled (Pesanan Dibatalkan)

### Untuk Admin:

1. **New Order Notification** - Dikirim saat ada pesanan baru
2. **Order Status Changed Notification** - Dikirim saat status pesanan diubah

## Catatan Penting

-   Pastikan email customer terdaftar di sistem (field `email` di tabel `users`)
-   Email akan dikirim ke alamat yang terdaftar di `MAIL_FROM_ADDRESS` untuk notifikasi admin
-   Jika pengiriman email gagal, error akan di-log tetapi tidak akan mengganggu proses order
