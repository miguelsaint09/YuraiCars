<?php

namespace App\Livewire;

use App\Models\Rental;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\On;

class RentalDetails extends Component
{
    public $rental;
    public $showModal = false;

    public function mount($rentalId)
    {
        $this->rental = Rental::with(['vehicle', 'payment', 'user.profile'])
            ->where('id', $rentalId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
    }

    #[On('show-details')]
    public function showDetails($rentalId)
    {
        if ($this->rental->id === $rentalId) {
            $this->showModal = true;
        }
    }

    public function toggleModal()
    {
        $this->showModal = !$this->showModal;
    }

    public function downloadInvoice()
    {
        $rental = $this->rental;
        
        $pdf = Pdf::loadView('pdf.invoice', [
            'rental' => $rental,
            'user' => $rental->user,
            'vehicle' => $rental->vehicle,
            'payment' => $rental->payment
        ]);

        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'invoice-' . $rental->id . '.pdf');
    }

    public function render()
    {
        return view('livewire.rental-details');
    }
} 