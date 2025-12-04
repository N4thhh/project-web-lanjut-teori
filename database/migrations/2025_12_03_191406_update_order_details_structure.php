<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            // rename kolom lama ke nama yang kita pakai di kode
            if (Schema::hasColumn('order_details', 'service_id')) {
                $table->renameColumn('service_id', 'laundry_service_id');
            }

            if (Schema::hasColumn('order_details', 'jumlah')) {
                $table->renameColumn('jumlah', 'berat');
            }

            // tambahkan kolom keterangan kalau belum ada
            if (! Schema::hasColumn('order_details', 'keterangan')) {
                $table->string('keterangan')->nullable();
            }

            // tambahkan kolom harga_satuan kalau belum ada
            if (! Schema::hasColumn('order_details', 'harga_satuan')) {
                $table->decimal('harga_satuan', 12, 2)->default(0);
            }
        });

        // Update harga_satuan dari harga_per_kg untuk data yang sudah ada
        DB::statement("
            UPDATE order_details 
            SET harga_satuan = harga_per_kg 
            WHERE harga_satuan = 0 OR harga_satuan IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            // balikin lagi kalau di-rollback
            if (Schema::hasColumn('order_details', 'laundry_service_id')) {
                $table->renameColumn('laundry_service_id', 'service_id');
            }

            if (Schema::hasColumn('order_details', 'berat')) {
                $table->renameColumn('berat', 'jumlah');
            }

            if (Schema::hasColumn('order_details', 'keterangan')) {
                $table->dropColumn('keterangan');
            }

            if (Schema::hasColumn('order_details', 'harga_satuan')) {
                $table->dropColumn('harga_satuan');
            }
        });
    }
};