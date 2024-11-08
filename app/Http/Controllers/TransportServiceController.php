<?php

namespace App\Http\Controllers;

use App\Models\TransportService;
use Illuminate\Http\Request;

class TransportServiceController extends Controller
{
    // Display a listing of transport services
    public function index()
    {
        $transportServices = TransportService::with('client', 'service')->get();
        return response()->json($transportServices);
    }

    // Store a newly created transport service
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id'       => 'required|exists:services,id',
            'client_id'        => 'required|exists:clients,id',
            'transport_type'   => 'required|string',
            'pickup_location'  => 'required|string',
            'dropoff_location' => 'required|string',
            'pickup_datetime'  => 'required|date',
            'fare_amount'      => 'required|numeric|min:0',
        ]);

        $transportService = TransportService::create($validated);

        return response()->json($transportService, 201);
    }

    // Display the specified transport service
    public function show(TransportService $transportService)
    {
        $transportService->load('client', 'service');
        return response()->json($transportService);
    }

    // Update the specified transport service
    public function update(Request $request, TransportService $transportService)
    {
        $validated = $request->validate([
            'transport_type'   => 'sometimes|required|string',
            'pickup_location'  => 'sometimes|required|string',
            'dropoff_location' => 'sometimes|required|string',
            'pickup_datetime'  => 'sometimes|required|date',
            'fare_amount'      => 'sometimes|required|numeric|min:0',
        ]);

        $transportService->update($validated);

        return response()->json($transportService, 200);
    }

    // Remove the specified transport service
    public function destroy(TransportService $transportService)
    {
        $transportService->delete();

        return response()->noContent();
    }
}
