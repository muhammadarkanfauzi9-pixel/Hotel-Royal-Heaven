<?php

namespace Database\Seeders;

use App\Models\TipeKamar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipeKamarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipeKamar::create([
            'nama_tipe' => 'Standard Room',
            'harga_dasar' => 500000,
            'max_tamu' => 2,
        ]);

        TipeKamar::create([
            'nama_tipe' => 'Deluxe Room',
            'harga_dasar' => 750000,
            'max_tamu' => 2,
        ]);

        TipeKamar::create([
            'nama_tipe' => 'Suite Room',
            'harga_dasar' => 1000000,
            'max_tamu' => 4,
        ]);
    }
}
