<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        try {
            // Verificar si existen vehículos en la base de datos
            $vehicleCount = Vehicle::count();
            
            return view('vehicles.index', [
                'vehicleCount' => $vehicleCount
            ]);
        } catch (\Exception $e) {
            // Log del error y manejo graceful
            \Log::error('Error en VehicleController@index: ' . $e->getMessage());
            
            return view('vehicles.index', [
                'vehicleCount' => 0
            ])->with('error', 'Error al cargar los vehículos. Por favor intente más tarde.');
        }
    }
}
