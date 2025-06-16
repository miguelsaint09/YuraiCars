<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rental;
use App\Models\Payment;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;

class MultiplePaymentsSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Obtener un usuario y vehículo existente
        $user = User::first();
        $vehicle = Vehicle::first();

        if (!$user || !$vehicle) {
            $this->command->info('Se necesita al menos un usuario y un vehículo para crear datos de prueba.');
            return;
        }

        // Crear rental de prueba con extensión
        $startTime = Carbon::now()->addDays(1);
        $originalEndTime = Carbon::now()->addDays(4); // 3 días iniciales
        $extendedEndTime = Carbon::now()->addDays(7); // Extendido a 6 días

        $rental = Rental::create([
            'user_id' => $user->id,
            'vehicle_id' => $vehicle->id,
            'start_time' => $startTime,
            'end_time' => $extendedEndTime, // Ya extendido
            'pickup_location' => 'Aeropuerto Las Américas',
            'dropoff_location' => 'Hotel Zona Colonial',
            'status' => 'confirmed',
        ]);

        // Crear pago inicial (por los 3 días originales)
        $initialDays = 3;
        $initialAmount = $initialDays * $vehicle->price_per_day;
        
        Payment::create([
            'rental_id' => $rental->id,
            'amount' => $initialAmount,
            'payment_type' => 'initial',
            'description' => 'Pago inicial del alquiler',
            'additional_days' => null,
            'payment_method' => 'credit_card',
            'status' => 'success',
            'created_at' => $startTime->copy()->subDays(2),
        ]);

        // Crear pago adicional (por los 3 días extra)
        $additionalDays = 3;
        $additionalAmount = $additionalDays * $vehicle->price_per_day;
        
        Payment::create([
            'rental_id' => $rental->id,
            'amount' => $additionalAmount,
            'payment_type' => 'additional',
            'description' => "Extensión del alquiler por {$additionalDays} día(s) adicional(es)",
            'additional_days' => $additionalDays,
            'payment_method' => 'credit_card',
            'status' => 'success',
            'created_at' => $startTime->copy()->subDays(1),
        ]);

        // Crear otro rental con pago pendiente
        $rental2 = Rental::create([
            'user_id' => $user->id,
            'vehicle_id' => $vehicle->id,
            'start_time' => Carbon::now()->addDays(10),
            'end_time' => Carbon::now()->addDays(15), // 5 días extendidos
            'pickup_location' => 'Centro de la Ciudad',
            'dropoff_location' => 'Aeropuerto Cibao',
            'status' => 'pending',
        ]);

        // Pago inicial completado
        Payment::create([
            'rental_id' => $rental2->id,
            'amount' => 3 * $vehicle->price_per_day, // Por 3 días originales
            'payment_type' => 'initial',
            'description' => 'Pago inicial del alquiler',
            'additional_days' => null,
            'payment_method' => 'debit_card',
            'status' => 'success',
            'created_at' => Carbon::now()->subDays(3),
        ]);

        // Pago adicional pendiente (por extensión)
        Payment::create([
            'rental_id' => $rental2->id,
            'amount' => 2 * $vehicle->price_per_day, // Por 2 días extra
            'payment_type' => 'additional',
            'description' => 'Extensión del alquiler por 2 día(s) adicional(es)',
            'additional_days' => 2,
            'payment_method' => 'pending',
            'status' => 'pending',
            'created_at' => Carbon::now()->subDays(1),
        ]);

        $this->command->info('✅ Datos de prueba creados exitosamente:');
        $this->command->info("   - Rental 1: {$rental->id} (completamente pagado)");
        $this->command->info("   - Rental 2: {$rental2->id} (con pago pendiente)");
    }
}
