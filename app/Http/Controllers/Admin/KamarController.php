<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\TipeKamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    // List kamar (admin)
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

        $kamars = $query->paginate(15);
        $tipeKamars = TipeKamar::all();

        return view('admin.kamar.index', compact('kamars', 'tipeKamars'));
    }

    // Create form (admin only)
    public function create()
    {
        $tipe = TipeKamar::all();
        return view('admin.kamar.create', compact('tipe'));
    }

    // Store kamar (admin only)
    public function store(Request $request)
    {
        $data = $request->validate([
            'nomor_kamar' => 'required|string|unique:kamar,nomor_kamar',
            'id_tipe' => 'required|exists:tipe_kamar,id_tipe',
            'deskripsi' => 'nullable|string|max:500',
            'status_ketersediaan' => 'required|in:available,booked,maintenance',
        ]);

        Kamar::create($data);
        return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    // Edit form (admin only)
    public function edit(Kamar $kamar)
    {
        $tipe = TipeKamar::all();
        return view('admin.kamar.edit', compact('kamar', 'tipe'));
    }

    // Update kamar (admin only)
    public function update(Request $request, Kamar $kamar)
    {
        $data = $request->validate([
            'nomor_kamar' => 'required|string|unique:kamar,nomor_kamar,'.$kamar->id_kamar.',id_kamar',
            'id_tipe' => 'required|exists:tipe_kamar,id_tipe',
            'deskripsi' => 'nullable|string|max:500',
            'status_ketersediaan' => 'required|in:available,booked,maintenance',
        ]);

        $kamar->update($data);
        return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil diperbarui.');
    }

    // Delete kamar (admin only)
    public function destroy(Kamar $kamar)
    {
        $kamar->delete();
        return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil dihapus.');
    }
}
