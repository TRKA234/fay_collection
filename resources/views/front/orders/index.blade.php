@extends('layouts.front')
@section('title', 'Pesanan Saya')

@section('content')
<h5 class="mb-3">Pesanan Saya</h5>

@if($orders->isEmpty())
    <div class="alert alert-info">Belum ada pesanan.</div>
@else
    <div class="card p-2" style="border-radius: 18px;">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>
                                <span class="badge {{ $order->getStatusBadgeClass() }}">
                                    {{ $order->getStatusLabel() }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <a class="btn btn-sm btn-outline-dark" href="{{ route('orders.mine.show', $order) }}">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $orders->links() }}</div>
@endif
@endsection
