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
        // Verificar que el usuario tenga acceso a esta renta
        if ($rental->user_id !== Auth::id()) {
            abort(403);
        }

        // Verificar que la renta esté completada y confirmada
        if (!in_array($rental->status, ['completed', 'confirmed'])) {
            abort(404);
        }

        $pdf = PDF::loadView('pdf.invoice', [
            'rental' => $rental,
            'user' => $rental->user,
            'vehicle' => $rental->vehicle,
            'payment' => $rental->payment,
        ]);

        return $pdf->download("factura-{$rental->id}.pdf");
    }
} 