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
    'is_active' => 'boolean',
    ];
}