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
        $newStatus = $request->input('status_pemesanan');

        $pemesanan->status_pemesanan = $newStatus;
        $pemesanan->save();

        // If cancelled, mark kamar as available again
        if ($newStatus == 'cancelled' && $pemesanan->kamar) {
            $pemesanan->kamar->status_ketersediaan = 'available';
            $pemesanan->kamar->save();
        }

        // Send email notification to member
        try {
            \Mail::to($pemesanan->user->email)->send(new \App\Mail\BookingStatusUpdate($pemesanan, $oldStatus, $newStatus));
        } catch (\Exception $e) {
            // Log error but don't fail the status update
            \Log::error('Failed to send booking status update email: ' . $e->getMessage());
        }

        return back()->with('success', 'Status pemesanan berhasil diperbarui.');
    }
}
