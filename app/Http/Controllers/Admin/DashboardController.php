<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Pemesanan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKamar = Kamar::count();
        $kamarTersedia = Kamar::where('status_ketersediaan', 'available')->count();
        $totalPemesanan = Pemesanan::count();
        $totalMember = User::where('role', 'member')->count();


        // Monthly bookings data for the last 12 months
        $monthlyBookings = [];
        $monthlyRevenue = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->format('M Y');
            $bookings = Pemesanan::whereYear('tgl_pemesanan', $date->year)
                                ->whereMonth('tgl_pemesanan', $date->month)
                                ->count();
            $revenue = Pemesanan::whereYear('tgl_pemesanan', $date->year)
                               ->whereMonth('tgl_pemesanan', $date->month)
                               ->sum('total_harga');
            $monthlyBookings[] = $bookings;
            $monthlyRevenue[] = $revenue;
        }
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $months[] = now()->subMonths($i)->format('M Y');
        }

        // Booking status distribution
        $statusCounts = Pemesanan::selectRaw('status_pemesanan, COUNT(*) as count')
                                ->groupBy('status_pemesanan')
                                ->pluck('count', 'status_pemesanan')
                                ->toArray();

        return view('admin.dashboard.index', compact(
            'totalKamar',
            'kamarTersedia',
            'totalPemesanan',
            'totalMember',
            'monthlyBookings',
            'monthlyRevenue',
            'months',
            'statusCounts'
        ));
    }
}
