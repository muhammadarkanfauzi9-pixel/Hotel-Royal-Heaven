<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Kamar;
use App\Models\TipeKamar;

class RoomFilter extends Component
{
    use WithPagination;

    public $search = '';
    public $type = '';
    public $min_price = '';
    public $max_price = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
        'min_price' => ['except' => ''],
        'max_price' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingType()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Kamar::with('tipe')->where('status_ketersediaan', 'available');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nomor_kamar', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->type) {
            $query->where('id_tipe', $this->type);
        }

        if ($this->min_price) {
            $query->whereHas('tipe', function ($q) {
                $q->where('harga_dasar', '>=', $this->min_price);
            });
        }

        if ($this->max_price) {
            $query->whereHas('tipe', function ($q) {
                $q->where('harga_dasar', '<=', $this->max_price);
            });
        }

        $kamars = $query->paginate(9);
        $tipeKamars = TipeKamar::all();

        return view('livewire.room-filter', [
            'kamars' => $kamars,
            'tipeKamars' => $tipeKamars,
        ]);
    }
}
