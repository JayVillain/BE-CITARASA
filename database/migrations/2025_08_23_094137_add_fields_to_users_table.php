<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('full_name')->after('id');        // Nama lengkap
            $table->string('username')->unique()->after('full_name'); // Username unik
            $table->string('phone_number')->nullable()->after('email'); // Nomor HP
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['full_name', 'username', 'phone_number']);
        });
    }
};
