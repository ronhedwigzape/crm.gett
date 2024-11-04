<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use Illuminate\Http\Request;

class TourPackageController extends Controller
{
    // Display a listing of tour packages.
    public function index()
    {
        $tourPackages = TourPackage::all();
        return response()->json($tourPackages);
    }

    // Show the form for creating a new tour package.
    public function create()
    {
        // Typically used for returning a view in web applications.
    }

    // Store a newly created tour package in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id'   => 'required|exists:services,id',
            'package_name' => 'required|string|max:255',
            'destination'  => 'required|string|max:255',
            'amount'       => 'required|numeric',
            'itinerary'    => 'required|string',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
        ]);

        $tourPackage = TourPackage::create($validated);

        return response()->json($tourPackage, 201);
    }

    // Display the specified tour package.
    public function show(TourPackage $tourPackage)
    {
        return response()->json($tourPackage);
    }

    // Show the form for editing the specified tour package.
    public function edit(TourPackage $tourPackage)
    {
        // Typically used for returning a view in web applications.
    }

    // Update the specified tour package in storage.
    public function update(Request $request, TourPackage $tourPackage)
    {
        $validated = $request->validate([
            'service_id'   => 'required|exists:services,id',
            'package_name' => 'required|string|max:255',
            'destination'  => 'required|string|max:255',
            'amount'       => 'required|numeric',
            'itinerary'    => 'required|string',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
        ]);

        $tourPackage->update($validated);

        return response()->json($tourPackage, 200);
    }

    // Remove the specified tour package from storage.
    public function destroy(TourPackage $tourPackage)
    {
        $tourPackage->delete();

        return response()->noContent();
    }
}
