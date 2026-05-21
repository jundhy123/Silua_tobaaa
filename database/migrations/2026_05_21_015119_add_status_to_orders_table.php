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
    Schema::table('orders', function (Blueprint $table) {
        // Cek jika kolom 'status' belum ada, maka tambahkan
        if (!Schema::hasColumn('orders', 'status')) {
            $table->string('status')->default('pending');
        }
        
        // Cek jika kolom 'reject_reason' belum ada, maka tambahkan
        if (!Schema::hasColumn('orders', 'reject_reason')) {
            $table->text('reject_reason')->nullable();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
