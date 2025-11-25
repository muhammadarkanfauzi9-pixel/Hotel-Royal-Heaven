<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    // List all pemesanan (admin only)
    public function index()
    {
        $pemesanan = Pemesanan::with(['user', 'kamar'])->latest('tgl_pemesanan')->paginate(15);
        return view('admin.pemesanan.index', compact('pemesanan'));
    }

    // Show pemesanan detail
    public function show(Pemesanan $pemesanan)
    {
        return view('admin.pemesanan.show', compact('pemesanan'));
    }

    // Update status (admin only)
    public function updateStatus(Request $request, Pemesanan $pemesanan)
    {
        $request->validate(['status_pemesanan' => 'required|in:pending,confirmed,cancelled,completed']);
        
        $oldStatus = $pemesanan->status_pemesanan;
        $pemesanan->status_pemesanan = $request->input('status_pemesanan');
        $pemesanan->save();
        
        // If cancelled, mark kamar as available again
        if ($request->input('status_pemesanan') == 'cancelled' && $pemesanan->kamar) {
            $pemesanan->kamar->status_ketersediaan = 'available';
            $pemesanan->kamar->save();
        }
        
        return back()->with('success', 'Status pemesanan berhasil diperbarui.');
    }
}
