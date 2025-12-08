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

    // Karena pakai UUID
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'users_id',
        'total_harga',
        'status_pesanan',
        'status_pembayaran',
        'alamat',
    ];

    /**
     * Relasi ke User (many to one)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    /**
     * Relasi ke OrderDetail (one to many)
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    /**
     * Relasi ke Payment (one to one)
     */
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }
}
