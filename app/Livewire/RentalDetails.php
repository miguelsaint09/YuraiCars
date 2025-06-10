<?php

namespace App\Livewire;

use App\Models\Rental;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class RentalDetails extends Component
{
    public Rental $rental;
    
    public function mount(Rental $rental)
    {
        $this->rental = $rental->load(['vehicle', 'payment', 'user']);
    }

    public function downloadInvoice()
    {
        // Only allow download if payment exists and is successful
        if (!$this->rental->payment || $this->rental->payment->status !== 'success') {
            session()->flash('error', 'No se puede descargar la factura. El pago debe estar completado.');
            return;
        }

        $pdf = PDF::loadView('pdf.rental-invoice', [
            'rental' => $this->rental,
            'vehicle' => $this->rental->vehicle,
            'payment' => $this->rental->payment,
            'user' => $this->rental->user
        ]);

        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, "factura-{$this->rental->id}.pdf");
    }

    public function render()
    {
        return view('livewire.rental-details');
    }
} 