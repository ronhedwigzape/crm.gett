<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Display a listing of clients.
    public function index()
    {
        $clients = Client::all();
        return response()->json($clients);
    }

    // Show the form for creating a new client.
    public function create()
    {
        // Typically used for returning a view in web applications.
    }

    // Store a newly created client in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'      => 'required|string|max:255',
            'middle_name'     => 'nullable|string|max:255',
            'last_name'       => 'required|string|max:255',
            'email'           => 'required|email|unique:clients',
            'phone'           => 'nullable|string|max:20',
            'address'         => 'nullable|string',
            'date_of_birth'   => 'nullable|date',
            'gender'          => 'nullable|string|max:10',
            'passport_number' => 'nullable|string|max:20',
            'user_id'         => 'required|exists:users,id',
        ]);

        $client = Client::create($validated);

        return response()->json($client, 201);
    }

    // Display the specified client.
    public function show(Client $client)
    {
        return response()->json($client);
    }

    // Show the form for editing the specified client.
    public function edit(Client $client)
    {
        // Typically used for returning a view in web applications.
    }

    // Update the specified client in storage.
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'first_name'      => 'required|string|max:255',
            'middle_name'     => 'nullable|string|max:255',
            'last_name'       => 'required|string|max:255',
            'email'           => 'required|email|unique:clients,email,' . $client->id,
            'phone'           => 'nullable|string|max:20',
            'address'         => 'nullable|string',
            'date_of_birth'   => 'nullable|date',
            'gender'          => 'nullable|string|max:10',
            'passport_number' => 'nullable|string|max:20',
            'user_id'         => 'required|exists:users,id',
        ]);

        $client->update($validated);

        return response()->json($client, 200);
    }

    // Remove the specified client from storage.
    public function destroy(Client $client)
    {
        $client->delete();

        return response()->noContent();
    }
}
