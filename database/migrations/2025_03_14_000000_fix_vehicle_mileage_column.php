<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First, add a temporary column
        Schema::table('vehicles', function (Blueprint $table) {
            $table->integer('mileage_new')->nullable();
        });

        // Convert the data
        $vehicles = DB::table('vehicles')->get();
        foreach ($vehicles as $vehicle) {
            if (is_string($vehicle->mileage)) {
                // Extract the numeric value from strings like "50000 km"
                $mileage = (int) preg_replace('/[^0-9]/', '', $vehicle->mileage);
                DB::table('vehicles')
                    ->where('id', $vehicle->id)
                    ->update(['mileage_new' => $mileage]);
            }
        }

        // Drop the old column and rename the new one
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('mileage');
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->renameColumn('mileage_new', 'mileage');
        });
    }

    public function down(): void
    {
        // In case of rollback, we'll just convert back to string format
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('mileage_old')->nullable();
        });

        $vehicles = DB::table('vehicles')->get();
        foreach ($vehicles as $vehicle) {
            DB::table('vehicles')
                ->where('id', $vehicle->id)
                ->update(['mileage_old' => $vehicle->mileage . ' km']);
        }

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('mileage');
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->renameColumn('mileage_old', 'mileage');
        });
    }
}; 