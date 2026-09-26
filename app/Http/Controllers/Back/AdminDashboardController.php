<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Invoices;
use App\Models\Room;
use App\Models\Tenent;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function Dashboard(Request $request)
    {
        $selectedMonth = $request->get('month', now()->format('Y-m'));
        $anchor = Carbon::parse($selectedMonth . '-01');

        $currentMonth = $anchor->format('Y-m');
        $previousMonth = $anchor->copy()->subMonthNoOverflow()->format('Y-m');

        // ── Rooms & occupancy ─────────────────────────────────
        $rooms = Room::all();
        $totalRooms = $rooms->count();
        $rentedRooms = $rooms->where('status', 'rented')->count();
        $bookedRooms = $rooms->where('status', 'booked')->count();
        $availableRooms = $rooms->where('status', 'available')->count();
        $occupancyRate = $totalRooms > 0 ? round($rentedRooms / $totalRooms * 100, 1) : 0;

        $totalTenants = Tenent::count();

        // ── This month vs last month ──────────────────────────
        $currentInvoices = Invoices::where('month', $currentMonth)->get();
        $previousInvoices = Invoices::where('month', $previousMonth)->get();

        $monthlyRevenue = (float) $currentInvoices->sum('total_amount');
        $previousRevenue = (float) $previousInvoices->sum('total_amount');
        $revenueChange = $previousRevenue > 0
            ? round((($monthlyRevenue - $previousRevenue) / $previousRevenue) * 100, 1)
            : ($monthlyRevenue > 0 ? 100.0 : 0.0);

        $collected = (float) $currentInvoices->where('status', 'paid')->sum('total_amount');
        $outstanding = (float) $currentInvoices->where('status', 'unpaid')->sum('total_amount');
        $paidCount = $currentInvoices->where('status', 'paid')->count();
        $unpaidCount = $currentInvoices->where('status', 'unpaid')->count();

        $waterUsedTotal = (float) $currentInvoices->sum('water_used');
        $electricUsedTotal = (float) $currentInvoices->sum('electric_used');
        $waterCostTotal = (float) $currentInvoices->sum('water_used_price');
        $electricCostTotal = (float) $currentInvoices->sum('electric_used_price');

        // ── 6-month trend ─────────────────────────────────────
        $trendMonths = collect(range(5, 0))->map(fn ($i) => $anchor->copy()->subMonthsNoOverflow($i)->format('Y-m'));

        $trendLabels = $trendMonths->map(fn ($m) => Carbon::parse($m . '-01')->format('M'))->values();

        $trendRevenue = $trendMonths->map(
            fn ($m) => (float) Invoices::where('month', $m)->sum('total_amount')
        )->values();

        $trendOutstanding = $trendMonths->map(
            fn ($m) => (float) Invoices::where('month', $m)->where('status', 'unpaid')->sum('total_amount')
        )->values();

        $maxTrendRevenue = max($trendRevenue->max(), 1);

        // ── Lists ──────────────────────────────────────────────
        $recentInvoices = Invoices::with(['room', 'tenant'])
            ->orderByDesc('month')
            ->orderByDesc('id')
            ->take(6)
            ->get();

        $topOutstanding = Invoices::with(['room', 'tenant'])
            ->where('status', 'unpaid')
            ->where('month', $currentMonth)
            ->orderByDesc('total_amount')
            ->take(5)
            ->get();

        $data = [
            'pageTitle' => 'Admin | Dashboard',
            'selectedMonth' => $currentMonth,
            'currentMonthLabel' => Carbon::parse($currentMonth . '-01')->format('F Y'),

            'totalRooms' => $totalRooms,
            'rentedRooms' => $rentedRooms,
            'bookedRooms' => $bookedRooms,
            'availableRooms' => $availableRooms,
            'occupancyRate' => $occupancyRate,
            'totalTenants' => $totalTenants,

            'monthlyRevenue' => $monthlyRevenue,
            'revenueChange' => $revenueChange,
            'collected' => $collected,
            'outstanding' => $outstanding,
            'paidCount' => $paidCount,
            'unpaidCount' => $unpaidCount,

            'waterUsedTotal' => $waterUsedTotal,
            'electricUsedTotal' => $electricUsedTotal,
            'waterCostTotal' => $waterCostTotal,
            'electricCostTotal' => $electricCostTotal,

            'trendLabels' => $trendLabels,
            'trendRevenue' => $trendRevenue,
            'trendOutstanding' => $trendOutstanding,
            'maxTrendRevenue' => $maxTrendRevenue,

            'recentInvoices' => $recentInvoices,
            'topOutstanding' => $topOutstanding,
        ];

        return view('backend.pages.dashboard.index', $data);
    }
}
