<?php

namespace App\Http\Controllers;

use App\Models\FlightTicket;
use Illuminate\Http\Request;

class FlightTicketController extends Controller
{
    // Display a listing of flight tickets.
    public function index()
    {
        $flightTickets = FlightTicket::all();
        return response()->json($flightTickets);
    }

    // Show the form for creating a new flight ticket.
    public function create()
    {
        // Typically used for returning a view in web applications.
    }

    // Store a newly created flight ticket in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id'        => 'required|exists:services,id',
            'airline_id'        => 'required|exists:airlines,id',
            'flight_number'     => 'required|string|max:50',
            'departure_airport' => 'required|string|max:255',
            'arrival_airport'   => 'required|string|max:255',
            'departure_date'    => 'required|date',
            'amount'            => 'required|numeric',
            'arrival_date'      => 'required|date|after_or_equal:departure_date',
            'seat_class'        => 'required|string|max:50',
        ]);

        $flightTicket = FlightTicket::create($validated);

        return response()->json($flightTicket, 201);
    }

    // Display the specified flight ticket.
    public function show(FlightTicket $flightTicket)
    {
        return response()->json($flightTicket);
    }

    // Show the form for editing the specified flight ticket.
    public function edit(FlightTicket $flightTicket)
    {
        // Typically used for returning a view in web applications.
    }

    // Update the specified flight ticket in storage.
    public function update(Request $request, FlightTicket $flightTicket)
    {
        $validated = $request->validate([
            'service_id'        => 'required|exists:services,id',
            'airline_id'        => 'required|exists:airlines,id',
            'flight_number'     => 'required|string|max:50',
            'departure_airport' => 'required|string|max:255',
            'arrival_airport'   => 'required|string|max:255',
            'departure_date'    => 'required|date',
            'amount'            => 'required|numeric',
            'arrival_date'      => 'required|date|after_or_equal:departure_date',
            'seat_class'        => 'required|string|max:50',
        ]);

        $flightTicket->update($validated);

        return response()->json($flightTicket, 200);
    }

    // Remove the specified flight ticket from storage.
    public function destroy(FlightTicket $flightTicket)
    {
        $flightTicket->delete();

        return response()->noContent();
    }
}
