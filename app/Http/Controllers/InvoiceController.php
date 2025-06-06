<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function download(Rental $rental)
    {
        // Verificar que el usuario actual es el dueño de la renta o es admin
        if (Auth::id() !== $rental->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        // Verificar que la renta está finalizada y confirmada
        if (!in_array($rental->status, ['confirmed', 'completed'])) {
            abort(403, 'Solo se pueden descargar facturas de rentas confirmadas o completadas.');
        }

        // Cargar las relaciones necesarias
        $rental->load(['user.profile', 'vehicle', 'payment']);

        // Generar el PDF
        $pdf = PDF::loadView('pdf.invoice', [
            'rental' => $rental,
            'user' => $rental->user,
            'vehicle' => $rental->vehicle,
            'payment' => $rental->payment,
        ]);

        // Descargar el PDF
        return $pdf->download("factura-{$rental->id}.pdf");
    }
} 