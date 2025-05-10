<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $dashboardService) {}

    public function index()
    {
        $user = Auth::user();
        $filters = $this->dashboardService->getDashboardData($user);

        return Inertia::render('dashboard', [
            'user' => $user->toArray(),
            'filters' => $filters,
        ]);
    }
}
