<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;

class AirlineController extends Controller
{
    // Display a listing of airlines.
    public function index()
    {
        $airlines = Airline::all();
        return response()->json($airlines);
    }

    // Show the form for creating a new airline.
    public function create()
    {
        // Typically used for returning a view in web applications.
    }

    // Store a newly created airline in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:airlines',
        ]);

        $airline = Airline::create($validated);

        return response()->json($airline, 201);
    }

    // Display the specified airline.
    public function show(Airline $airline)
    {
        return response()->json($airline);
    }

    // Show the form for editing the specified airline.
    public function edit(Airline $airline)
    {
        // Typically used for returning a view in web applications.
    }

    // Update the specified airline in storage.
    public function update(Request $request, Airline $airline)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:airlines,code,' . $airline->id,
        ]);

        $airline->update($validated);

        return response()->json($airline, 200);
    }

    // Remove the specified airline from storage.
    public function destroy(Airline $airline)
    {
        $airline->delete();

        return response()->noContent();
    }
}
