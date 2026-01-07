<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): RedirectResponse
    {
        $user = Auth::user();

        return match ($user->role) {
            'supplier' => redirect()->route('supplier.dashboard'),
            'security' => redirect()->route('security.dashboard'),
            'export_import' => redirect()->route('export_import.dashboard'),
            'warehouse' => redirect()->route('warehouse.dashboard'),
            default => redirect()->route('login'),
        };
    }
}
