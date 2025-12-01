<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class OrderDetail extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'order_details';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'order_id',
        'laundry_service_id',
        'jumlah',
        'subtotal',
        // sesuaikan dengan migration
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function laundryService()
    {
        return $this->belongsTo(LaundryService::class, 'laundry_service_id');
    }
}
