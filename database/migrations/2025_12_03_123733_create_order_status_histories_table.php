<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_status_histories', function (Blueprint $table) {
            $table->id();

            // orders.id = UUID
            $table->foreignUuid('order_id')
                ->constrained('orders')
                ->onDelete('cascade');

            // users.id = UUID
            $table->uuid('user_id')->nullable();

            $table->string('old_status')->nullable();
            $table->string('new_status');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_status_histories');
    }
};
