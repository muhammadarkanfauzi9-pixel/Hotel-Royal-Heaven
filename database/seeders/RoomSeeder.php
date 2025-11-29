<?php

namespace Database\Seeders;

use App\Models\Kamar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Room 1 - Standard Room
        Kamar::create([
            'nomor_kamar' => '101',
            'id_tipe' => 1,
            'deskripsi' => 'Comfortable standard room with basic amenities.',
            'status_ketersediaan' => 'available',
            'foto_kamar' => 'kamar/cXRDBFTq8BEREGdh9p4ytFO1ObYXflZP1ck6Gbcp.jpg',
            'foto_detail' => json_encode([
                'kamar/detail/6WjNVWfloBm30w5x10jS9ZQdtv1WqbKzx8yGpLUr.jpg',
                'kamar/detail/Q07dr8Cs76CLkmLDz5hdwZic1THRrQVXBHiWag6d.jpg'
            ]),
        ]);

        // Room 2 - Deluxe Room
        Kamar::create([
            'nomor_kamar' => '102',
            'id_tipe' => 2,
            'deskripsi' => 'Spacious deluxe room with premium amenities.',
            'status_ketersediaan' => 'available',
            'foto_kamar' => 'kamar/n6WnauwZfiHDbr8LnuQcpW9kER4IYeDwIsubWSi8.jpg',
            'foto_detail' => json_encode([
                'kamar/detail/QQAIBbktIhc66BmuzxYIvzOwtl1q1mWcGHlnOv4x.jpg'
            ]),
        ]);

        // Room 3 - Suite Room
        Kamar::create([
            'nomor_kamar' => '201',
            'id_tipe' => 3,
            'deskripsi' => 'Luxurious suite with separate living area.',
            'status_ketersediaan' => 'available',
            'foto_kamar' => 'kamar/o8z4ekOjc6shVIVCLWePIhwWKg3XiQyJPmAu0rje.jpg',
            'foto_detail' => json_encode([
                'kamar/detail/veV8oCQpGeYPxK6JUqGF26IyhH9FyaBPZllNl6D2.jpg'
            ]),
        ]);

        // Room 4 - Standard Room
        Kamar::create([
            'nomor_kamar' => '202',
            'id_tipe' => 1,
            'deskripsi' => 'Cozy standard room perfect for short stays.',
            'status_ketersediaan' => 'available',
            'foto_kamar' => 'kamar/u03OMb99kZfEJ0h8HTWIVusaiHFfsfmR9JpEj3Zk.jpg',
            'foto_detail' => null,
        ]);
    }
}
