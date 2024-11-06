<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Display a listing of transactions.
    public function index()
    {
        $transactions = Transaction::all();
        return response()->json($transactions);
    }

    // Show the form for creating a new transaction.
    public function create()
    {
        // Typically used for returning a view in web applications.
    }

    // Store a newly created transaction in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'             => 'required|unique:transactions,code',
            'client_id'        => 'required|exists:clients,id',
            'service_id'       => 'required|exists:services,id',
            'status_id'        => 'required|exists:statuses,id',
            'transaction_date' => 'required|date',
        ]);

        $transaction = Transaction::create($validated);

        return response()->json($transaction, 201);
    }

    // Display the specified transaction.
    public function show(Transaction $transaction)
    {
        return response()->json($transaction);
    }

    // Show the form for editing the specified transaction.
    public function edit(Transaction $transaction)
    {
        // Typically used for returning a view in web applications.
    }

    // Update the specified transaction in storage.
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'code'             => 'required|unique:transactions,code',
            'client_id'        => 'required|exists:clients,id',
            'service_id'       => 'required|exists:services,id',
            'status_id'        => 'required|exists:statuses,id',
            'transaction_date' => 'required|date',
        ]);

        $transaction->update($validated);

        return response()->json($transaction, 200);
    }

    // Remove the specified transaction from storage.
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return response()->noContent();
    }
}
