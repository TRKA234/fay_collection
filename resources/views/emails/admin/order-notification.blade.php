<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Pesanan - Admin</title>
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
        .alert-box {
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #6366f1;
            background-color: #e0e7ff;
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
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-paid { background-color: #dbeafe; color: #1e40af; }
        .status-shipped { background-color: #e0e7ff; color: #4338ca; }
        .status-completed { background-color: #d1fae5; color: #047857; }
        .status-cancelled { background-color: #fee2e2; color: #991b1b; }
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
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #6366f1;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
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
            <h1>🔔 Notifikasi Pesanan</h1>
        </div>

        <div class="content">
            @if($notificationType == 'new_order')
            <div class="alert-box">
                <strong>📦 Pesanan Baru!</strong><br>
                Ada pesanan baru yang perlu diproses.
            </div>
            @else
            <div class="alert-box">
                <strong>🔄 Status Pesanan Diubah!</strong><br>
                Status pesanan telah diperbarui.
            </div>
            @endif

            <div class="order-info">
                <h2>Detail Pesanan</h2>
                <div class="info-row">
                    <span class="info-label">Nomor Pesanan:</span>
                    <span class="info-value"><strong>#{{ $order->id }}</strong></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Nama Pembeli:</span>
                    <span class="info-value">{{ $order->customer_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Kontak WhatsApp:</span>
                    <span class="info-value">{{ $order->customer_contact }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ $order->status }}">{{ $order->getStatusLabel() }}</span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Pesanan:</span>
                    <span class="info-value">{{ $order->created_at->format('d F Y, H:i') }}</span>
                </div>
                @if($notificationType == 'status_changed')
                <div class="info-row">
                    <span class="info-label">Terakhir Diupdate:</span>
                    <span class="info-value">{{ $order->updated_at->format('d F Y, H:i') }}</span>
                </div>
                @endif
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
                Total Pesanan: <span style="color: #6366f1; font-size: 24px;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>

            @if($order->notes)
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-top: 20px;">
                <strong>Catatan:</strong><br>
                {{ $order->notes }}
            </div>
            @endif

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ url('/admin/orders/' . $order->id) }}" class="button">Lihat Detail Pesanan</a>
            </div>
        </div>

        <div class="footer">
            <p><strong>Fay Collection</strong> - Admin Panel</p>
            <p style="margin-top: 10px; font-size: 12px; color: #999;">
                Email ini dikirim secara otomatis dari sistem.
            </p>
        </div>
    </div>
</body>
</html>

