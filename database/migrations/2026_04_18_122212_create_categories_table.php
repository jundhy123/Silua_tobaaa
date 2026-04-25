<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id('category_id'); // primary key custom
            $table->string('category_name', 100);
            $table->timestamp('created')->nullable();
            $table->timestamp('updated')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};