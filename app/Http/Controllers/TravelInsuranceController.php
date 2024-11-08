<?php

namespace App\Http\Controllers;

use App\Models\TravelInsurance;
use Illuminate\Http\Request;

class TravelInsuranceController extends Controller
{
    // Display a listing of travel insurances
    public function index()
    {
        $travelInsurances = TravelInsurance::with('client', 'service')->get();
        return response()->json($travelInsurances);
    }

    // Store a newly created travel insurance
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id'         => 'required|exists:services,id',
            'insurance_provider' => 'required|string',
            'policy_number'      => 'required|string|unique:travel_insurances,policy_number',
            'start_date'         => 'required|date',
            'end_date'           => 'required|date|after:start_date',
            'fee'    => 'required|numeric|min:0',
        ]);

        $travelInsurance = TravelInsurance::create($validated);

        return response()->json($travelInsurance, 201);
    }

    // Display the specified travel insurance
    public function show(TravelInsurance $travelInsurance)
    {
        $travelInsurance->load('client', 'service');
        return response()->json($travelInsurance);
    }

    // Update the specified travel insurance
    public function update(Request $request, TravelInsurance $travelInsurance)
    {
        $validated = $request->validate([
            'insurance_provider' => 'sometimes|required|string',
            'policy_number'      => 'sometimes|required|string|unique:travel_insurances,policy_number,' . $travelInsurance->id,
            'start_date'         => 'sometimes|required|date',
            'end_date'           => 'sometimes|required|date|after:start_date',
            'fee'    => 'sometimes|required|numeric|min:0',
        ]);

        $travelInsurance->update($validated);

        return response()->json($travelInsurance, 200);
    }

    // Remove the specified travel insurance
    public function destroy(TravelInsurance $travelInsurance)
    {
        $travelInsurance->delete();

        return response()->noContent();
    }
}
