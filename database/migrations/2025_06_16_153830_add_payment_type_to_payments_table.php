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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('payment_type')->default('initial')->after('amount'); // 'initial' o 'additional'
            $table->text('description')->nullable()->after('payment_type'); // Descripción del pago
            $table->integer('additional_days')->nullable()->after('description'); // Días adicionales si es pago adicional
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['payment_type', 'description', 'additional_days']);
        });
    }
};
