<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrderDetail extends Model
{
    use HasFactory;
    
    protected $table = 'order_details';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'order_id',
        'laundry_service_id',
        'harga_per_kg',
        'berat',           // sudah diganti dari 'jumlah'
        'subtotal',
        'harga_satuan',    // sudah ditambahkan
        'keterangan'       // sudah ditambahkan
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

    public function laundryService()
    {
        // relasi benar (belongsTo)
        return $this->belongsTo(LaundryService::class, 'laundry_service_id', 'id');
    }

    public function order()
    {
        // relasi benar (belongsTo)
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
