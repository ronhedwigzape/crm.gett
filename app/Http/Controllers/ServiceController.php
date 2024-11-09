<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Display a listing of services.
    public function index()
    {
        $services = Service::all();
        return response()->json($services);
    }

    // Show the form for creating a new service.
    public function create()
    {
        // Typically used for returning a view in web applications.
    }

    // Store a newly created service in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:services',
            'description' => 'nullable|string',
        ]);

        $service = Service::create($validated);

        return response()->json($service, 201);
    }

    // Display the specified service.
    public function show(Service $service)
    {
        return response()->json($service);
    }

    // Show the form for editing the specified service.
    public function edit(Service $service)
    {
        // Typically used for returning a view in web applications.
    }

    // Update the specified service in storage.
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:services,name,' . $service->id,
            'description' => 'nullable|string',
        ]);

        $service->update($validated);

        return response()->json($service, 200);
    }

    // Remove the specified service from storage.
    public function destroy(Service $service)
    {
        $service->delete();

        return response()->noContent();
    }
}
