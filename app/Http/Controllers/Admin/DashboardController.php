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
        $totalMember = User::where('level', 'member')->count();
        $recentBookings = Pemesanan::with(['user', 'kamar'])->latest('tgl_pemesanan')->take(5)->get();

        return view('admin.dashboard.index', compact(
            'totalKamar',
            'kamarTersedia',
            'totalPemesanan',
            'totalMember',
            'recentBookings'
        ));
    }
}
