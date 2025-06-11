<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up()
    {
        // 1. Create temporary columns
        Schema::table('reviews', function (Blueprint $table) {
            $table->uuid('uuid')->nullable();
            $table->uuid('user_uuid')->nullable();
            $table->uuid('vehicle_uuid')->nullable();
        });

        // 2. Copy data to temporary columns
        $reviews = DB::table('reviews')->get();
        foreach ($reviews as $review) {
            // Get the user and vehicle UUIDs from their respective tables
            $user = DB::table('users')->where('id', $review->user_id)->first();
            $vehicle = DB::table('vehicles')->where('id', $review->vehicle_id)->first();
            
            if ($user && $vehicle) {
                DB::table('reviews')
                    ->where('id', $review->id)
                    ->update([
                        'uuid' => (string) Str::uuid(),
                        'user_uuid' => $user->id,
                        'vehicle_uuid' => $vehicle->id
                    ]);
            }
        }

        // 3. Drop old columns and foreign keys
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['vehicle_id']);
            $table->dropColumn(['id', 'user_id', 'vehicle_id']);
        });

        // 4. Rename new columns
        Schema::table('reviews', function (Blueprint $table) {
            $table->renameColumn('uuid', 'id');
            $table->renameColumn('user_uuid', 'user_id');
            $table->renameColumn('vehicle_uuid', 'vehicle_id');
        });

        // 5. Add primary key and foreign key constraints
        Schema::table('reviews', function (Blueprint $table) {
            $table->primary('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
        });
    }

    public function down()
    {
        // This is a destructive change, so we'll just recreate the original structure
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['vehicle_id']);
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropPrimary();
            $table->dropColumn(['id', 'user_id', 'vehicle_id']);
            
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
        });
    }
}; 