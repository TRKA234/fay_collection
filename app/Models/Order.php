<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_contact',
        'total_amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'integer',
    ];

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
}
