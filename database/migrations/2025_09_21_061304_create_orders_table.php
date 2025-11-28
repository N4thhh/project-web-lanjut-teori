<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuId('users_id')->constrained('users')->onDelete('cascade');
            $table->string('status_pesanan', 30)->default('menunggu_penjemputan'); 
            $table->string('status_pembayaran', 30)->default('belum_bayar');       
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->text('alamat'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
