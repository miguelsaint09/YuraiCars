<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class RentACarController extends Controller
{
    public function index()
    {
        try {
            // Verificar disponibilidad del sistema
            $availableVehicles = Vehicle::where('status', 'available')->count();
            
            return view('rent-a-car.index', [
                'availableVehicles' => $availableVehicles
            ]);
        } catch (\Exception $e) {
            // Log del error y manejo graceful
            \Log::error('Error en RentACarController@index: ' . $e->getMessage());
            
            return view('rent-a-car.index', [
                'availableVehicles' => 0
            ])->with('error', 'Error al cargar el sistema de reservas. Por favor intente más tarde.');
        }
    }
}
