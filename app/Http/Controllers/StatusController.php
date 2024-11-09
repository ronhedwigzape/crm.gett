<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    // Display a listing of statuses.
    public function index()
    {
        $statuses = Status::all();
        return response()->json($statuses);
    }

    // Show the form for creating a new status.
    public function create()
    {
        // Typically used for returning a view in web applications.
    }

    // Store a newly created status in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:statuses',
        ]);

        $status = Status::create($validated);

        return response()->json($status, 201);
    }

    // Display the specified status.
    public function show(Status $status)
    {
        return response()->json($status);
    }

    // Show the form for editing the specified status.
    public function edit(Status $status)
    {
        // Typically used for returning a view in web applications.
    }

    // Update the specified status in storage.
    public function update(Request $request, Status $status)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:statuses,name,' . $status->id,
        ]);

        $status->update($validated);

        return response()->json($status, 200);
    }

    // Remove the specified status from storage.
    public function destroy(Status $status)
    {
        $status->delete();

        return response()->noContent();
    }
}
