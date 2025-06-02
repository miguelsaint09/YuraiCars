<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Ensure color is stored as string
            $table->string('color')->change();
            
            // Ensure features is stored as json
            $table->json('features')->change();
            
            // Ensure mileage is stored as integer
            $table->integer('mileage')->change();
            
            // Ensure price_per_day is stored as decimal
            $table->decimal('price_per_day', 10, 2)->change();
            
            // Ensure year is stored as year
            $table->year('year')->change();
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('color')->change();
            $table->json('features')->change();
            $table->string('mileage')->change();
            $table->decimal('price_per_day', 10, 2)->change();
            $table->year('year')->change();
        });
    }
}; 