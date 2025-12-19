@extends('layouts.front')
@section('title', 'Detail Pesanan')

@section('content')
<div class="card p-3" style="border-radius: 18px;">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="mb-0">Pesanan #{{ $order->id }}</h5>
        <span class="badge {{ $order->getStatusBadgeClass() }}">{{ $order->getStatusLabel() }}</span>
    </div>

    <div class="text-muted" style="font-size: .95rem;">
        Total: <strong class="text-success">Rp {{ number_format($order->total_amount,0,',','.') }}</strong><br>
        Nama: {{ $order->customer_name }}<br>
        WhatsApp: {{ $order->customer_contact }}<br>
        Alamat: {{ $order->shipping_address }}
    </div>

    @if($order->notes)
        <div class="mt-2 text-muted"><strong>Catatan:</strong> {{ $order->notes }}</div>
    @endif

    <hr>

    <h6 class="mb-2">Item</h6>
    @foreach($order->products as $p)
        <div class="d-flex justify-content-between mb-2">
            <div>
                <div class="fw-semibold">{{ $p->name }}</div>
                <small class="text-muted">
                    {{ $p->pivot->quantity }} x Rp {{ number_format($p->pivot->price,0,',','.') }}
                </small>
            </div>
            <div class="fw-semibold">
                Rp {{ number_format($p->pivot->quantity * $p->pivot->price,0,',','.') }}
            </div>
        </div>
    @endforeach

    <a href="{{ route('orders.mine') }}" class="btn btn-outline-dark btn-sm mt-3">Kembali</a>
</div>
@endsection
