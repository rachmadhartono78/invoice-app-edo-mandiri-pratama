<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = \Carbon\Carbon::now();
        $lastMonth = \Carbon\Carbon::now()->subMonth();

        // Optimized Aggregation Query
        $stats = Invoice::selectRaw("
            SUM(total_amount) as total_revenue,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count,
            SUM(CASE WHEN status = 'pending' THEN total_amount ELSE 0 END) as pending_amount,
            SUM(CASE WHEN YEAR(invoice_date) = ? AND MONTH(invoice_date) = ? THEN total_amount ELSE 0 END) as current_month_revenue,
            SUM(CASE WHEN YEAR(invoice_date) = ? AND MONTH(invoice_date) = ? THEN total_amount ELSE 0 END) as last_month_revenue
        ", [$currentMonth->year, $currentMonth->month, $lastMonth->year, $lastMonth->month])->first();

        $totalRevenue = $stats->total_revenue ?? 0;
        $pendingInvoicesCount = $stats->pending_count ?? 0;
        $pendingInvoicesAmount = $stats->pending_amount ?? 0;

        $currentMonthRevenue = $stats->current_month_revenue ?? 0;
        $lastMonthRevenue = $stats->last_month_revenue ?? 0;

        // Percentage Change Calculation
        if ($lastMonthRevenue > 0) {
            $revenueGrowth = (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
        }
        else {
            $revenueGrowth = $currentMonthRevenue > 0 ? 100 : 0;
        }

        $totalClients = \App\Models\Client::count();


        $totalClients = \App\Models\Client::count();

        $recentInvoices = Invoice::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalRevenue',
            'revenueGrowth',
            'pendingInvoicesCount',
            'pendingInvoicesAmount',
            'totalClients',
            'recentInvoices'
        ));
    }
}
