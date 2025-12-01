<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'status_lama',
        'status_baru',
        'catatan',
        'changed_by',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        // siapa yang mengubah (admin/user)
        return $this->belongsTo(User::class, 'changed_by');
    }
}
