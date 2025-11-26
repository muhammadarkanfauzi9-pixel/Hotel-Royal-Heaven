<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Pemesanan;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kamar' => 'required|exists:kamar,id_kamar',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        $id_kamar = $request->input('id_kamar');
        $id_user = Auth::id();

        // Cek apakah user pernah menyelesaikan pemesanan untuk kamar ini
        $canReview = Pemesanan::where('id_user', $id_user)
            ->where('id_kamar', $id_kamar)
            ->where('status_pemesanan', 'completed')
            ->exists();

        if (!$canReview) {
            return redirect()->back()->with('error', 'Anda hanya dapat mereview kamar yang pemesanannya telah selesai.');
        }

        // Cek apakah user sudah pernah mereview kamar ini
        $alreadyReviewed = Review::where('id_user', $id_user)
            ->where('id_kamar', $id_kamar)
            ->exists();

        if ($alreadyReviewed) {
             return redirect()->back()->with('error', 'Anda sudah pernah memberikan review untuk kamar ini.');
        }

        Review::create([
            'id_user' => $id_user,
            'id_kamar' => $id_kamar,
            'rating' => $request->input('rating'),
            'komentar' => $request->input('komentar'),
        ]);

        return redirect()->back()->with('success', 'Terima kasih atas review Anda!');
    }
}
