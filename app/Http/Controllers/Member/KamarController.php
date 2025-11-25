<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\TipeKamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    // List kamar (for members to browse)
    public function index(Request $request)
    {
        $query = Kamar::with('tipe');

        if ($request->filled('type')) {
            $query->whereHas('tipe', function($q) use ($request){
                $q->where('nama_tipe', 'like', '%'.$request->input('type').'%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status_ketersediaan', $request->input('status'));
        }

        if ($request->filled('price_min')) {
            $query->whereHas('tipe', function($q) use ($request){
                $q->where('harga_dasar', '>=', $request->input('price_min'));
            });
        }

        if ($request->filled('price_max')) {
            $query->whereHas('tipe', function($q) use ($request){
                $q->where('harga_dasar', '<=', $request->input('price_max'));
            });
        }

        $kamars = $query->paginate(12)->withQueryString();
        $kamarsAll = $query->get();
        $tipeKamars = TipeKamar::all();

        return view('member.kamar.index', compact('kamars', 'kamarsAll', 'tipeKamars'));
    }

    // Show kamar detail
    public function show(Kamar $kamar)
    {
        return view('member.kamar.show', compact('kamar'));
    }
}
