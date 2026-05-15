<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // El nullable() permite que las reservas antiguas no tengan código y no den error
            $table->string('payment_code')->nullable()->unique()->after('id');
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid')->after('end_time');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['payment_code', 'payment_status']);
        });
    }
};