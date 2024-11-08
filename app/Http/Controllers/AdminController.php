<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('Dashboard', [
            'transactions' => Inertia::defer(fn () => Transaction::with(['client', 'service.serviceDetail', 'status'])->get()),
        ]);
    }

    public function clients()
    {
        return Inertia::render('Clients');
    }
}
