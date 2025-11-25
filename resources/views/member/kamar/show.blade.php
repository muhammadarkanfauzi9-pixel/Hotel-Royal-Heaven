@extends('layouts.app')

@section('page_title', 'Detail Kamar')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-4xl mx-auto px-4">
            <a href="{{ route('kamar.index') }}" class="text-blue-500 hover:underline mb-6 inline-block">← Kembali</a>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                    <!-- Image Section -->
                    <div>
                        <div class="bg-gray-300 rounded-lg h-64 md:h-80 flex items-center justify-center">
                            <svg class="w-24 h-24 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Details Section -->
                    <div>
                        <div class="space-y-4">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">Kamar {{ $kamar->nomor_kamar }}</h1>
                                <p class="text-gray-600 mt-2">{{ $kamar->tipe->nama_tipe ?? 'Tipe Kamar' }}</p>
                            </div>

                            <div>
                                <span class="px-4 py-2 rounded-full text-sm font-medium 
                                    @if($kamar->status_ketersediaan == 'available') bg-green-100 text-green-800
                                    @elseif($kamar->status_ketersediaan == 'booked') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    @if($kamar->status_ketersediaan == 'available') Tersedia
                                    @elseif($kamar->status_ketersediaan == 'booked') Dipesan
                                    @else Perbaikan @endif
                                </span>
                            </div>

                            <div class="border-t pt-4">
                                <p class="text-gray-600 mb-2">Harga per malam</p>
                                <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($kamar->tipe->harga_dasar ?? 0, 0, ',', '.') }}</p>
                            </div>

                            <div class="border-t pt-4">
                                <h3 class="font-semibold text-gray-900 mb-2">Deskripsi</h3>
                                <p class="text-gray-600">{{ $kamar->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                            </div>

                            <div class="border-t pt-4">
                                <h3 class="font-semibold text-gray-900 mb-2">Fasilitas</h3>
                                <p class="text-gray-600">{{ $kamar->tipe->fasilitas ?? 'Lihat detail tipe kamar untuk informasi fasilitas' }}</p>
                            </div>

                            @if($kamar->status_ketersediaan == 'available')
                                <div class="pt-6">
                                    <a href="{{ route('member.pemesanan.create') }}?kamar={{ $kamar->id_kamar }}" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-4 rounded-lg transition-colors text-center block">
                                        Pesan Kamar
                                    </a>
                                </div>
                            @else
                                <div class="pt-6">
                                    <button disabled class="w-full bg-gray-400 text-white font-bold py-3 px-4 rounded-lg cursor-not-allowed">
                                        Tidak Tersedia
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Info Section -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Tipe Kamar</h3>
                    <p class="text-gray-600">{{ $kamar->tipe->nama_tipe ?? '-' }}</p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Status</h3>
                    <p class="text-gray-600">
                        @if($kamar->status_ketersediaan == 'available') Tersedia untuk dipesan
                        @elseif($kamar->status_ketersediaan == 'booked') Sedang dipesan
                        @else Sedang dalam perbaikan @endif
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Nomor Kamar</h3>
                    <p class="text-gray-600">{{ $kamar->nomor_kamar }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
