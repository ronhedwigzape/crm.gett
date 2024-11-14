<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Client;
use App\Models\FlightTicket;
use App\Models\Report;
use App\Models\Sale;
use App\Models\Service;
use App\Models\Status;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function home()
    {
        return Inertia::render('Home');
    }

    /**
     * Display the dashboard with key metrics and recent activities.
     */
    public function dashboard()
    {
        // Key Performance Indicators (KPIs)
        $totalSales = Sale::sum('amount');
        $transactionCount = Transaction::count();
        $newClients = Client::where('created_at', '>=', now()->subDays(30))->count();
        $topServices = Service::withSum('transactions', 'total_amount')
            ->orderByDesc('transactions_sum_total_amount')
            ->take(5)
            ->get(['id', 'name', 'transactions_sum_total_amount']);

        // Sales Overview: revenue, commissions, sales trends
        $salesOverview = Sale::select(
            DB::raw('DATE(sale_date) as date'),
            DB::raw('SUM(amount) as total_amount'),
            DB::raw('SUM(commission) as total_commission')
        )
            ->where('sale_date', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Recent Transactions
        $recentTransactions = Transaction::with([
            'client:id,first_name,last_name',
            'service:id,name',
            'status:id,name',
            'user:id,name',
        ])
            ->select('id', 'code', 'client_id', 'service_id', 'status_id', 'transaction_date', 'total_amount', 'user_id')
            ->orderBy('transaction_date', 'desc')
            ->take(10)
            ->get();

        // Upcoming Bookings: Transactions with services in the future
        $upcomingBookings = Transaction::with([
            'client:id,first_name,last_name',
            'service:id,name',
            'status:id,name',
        ])
            ->whereDate('transaction_date', '>=', now())
            ->orderBy('transaction_date')
            ->take(10)
            ->get();

        // Notifications and Alerts: For example, pending approvals
        $pendingTransactions = Transaction::with([
            'client:id,first_name,last_name',
            'service:id,name',
            'status:id,name',
        ])
            ->whereHas('status', function ($query) {
                $query->where('name', 'Pending');
            })
            ->orderBy('transaction_date')
            ->get();

        return Inertia::render('Dashboard', [
            'kpis' => [
                'total_sales' => Inertia::defer(fn() => $totalSales),
                'transaction_count' => Inertia::defer(fn() => $transactionCount),
                'new_clients' => Inertia::defer(fn() => $newClients),
                'top_services' => Inertia::defer(fn() => $topServices),
            ],
            'sales_overview' => Inertia::defer(fn() => $salesOverview),
            'recent_transactions' => Inertia::defer(fn() => $recentTransactions),
            'upcoming_bookings' => Inertia::defer(fn() => $upcomingBookings),
            'pending_transactions' => Inertia::defer(fn() =>$pendingTransactions),
        ]);
    }

    /**
     * Display the clients page with a list of clients.
     */
    public function clients(Request $request)
    {
        // Search and filter functionality
        $search = $request->input('search');
        $clients = Client::withCount('transactions')
            ->when($search, function ($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->orderBy('last_name')
            ->paginate(15);

        return Inertia::render('Clients', [
            'clients' => $clients,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    /**
     * Display the services page with service categories and management options.
     */
    public function services()
    {
        // Service Categories and Services
        $serviceCategories = Service::with('serviceDetail')
            ->get();

        return Inertia::render('Services', [
            'service_categories' => $serviceCategories,
        ]);
    }

    /**
     * Display the transactions page with a list of transactions.
     */
    public function transactions(Request $request)
    {
        // Filters
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $clientId = $request->input('client_id');
        $serviceId = $request->input('service_id');
        $statusId = $request->input('status_id');

        // Build the transactions query with filters
        $transactionsQuery = Transaction::with([
            'client',
            'service',
            'serviceDetail' => function ($morphTo) {
                $morphTo->morphWith([
                    FlightTicket::class => ['airline'],
                    /* Include other service details if needed */
                    // TourPackage::class => [],
                    // HotelBooking::class => [],
                    // TouristVisa::class => [],
                    // TransportService::class => [],
                    // TravelInsurance::class => [],
                ]);
            },
            'status',
            'user',
        ])->get();

        // Defer loading of transactions data
        $transactions = Inertia::defer(fn () => $transactionsQuery);

        // Data for filters
        $clients = Client::select('id', 'first_name', 'last_name')->orderBy('last_name')->get();
        $services = Service::select('id', 'name')->get();
        $statuses = Status::select('id', 'name')->get();

        return Inertia::render('Transactions', [
            'transactions' => $transactions,
            'filters' => [
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'client_id' => $clientId,
                'service_id' => $serviceId,
                'status_id' => $statusId,
            ],
            'clients' => $clients,
            'services' => $services,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Display the reports page with available reports and report generation options.
     */
    public function reports()
    {
        // Available reports
        $reports = Report::with('user:id,name')
            ->orderBy('generated_at', 'desc')
            ->get();

        // Data for generating new reports (e.g., date ranges, services)
        $services = Service::select('id', 'name')->get();
        $users = User::select('id', 'name')->get();

        return Inertia::render('Reports', [
            'reports' => $reports,
            'services' => $services,
            'users' => $users,
        ]);
    }

    /**
     * Display the settings page with system configurations.
     */
    public function settings()
    {
        // User Management
        $users = User::with('branch:id,name')->get();

        // Branch Management
        $branches = Branch::all();

        // Statuses
        $statuses = Status::all();

        // Services
        $services = Service::with('serviceDetail')->get();

        // System Settings: For example, currency and date formats
        $systemSettings = [
            'currency' => 'PHP',
            'date_format' => 'Y-m-d',
        ];

        return Inertia::render('Settings', [
            'users' => $users,
            'branches' => $branches,
            'statuses' => $statuses,
            'services' => $services,
            'system_settings' => $systemSettings,
        ]);
    }
}
