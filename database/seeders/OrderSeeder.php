<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\User;
use App\Models\LaundryService;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = User::where('role', 'customer')->first();
        
        if (!$customer) {
            $this->command->info('User customer tidak ditemukan. Jalankan UserSeeder terlebih dahulu.');
            return;
        }

        $service = LaundryService::first();

        if (!$service) {
            $this->command->info('Layanan laundry tidak ditemukan. Jalankan LaundryServiceSeeder terlebih dahulu.');
            return;
        }

        $order2 = Order::create([
            'users_id'          => $customer->id,
            'alamat'            => 'Jl. Contoh No. 2 (Siap Bayar)',
            'status_pesanan'    => 'menunggu_pembayaran',
            'status_pembayaran' => 'belum_bayar',
            'total_harga'       => 17500,
        ]);

        OrderDetail::create([
            'order_id'           => $order2->id,
            'laundry_service_id' => $service->id,
            'berat'              => 5,
            'harga_per_kg'       => $service->harga,
            'harga_satuan'       => $service->harga,
            'subtotal'           => 5 * $service->harga,
        ]);

        Payment::create([
            'order_id'          => $order2->id,
            'jumlah_bayar'      => 17500,
            'status'            => 'belum_bayar',
            'metode_pembayaran' => 'belum_dipilih',
        ]);


        $order3 = Order::create([
            'users_id'          => $customer->id,
            'alamat'            => 'Jl. Contoh No. 3 (Sedang Dicuci)',
            'status_pesanan'    => 'proses_pencucian',
            'status_pembayaran' => 'lunas',
            'total_harga'       => 35000, // 10kg
        ]);

        OrderDetail::create([
            'order_id'           => $order3->id,
            'laundry_service_id' => $service->id,
            'berat'              => 10,
            'harga_per_kg'       => $service->harga,
            'harga_satuan'       => $service->harga,
            'subtotal'           => 10 * $service->harga,
        ]);

        Payment::create([
            'order_id'          => $order3->id,
            'jumlah_bayar'      => 35000,
            'status'            => 'lunas',
            'metode_pembayaran' => 'transfer_bca',
            'tanggal_bayar'     => now()->subHours(5),
        ]);
        
        $order4 = Order::create([
            'users_id'          => $customer->id,
            'alamat'            => 'Jl. Contoh No. 4 (Selesai)',
            'status_pesanan'    => 'selesai',
            'status_pembayaran' => 'lunas',
            'total_harga'       => 28000,
        ]);

         OrderDetail::create([
            'order_id'           => $order4->id,
            'laundry_service_id' => $service->id,
            'berat'              => 8,
            'harga_per_kg'       => $service->harga,
            'harga_satuan'       => $service->harga,
            'subtotal'           => 8 * $service->harga,
        ]);

        Payment::create([
            'order_id'          => $order4->id,
            'jumlah_bayar'      => 28000,
            'status'            => 'lunas',
            'metode_pembayaran' => 'transfer_bri',
            'tanggal_bayar'     => now()->subDays(2),
        ]);
    }
}