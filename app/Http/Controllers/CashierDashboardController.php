<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CashierDashboardController extends Controller
{
    public function index()
    {
        return view('pages.cashier-dashboard.cashier-dashboard');
    }
}
