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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('license_plate')->unique();
            $table->string('name');
            $table->string('make');
            $table->string('model');
            $table->year('year');
            $table->string('color');
            $table->string('category');
            $table->string('image_url')->nullable();
            $table->integer('seats');
            $table->integer('luggage_capacity');
            $table->string('transmission');
            $table->string('fuel_type', );
            $table->decimal('price_per_day', 10, 2);
            $table->string('mileage');
            $table->string('fuel_efficiency')->nullable();
            $table->text('remarks')->nullable();
            $table->string('status');
            $table->json('features');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
