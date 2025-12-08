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
        Schema::create('order_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('laundry_service_id')->constrained('laundry_services')->onDelete('cascade');
            $table->decimal('harga_per_kg', 12, 2);
            $table->decimal('harga_satuan', 12, 2)->default(0); 
            $table->decimal('berat', 10, 2)->default(0);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};