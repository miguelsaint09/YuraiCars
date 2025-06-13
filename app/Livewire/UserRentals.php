<?php

namespace App\Livewire;

use App\Enums\RentalStatus;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UserRentals extends Component
{
    public function continueBooking($rentalId)
    {
        $rental = Rental::find($rentalId);
        if ($rental && in_array($rental->status, [RentalStatus::SELECTED->value, RentalStatus::PENDING->value])) {
            return redirect()->route('rent-a-car.show', ['vehicle' => $rental->vehicle_id]);
        }
    }

    public function viewRentalDetails($rentalId)
    {
        return redirect()->route('rentals.show', ['rental' => $rentalId]);
    }

    public function deleteRental($rentalId)
    {
        try {
            DB::beginTransaction();
            
            $rental = Rental::where('id', $rentalId)
                ->where('user_id', Auth::id())
                ->where('status', RentalStatus::SELECTED->value)
                ->first();

            if ($rental) {
                // Eliminar la renta
                $rental->delete();
                DB::commit();
                session()->flash('status', 'Rental deleted successfully.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Could not delete the rental. Please try again.');
        }
    }

    public function render()
    {
        $rentals = Rental::where('user_id', Auth::id())
            ->with(['vehicle', 'payment'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.user-rentals', compact('rentals'))
            ->layout('components.layouts.app');
    }
}
