<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Review;

class VehicleReviewController extends Controller
{
    public function store(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $vehicle->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', '¡Gracias por tu reseña!');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['reviews.user.profile']);
        return view('vehicles.reviews', compact('vehicle'));
    }
} 