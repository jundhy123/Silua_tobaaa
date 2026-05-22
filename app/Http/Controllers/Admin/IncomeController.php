<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']); // assuming admin middleware exists
    }

    public function index()
    {
        // Retrieve monthly income (sum of total_price) for delivered or accepted orders
        $monthlyIncome = DB::table('orders')
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_price) as total')
            ->whereIn('status', ['delivered', 'accepted'])
            ->groupBy('year', 'month')
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();

        return view('admin.income.index', compact('monthlyIncome'));
    }
}
?>
