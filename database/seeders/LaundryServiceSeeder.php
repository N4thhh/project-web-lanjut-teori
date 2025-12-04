<?php

namespace Database\Seeders;

use App\Models\LaundryService;
use Illuminate\Database\Seeder;

class LaundryServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'nama_layanan' => 'Cuci Komplit (Cuci + Setrika)',
                'harga' => 8000,
                'deskripsi' => 'Pakaian dicuci bersih, diberi pewangi, dan disetrika rapi. Siap langsung dipakai.',
                'is_active' => true,
            ],
            [
                'nama_layanan' => 'Cuci Kering (Lipat)',
                'harga' => 6000,
                'deskripsi' => 'Pakaian dicuci bersih dan dilipat rapi tanpa disetrika. Cocok untuk pakaian santai.',
                'is_active' => true,
            ],
            [
                'nama_layanan' => 'Setrika Saja',
                'harga' => 5000,
                'deskripsi' => 'Layanan khusus menyetrika pakaian yang sudah bersih agar rapi dan licin.',
                'is_active' => true,
            ],
            [
                'nama_layanan' => 'Cuci Bedcover/Selimut',
                'harga' => 15000,
                'deskripsi' => 'Pencucian khusus untuk bedcover, selimut, atau sprei tebal agar bebas tungau dan wangi.',
                'is_active' => true,
            ],
            [
                'nama_layanan' => 'Cuci Karpet',
                'harga' => 20000,
                'deskripsi' => 'Pembersihan mendalam untuk karpet agar bersih dari debu dan kotoran membandel.',
                'is_active' => true,
            ],
            [
                'nama_layanan' => 'Cuci Boneka',
                'harga' => 10000,
                'deskripsi' => 'Layanan cuci boneka agar kembali bersih, lembut, dan wangi seperti baru.',
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            LaundryService::create($service);
        }
    }
}