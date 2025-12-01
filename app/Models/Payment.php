<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // karena id di tabel lain UUID (char(36)), kita samakan
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'order_id',
        'metode_pembayaran',
        'status',
        'jumlah_bayar',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
