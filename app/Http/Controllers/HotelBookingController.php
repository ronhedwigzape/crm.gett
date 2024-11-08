<?php

namespace App\Http\Controllers;

use App\Models\HotelBooking;
use Illuminate\Http\Request;

class HotelBookingController extends Controller
{
    // Display a listing of hotel bookings
    public function index()
    {
        $hotelBookings = HotelBooking::with('client', 'service')->get();
        return response()->json($hotelBookings);
    }

    // Store a newly created hotel booking
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id'     => 'required|exists:services,id',
            'hotel_name'     => 'required|string',
            'location'       => 'required|string',
            'check_in_date'  => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'num_guests'     => 'required|integer|min:1',
            'amount'         => 'required|numeric|min:0',
        ]);

        $hotelBooking = HotelBooking::create($validated);

        return response()->json($hotelBooking, 201);
    }

    // Display the specified hotel booking
    public function show(HotelBooking $hotelBooking)
    {
        $hotelBooking->load('client', 'service');
        return response()->json($hotelBooking);
    }

    // Update the specified hotel booking
    public function update(Request $request, HotelBooking $hotelBooking)
    {
        $validated = $request->validate([
            'hotel_name'     => 'sometimes|required|string',
            'location'       => 'sometimes|required|string',
            'check_in_date'  => 'sometimes|required|date',
            'check_out_date' => 'sometimes|required|date|after:check_in_date',
            'num_guests'     => 'sometimes|required|integer|min:1',
            'amount'         => 'sometimes|required|numeric|min:0',
        ]);

        $hotelBooking->update($validated);

        return response()->json($hotelBooking, 200);
    }

    // Remove the specified hotel booking
    public function destroy(HotelBooking $hotelBooking)
    {
        $hotelBooking->delete();

        return response()->noContent();
    }
}
