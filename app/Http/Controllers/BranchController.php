<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    // Display a listing of branches.
    public function index()
    {
        $branches = Branch::all();
        return response()->json($branches);
    }

    // Show the form for creating a new branch.
    public function create()
    {
        // Typically used for returning a view in web applications.
    }

    // Store a newly created branch in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $branch = Branch::create($validated);

        return response()->json($branch, 201);
    }

    // Display the specified branch.
    public function show(Branch $branch)
    {
        return response()->json($branch);
    }

    // Show the form for editing the specified branch.
    public function edit(Branch $branch)
    {
        // Typically used for returning a view in web applications.
    }

    // Update the specified branch in storage.
    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $branch->update($validated);

        return response()->json($branch, 200);
    }

    // Remove the specified branch from storage.
    public function destroy(Branch $branch)
    {
        $branch->delete();

        return response()->noContent();
    }
}
