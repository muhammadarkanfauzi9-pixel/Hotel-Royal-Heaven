<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Kamar;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    // Member's bookings
    public function myBookings()
    {
        $user = Auth::user();
        $pemesanan = $user->pemesanan()->with('kamar')->latest('tgl_pemesanan')->paginate(10);

        // Get IDs of rooms that the user has already reviewed
        $reviewedKamarIds = Review::where('id_user', $user->id)
            ->pluck('id_kamar')
            ->toArray();

        return view('Member.pemesanan.my', compact('pemesanan', 'reviewedKamarIds'));
    }

    // Create pemesanan form
    public function create(Request $request)
    {
        $kamars = Kamar::with('tipe')->where('status_ketersediaan', 'available')->get();
        
        // If kamar ID is in query string, pre-select it
        $selectedKamarId = $request->query('kamar');
        
        return view('member.pemesanan.create', compact('kamars', 'selectedKamarId'));
    }

    // Store pemesanan
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_kamar' => 'required|exists:kamar,id_kamar',
            'nik' => 'required|string|max:20',
            'nama' => 'required|string|max:150',
            'nohp' => 'required|string|max:15',
            'tgl_check_in' => 'required|date|after:today',
            'tgl_check_out' => 'required|date|after:tgl_check_in',
            'pilihan_pembayaran' => 'required|in:cash,transfer,kartu_kredit',
            'catatan' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $kamar = Kamar::findOrFail($data['id_kamar']);
        
        $tgl_check_in = new \DateTime($data['tgl_check_in']);
        $tgl_check_out = new \DateTime($data['tgl_check_out']);
        $total_malam = $tgl_check_out->diff($tgl_check_in)->days;
        $total_harga = $total_malam * ($kamar->tipe->harga_dasar ?? 0);

        // Update user data dengan info pemesanan
        $user->update([
            'nik' => $data['nik'],
            'nohp' => $data['nohp'],
        ]);

        $pemesanan = Pemesanan::create([
            'kode_pemesanan' => 'KD' . date('YmdHis') . rand(100, 999),
            'id_user' => $user->id,
            'id_kamar' => $kamar->id_kamar,
            'nama_pemesan' => $data['nama'],
            'nik' => $data['nik'],
            'nohp' => $data['nohp'],
            'tgl_check_in' => $data['tgl_check_in'],
            'tgl_check_out' => $data['tgl_check_out'],
            'total_malam' => $total_malam,
            'total_harga' => $total_harga,
            'pilihan_pembayaran' => $data['pilihan_pembayaran'],
            'catatan' => $data['catatan'] ?? null,
            'status_pemesanan' => 'pending',
            'tgl_pemesanan' => now(),
        ]);

        // Mark kamar as booked
        if ($kamar->status_ketersediaan == 'available') {
            $kamar->status_ketersediaan = 'booked';
            $kamar->save();
        }

        // Send booking confirmation email
        try {
            \Mail::to($user->email)->send(new \App\Mail\BookingConfirmation($pemesanan));
        } catch (\Exception $e) {
            // Log error but don't fail the booking creation
            \Log::error('Failed to send booking confirmation email: ' . $e->getMessage());
        }

        return redirect()->route('member.pemesanan.my')->with('success', 'Pemesanan berhasil dibuat. Kode pemesanan: ' . $pemesanan->kode_pemesanan);
    }

    // Show pemesanan detail
    public function show(Pemesanan $pemesanan)
    {
        $user = Auth::user();
        if ($pemesanan->id_user != $user->id) {
            abort(403);
        }
        return view('member.pemesanan.show', compact('pemesanan'));
    }

    // Cancel pemesanan
    public function cancelBooking(Pemesanan $pemesanan)
    {
        $user = Auth::user();
        if ($pemesanan->id_user != $user->id) {
            abort(403);
        }

        // Only allow cancellation if status is pending
        if ($pemesanan->status_pemesanan !== 'pending') {
            return back()->with('error', 'Pemesanan tidak dapat dibatalkan karena sudah dikonfirmasi atau selesai.');
        }

        // Update status to cancelled
        $pemesanan->status_pemesanan = 'cancelled';
        $pemesanan->save();

        // Mark kamar as available again
        if ($pemesanan->kamar) {
            $pemesanan->kamar->status_ketersediaan = 'available';
            $pemesanan->kamar->save();
        }

        return back()->with('success', 'Pemesanan berhasil dibatalkan.');
    }
}
