<?php

namespace App\Http\Controllers\Member; // Namespace tetap

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\TipeKamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KamarPublikController extends Controller // <<< Perubahan NAMA CLASS
{
    /**
     * Tampilkan halaman landing/utama dengan kamar unggulan (Public Route: /).
     */
    public function landing(): View
    {
        $featured_kamar = Kamar::where('status_ketersediaan', 'available')
                               ->with('tipe')
                               ->inRandomOrder()
                               ->limit(4)
                               ->get();

        return view('home', [
            'featured_kamar' => $featured_kamar
        ]);
    }

    /**
     * Tampilkan daftar semua kamar (Public Route: /daftarkamar).
     */
    public function index(Request $request): View
    {
        return view('kamar.index');
    }

    /**
     * Tampilkan detail kamar.
     */
    public function show(Kamar $kamar)
    {
        $kamar->load('tipe');

        // Load reviews with user information
        $reviews = $kamar->reviews()->with('user')->latest()->paginate(5);

        // Calculate average rating
        $averageRating = $kamar->reviews()->avg('rating') ?? 0;
        $totalReviews = $kamar->reviews()->count();

        // Check if authenticated user can review this room
        $canReview = false;
        if (Auth::check() && Auth::user()->role === 'member') {
            $userId = Auth::id();
            $canReview = \App\Models\Pemesanan::where('id_user', $userId)
                ->where('id_kamar', $kamar->id_kamar)
                ->where('status_pemesanan', 'completed')
                ->exists() &&
                !\App\Models\Review::where('id_user', $userId)
                    ->where('id_kamar', $kamar->id_kamar)
                    ->exists();
        }

        // Check if room is in user's wishlist
        $inWishlist = false;
        if (Auth::check() && Auth::user()->role === 'member') {
            $inWishlist = \App\Models\Wishlist::where('id_user', Auth::id())
                ->where('id_kamar', $kamar->id_kamar)
                ->exists();
        }

        return view('kamar.show', compact('kamar', 'reviews', 'averageRating', 'totalReviews', 'canReview', 'inWishlist'))->with('hideNavbar', true);
    }
}
