<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Order extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'users_id',
        'status',
        'total_harga',
        'alamat',
        // tambahkan kolom lain sesuai migration kamu
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
    public function histories()
    {
    return $this->hasMany(OrderStatusHistory::class, 'order_id');
}

    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }
}
