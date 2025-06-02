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
            $table->json('image_url_new')->nullable();
        });

        // Convert the data
        $vehicles = DB::table('vehicles')->get();
        foreach ($vehicles as $vehicle) {
            $imageUrl = $vehicle->image_url;
            $newImageUrl = null;
            
            if ($imageUrl) {
                // If it's a string, convert it to an array with a single value
                $newImageUrl = [$imageUrl];
            }

            DB::table('vehicles')
                ->where('id', $vehicle->id)
                ->update(['image_url_new' => $newImageUrl ? json_encode($newImageUrl) : null]);
        }

        // Drop the old column and rename the new one
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('image_url');
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->renameColumn('image_url_new', 'image_url');
        });
    }

    public function down(): void
    {
        // In case of rollback, we'll convert back to string format
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('image_url_old')->nullable();
        });

        $vehicles = DB::table('vehicles')->get();
        foreach ($vehicles as $vehicle) {
            $imageUrls = json_decode($vehicle->image_url, true);
            $oldImageUrl = $imageUrls && count($imageUrls) > 0 ? $imageUrls[0] : null;

            DB::table('vehicles')
                ->where('id', $vehicle->id)
                ->update(['image_url_old' => $oldImageUrl]);
        }

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('image_url');
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->renameColumn('image_url_old', 'image_url');
        });
    }
}; 