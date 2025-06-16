<?php

namespace App\Livewire;

use App\Models\Rental;
use App\Models\Payment;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class RentalDetails extends Component
{
    public Rental $rental;
    
    public function mount(Rental $rental)
    {
        $this->rental = $rental->load(['vehicle', 'payments', 'user']);
    }

    public function downloadInvoice($paymentId = null)
    {
        if ($paymentId) {
            // Descargar factura de un pago específico
            $payment = $this->rental->payments()->where('id', $paymentId)->first();
            
            if (!$payment || $payment->status !== 'success') {
                session()->flash('error', 'No se puede descargar la factura. El pago debe estar completado.');
                return;
            }

            $pdf = PDF::loadView('pdf.payment-invoice', [
                'rental' => $this->rental,
                'vehicle' => $this->rental->vehicle,
                'payment' => $payment,
                'user' => $this->rental->user
            ]);

            $fileName = $payment->is_initial_payment 
                ? "factura-inicial-{$this->rental->id}.pdf"
                : "factura-adicional-{$payment->id}.pdf";

            return response()->streamDownload(function() use ($pdf) {
                echo $pdf->output();
            }, $fileName);
        } else {
            // Descargar factura completa del rental
            $this->downloadCompleteInvoice();
        }
    }

    public function downloadCompleteInvoice()
    {
        // Solo permitir si hay al menos un pago exitoso
        $successfulPayments = $this->rental->payments()->where('status', 'success')->get();
        
        if ($successfulPayments->isEmpty()) {
            session()->flash('error', 'No hay pagos completados para generar una factura.');
            return;
        }

        $pdf = PDF::loadView('pdf.complete-rental-invoice', [
            'rental' => $this->rental,
            'vehicle' => $this->rental->vehicle,
            'payments' => $successfulPayments,
            'user' => $this->rental->user
        ]);

        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, "factura-completa-{$this->rental->id}.pdf");
    }

    public function downloadPaymentInvoice($paymentId)
    {
        $this->downloadInvoice($paymentId);
    }

    public function render()
    {
        return view('livewire.rental-details')
            ->layout('components.layouts.app');
    }
} 