<?php

namespace App\Http\Controllers;

use App\Models\TouristVisa;
use Illuminate\Http\Request;

class TouristVisaController extends Controller
{
    // Display a listing of tourist visas
    public function index()
    {
        $touristVisas = TouristVisa::with('client', 'service')->get();
        return response()->json($touristVisas);
    }

    // Store a newly created tourist visa
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id'  => 'required|exists:services,id',
            'visa_type'   => 'required|string',
            'country'     => 'required|string',
            'issue_date'  => 'required|date',
            'expiry_date' => 'required|date|after:issue_date',
            'visa_fee'    => 'required|numeric|min:0',
        ]);

        $touristVisa = TouristVisa::create($validated);

        return response()->json($touristVisa, 201);
    }

    // Display the specified tourist visa
    public function show(TouristVisa $touristVisa)
    {
        $touristVisa->load('client', 'service');
        return response()->json($touristVisa);
    }

    // Update the specified tourist visa
    public function update(Request $request, TouristVisa $touristVisa)
    {
        $validated = $request->validate([
            'visa_type'   => 'sometimes|required|string',
            'country'     => 'sometimes|required|string',
            'issue_date'  => 'sometimes|required|date',
            'expiry_date' => 'sometimes|required|date|after:issue_date',
            'visa_fee'    => 'sometimes|required|numeric|min:0',
        ]);

        $touristVisa->update($validated);

        return response()->json($touristVisa, 200);
    }

    // Remove the specified tourist visa
    public function destroy(TouristVisa $touristVisa)
    {
        $touristVisa->delete();

        return response()->noContent();
    }
}
