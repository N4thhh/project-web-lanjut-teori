<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaundryService extends Model
{
    use HasFactory;

    protected $table = 'laundry_services';

    protected $fillable = [
        'nama_layanan',
        'deskripsi',
        'harga',
        'is_active',
    ];

    protected $casts = [
        'harga' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke OrderDetail
     * 1 layanan bisa digunakan di banyak order detail
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'laundry_service_id');
    }

    /**
     * Scope untuk mengambil layanan yang aktif saja
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Accessor: Format harga menjadi "Rp xx.xxx"
     */
    public function getHargaFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}
