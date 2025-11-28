<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'payments';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'order_id',
        'metode_pembayaran',
        'jumlah_bayar',
        'status',
        'tanggal_bayar',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
    ];

    // Default values
    protected $attributes = [
        'metode_pembayaran' => null,
        'status' => 'belum_bayar',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}