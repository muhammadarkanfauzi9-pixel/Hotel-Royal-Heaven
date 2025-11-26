@extends('layouts.app')

@section('page_title', 'Daftar Kamar')
@include('components.hero-section')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-semibold mb-6">Daftar Kamar</h1>

    @if($kamar->isEmpty())
        <p>Tidak ada kamar tersedia saat ini.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($kamar as $room)
            <div class="border rounded-lg overflow-hidden shadow-lg">
                <img src="{{ asset('storage/' . $room->gambar) }}" alt="{{ $room->nama_kamar }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-semibold">{{ $room->nama_kamar }}</h2>
                    <p class="mt-2 text-gray-600">{{ $room->deskripsi }}</p>
                    <p class="mt-2 font-bold">Harga: Rp {{ number_format($room->harga, 0, ',', '.') }}</p>
                    <a href="{{ route('pemesanan.create') }}" class="mt-4 inline-block px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">Pesan Sekarang</a>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
