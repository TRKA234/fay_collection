<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pesanan Diperbarui</title>
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
        .status-box {
            text-align: center;
            padding: 30px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .status-paid {
            background-color: #dbeafe;
            border: 2px solid #3b82f6;
        }
        .status-shipped {
            background-color: #e0e7ff;
            border: 2px solid #6366f1;
        }
        .status-completed {
            background-color: #d1fae5;
            border: 2px solid #10b981;
        }
        .status-cancelled {
            background-color: #fee2e2;
            border: 2px solid #ef4444;
        }
        .status-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .status-title {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }
        .status-paid .status-title { color: #1e40af; }
        .status-shipped .status-title { color: #4338ca; }
        .status-completed .status-title { color: #047857; }
        .status-cancelled .status-title { color: #991b1b; }
        .order-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
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
        .message-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #6366f1;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Status Pesanan Diperbarui</h1>
        </div>

        <div class="content">
            <p>Halo <strong>{{ $order->customer_name }}</strong>,</p>
            
            <p>Status pesanan Anda telah diperbarui. Berikut adalah informasi terbaru:</p>

            @if($order->status == 'paid')
            <div class="status-box status-paid">
                <div class="status-icon">💳</div>
                <div class="status-title">Pembayaran Dikonfirmasi</div>
                <p>Pembayaran Anda telah dikonfirmasi. Pesanan sedang dipersiapkan untuk dikirim.</p>
            </div>
            @elseif($order->status == 'shipped')
            <div class="status-box status-shipped">
                <div class="status-icon">🚚</div>
                <div class="status-title">Pesanan Dikirim</div>
                <p>Pesanan Anda telah dikirim! Silakan tunggu kedatangan paket Anda.</p>
            </div>
            @elseif($order->status == 'completed')
            <div class="status-box status-completed">
                <div class="status-icon">✅</div>
                <div class="status-title">Pesanan Selesai</div>
                <p>Pesanan Anda telah selesai. Terima kasih telah berbelanja di Fay Collection!</p>
            </div>
            @elseif($order->status == 'cancelled')
            <div class="status-box status-cancelled">
                <div class="status-icon">❌</div>
                <div class="status-title">Pesanan Dibatalkan</div>
                <p>Pesanan Anda telah dibatalkan. Jika Anda memiliki pertanyaan, silakan hubungi kami.</p>
            </div>
            @endif

            <div class="order-info">
                <h2 style="color: #6366f1; margin-top: 0;">Detail Pesanan</h2>
                <div class="info-row">
                    <span class="info-label">Nomor Pesanan:</span>
                    <span class="info-value"><strong>#{{ $order->id }}</strong></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Total Pesanan:</span>
                    <span class="info-value"><strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Update:</span>
                    <span class="info-value">{{ $order->updated_at->format('d F Y, H:i') }}</span>
                </div>
            </div>

            @if($order->status == 'shipped')
            <div class="message-box">
                <strong>📦 Informasi Pengiriman:</strong><br>
                Pesanan Anda sedang dalam perjalanan. Silakan pastikan alamat pengiriman Anda benar dan ada yang menerima paket.
            </div>
            @elseif($order->status == 'completed')
            <div class="message-box">
                <strong>💝 Terima Kasih!</strong><br>
                Kami berharap Anda puas dengan pembelian Anda. Jangan lupa untuk memberikan review dan rating produk yang Anda beli!
            </div>
            @elseif($order->status == 'cancelled')
            <div class="message-box">
                <strong>ℹ️ Informasi:</strong><br>
                Jika Anda memiliki pertanyaan mengenai pembatalan pesanan ini, silakan hubungi kami melalui WhatsApp.
            </div>
            @endif
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

