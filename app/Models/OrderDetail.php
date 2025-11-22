<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'laundry_service_id',
        'harga_per_kg',
        'jumlah',
        'subtotal'
    ];

    public function laundryService()
    {
        return $this->belongsTo(LaundryService::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}