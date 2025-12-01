<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('order_status_histories', function (Blueprint $table) {
        $table->id();
        $table->uuid('order_id');          // id pesanan
        $table->string('status_lama')->nullable(); // status sebelum diubah
        $table->string('status_baru');            // status sesudah diubah
        $table->text('catatan')->nullable();      // catatan opsional
        $table->unsignedBigInteger('changed_by')->nullable(); // id user/admin yang ubah
        $table->timestamps();

        $table->foreign('order_id')
              ->references('id')
              ->on('orders')
              ->onDelete('cascade');
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_status_histories');
    }
};
