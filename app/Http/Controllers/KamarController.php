<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\TipeKamar;
use Illuminate\Http\Request;
use Illuminate\View\View; // Tambahkan untuk type hinting

class KamarController extends Controller
{
    /**
     * Tampilkan daftar kamar untuk halaman manajemen (Admin).
     */
    public function index(): View
    {
        $kamar = Kamar::with('tipeKamar')->get();
        $tipeKamar = TipeKamar::all();
        
        // Asumsi view untuk admin adalah kamar.index
        return view('kamar.index', compact('kamar', 'tipeKamar'));
    }

    /**
     * Tampilkan halaman landing/utama dengan kamar unggulan (Public Route: /).
     */
    public function landing(): View
    {
        // 1. Ambil data yang ingin ditampilkan di halaman depan.
        // Contoh: Ambil 4 kamar yang tersedia.
        $featured_kamar = Kamar::where('status_ketersediaan', 'available')
                                ->with('tipeKamar') // Eager load relasi tipe kamar
                                ->limit(4) 
                                ->get();
        
        // 2. Tampilkan view halaman utama (asumsi nama view-nya 'landing' atau 'welcome')
        // Sesuaikan nama view ini dengan nama file Anda di resources/views/
        return view('home', [
            'featured_kamar' => $featured_kamar // Kirim data kamar unggulan
        ]);
        
        // Jika nama file Anda adalah resources/views/welcome.blade.php, ganti 'landing' menjadi 'welcome'.
        // Jika nama file Anda adalah resources/views/pages/landing.blade.php, ganti 'landing' menjadi 'pages.landing'.
    }

    // Tempatkan method resource lainnya (create, store, edit, update, destroy) di sini...
}