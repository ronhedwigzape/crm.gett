<?php

namespace App\Http\Controllers;

use App\Models\FlightTicket;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function home()
    {
        return Inertia::render('Home');
    }

    public function dashboard()
    {
        return Inertia::render('Dashboard', [
            'transactions' => Inertia::defer(fn () => Transaction::with([
                'client',
                'service',
                'serviceDetail' => function ($morphTo) {
                    $morphTo->morphWith([
                        FlightTicket::class => ['airline'],
                    ]);
                },
                'status',
            ])->get()),
        ]);
    }

    public function clientMasterList()
    {
        return Inertia::render('ClientMasterList');
    }

    public function reports()
    {
        return Inertia::render('Reports');
    }

    public function settings()
    {
        return Inertia::render('Settings');
    }
}
