<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Display a listing of users.
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    // Show the form for creating a new user.
    public function create()
    {
        // Typically used for returning a view in web applications.
    }

    // Store a newly created user in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username'      => 'required|string|max:255|unique:users',
            'password_hash' => 'required|string|min:6',
            'branch_id'     => 'required|exists:branches,id',
        ]);

        $user = User::create([
            'username'      => $validated['username'],
            'password_hash' => Hash::make($validated['password_hash']),
            'branch_id'     => $validated['branch_id'],
        ]);

        return response()->json($user, 201);
    }

    // Display the specified user.
    public function show(User $user)
    {
        return response()->json($user);
    }

    // Show the form for editing the specified user.
    public function edit(User $user)
    {
        // Typically used for returning a view in web applications.
    }

    // Update the specified user in storage.
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username'      => 'required|string|max:255|unique:users,username,' . $user->id,
            'password_hash' => 'nullable|string|min:6',
            'branch_id'     => 'required|exists:branches,id',
        ]);

        $user->username = $validated['username'];
        $user->branch_id = $validated['branch_id'];

        if (!empty($validated['password_hash'])) {
            $user->password_hash = Hash::make($validated['password_hash']);
        }

        $user->save();

        return response()->json($user, 200);
    }

    // Remove the specified user from storage.
    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}
