<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique(); // Nomor meja
            $table->enum('status', ['available', 'occupied', 'reserved', 'cleaning'])->default('available');
            $table->integer('capacity')->default(4); // kapasitas kursi
            $table->string('qr_code')->nullable();   // bisa simpan kode unik
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
