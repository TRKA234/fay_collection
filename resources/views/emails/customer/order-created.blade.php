<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil Dibuat</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #6366f1;
        }
        .header h1 {
            color: #6366f1;
            margin: 0;
            font-size: 24px;
        }
        .content {
            margin-bottom: 30px;
        }
        .order-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .order-info h2 {
            color: #6366f1;
            margin-top: 0;
            font-size: 20px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #666;
        }
        .info-value {
            color: #333;
        }
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .products-table th {
            background-color: #6366f1;
            color: white;
            padding: 12px;
            text-align: left;
        }
        .products-table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
        }
        .products-table tr:last-child td {
            border-bottom: none;
        }
        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            color: #6366f1;
            margin-top: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            background-color: #fbbf24;
            color: #92400e;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            color: #666;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #6366f1;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Pesanan Berhasil Dibuat!</h1>
        </div>

        <div class="content">
            <p>Halo <strong>{{ $order->customer_name }}</strong>,</p>
            
            <p>Terima kasih telah melakukan pemesanan di <strong>Fay Collection</strong>! Pesanan Anda telah berhasil dicatat dan sedang kami proses.</p>

            <div class="order-info">
                <h2>Detail Pesanan</h2>
                <div class="info-row">
                    <span class="info-label">Nomor Pesanan:</span>
                    <span class="info-value"><strong>#{{ $order->id }}</strong></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Pesanan:</span>
                    <span class="info-value">{{ $order->created_at->format('d F Y, H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="status-badge">{{ $order->getStatusLabel() }}</span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Kontak WhatsApp:</span>
                    <span class="info-value">{{ $order->customer_contact }}</span>
                </div>
            </div>

            <h3 style="color: #6366f1; margin-top: 30px;">Produk yang Dipesan:</h3>
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>Rp {{ number_format($product->pivot->price, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($product->pivot->price * $product->pivot->quantity, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total">
                <div style="margin-bottom: 10px;">
                    Subtotal: <span style="color: #333;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
                <div style="margin-bottom: 10px;">
                    Ongkos Kirim: <span style="color: #333;">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div style="border-top: 2px solid #6366f1; padding-top: 10px; margin-top: 10px;">
                    Total Pesanan: <span style="color: #6366f1; font-size: 24px;">Rp {{ number_format($order->getTotalWithShipping(), 0, ',', '.') }}</span>
                </div>
            </div>

            <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-top: 30px;">
                <h3 style="color: #6366f1; margin-top: 0;">Informasi Pengiriman</h3>
                <div style="margin-bottom: 10px;">
                    <strong>Metode:</strong> {{ $order->getShippingMethodLabel() }}
                </div>
                @if($order->shipping_method == 'jnt' && $order->shipping_address)
                    <div style="margin-bottom: 10px;">
                        <strong>Alamat:</strong><br>
                        <div style="white-space: pre-line; margin-top: 5px;">{{ $order->shipping_address }}</div>
                    </div>
                @elseif($order->shipping_method == 'pickup')
                    <div style="margin-bottom: 10px;">
                        <strong>Lokasi:</strong> Ambil langsung di lokasi produksi. Admin akan mengirimkan alamat lengkap via WhatsApp.
                    </div>
                @endif
            </div>

            <div style="background-color: #e0f2fe; padding: 20px; border-radius: 8px; margin-top: 20px; border-left: 4px solid #6366f1;">
                <h3 style="color: #6366f1; margin-top: 0;">💳 Informasi Pembayaran</h3>
                <p style="margin-bottom: 10px;">
                    <strong>Metode:</strong> {{ ucfirst($order->payment_method ?? 'Transfer') }}
                </p>
                @if($order->payment_info)
                    <div style="background-color: white; padding: 15px; border-radius: 6px; margin-top: 10px;">
                        <strong>Rekening/Instruksi Pembayaran:</strong><br>
                        <div style="white-space: pre-line; margin-top: 5px;">{{ $order->payment_info }}</div>
                    </div>
                @else
                    <p style="margin-bottom: 0;">
                        Admin akan mengirimkan informasi rekening dan instruksi pembayaran melalui WhatsApp setelah pesanan dikonfirmasi.
                    </p>
                @endif
            </div>

            @if($order->notes)
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-top: 20px;">
                <strong>Catatan:</strong><br>
                {{ $order->notes }}
            </div>
            @endif

            <div style="background-color: #e0f2fe; padding: 15px; border-radius: 8px; margin-top: 20px; border-left: 4px solid #6366f1;">
                <strong>📌 Langkah Selanjutnya:</strong><br>
                Pesanan Anda sedang dalam status <strong>Menunggu</strong>. Admin akan segera memproses pesanan Anda dan akan mengirimkan notifikasi melalui email setiap kali status pesanan berubah.
            </div>
        </div>

        <div class="footer">
            <p>Terima kasih telah berbelanja di <strong>Fay Collection</strong>!</p>
            <p style="margin-top: 10px; font-size: 12px; color: #999;">
                Jika Anda memiliki pertanyaan, silakan hubungi kami melalui WhatsApp: {{ $order->customer_contact }}
            </p>
        </div>
    </div>
</body>
</html>

