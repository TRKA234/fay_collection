<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_contact',
        'shipping_address',
        'shipping_method',
        'shipping_cost',
        'payment_method',
        'payment_info',
        'total_amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'integer',
        'shipping_cost' => 'integer',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the products for the order.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeClass()
    {
        return match ($this->status) {
            'pending' => 'bg-warning text-dark',
            'paid' => 'bg-info text-dark',
            'shipped' => 'bg-primary',
            'completed' => 'bg-success',
            'cancelled' => 'bg-danger',
            default => 'bg-secondary',
        };
    }

    /**
     * Get status label in Indonesian
     */
    public function getStatusLabel()
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'paid' => 'Sudah Dibayar',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $this->status,
        };
    }

    /**
     * Get shipping method label
     */
    public function getShippingMethodLabel()
    {
        return match ($this->shipping_method) {
            'jnt' => 'JNT Express',
            'pickup' => 'Ambil di Lokasi',
            default => $this->shipping_method,
        };
    }

    /**
     * Get total amount including shipping
     */
    public function getTotalWithShipping()
    {
        return $this->total_amount + $this->shipping_cost;
    }
}
