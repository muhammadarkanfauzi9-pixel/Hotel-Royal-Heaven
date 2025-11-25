@extends('layouts.app')

@section('page_title', 'Daftar Kamar')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Page Header -->
            <div class="mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Daftar Kamar</h1>
                <p class="text-lg text-gray-600">Pilih kamar impian Anda di Hotel Royal Heaven</p>
            </div>

            <!-- Search & Filter Section -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-10">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Cari & Filter Kamar</h2>
                
                <form method="GET" action="{{ route('kamar.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Tipe Kamar -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Kamar</label>
                            <select name="type" id="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                <option value="">-- Semua Tipe --</option>
                                @foreach($tipeKamars as $tipe)
                                    <option value="{{ $tipe->nama_tipe }}" @selected(request('type') == $tipe->nama_tipe)>
                                        {{ $tipe->nama_tipe }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                <option value="">-- Semua Status --</option>
                                <option value="available" @selected(request('status') == 'available')>Tersedia</option>
                                <option value="booked" @selected(request('status') == 'booked')>Dipesan</option>
                                <option value="maintenance" @selected(request('status') == 'maintenance')>Pemeliharaan</option>
                            </select>
                        </div>

                        <!-- Harga Minimum -->
                        <div>
                            <label for="price_min" class="block text-sm font-medium text-gray-700 mb-2">Harga Minimum (Rp)</label>
                            <input type="number" name="price_min" id="price_min" placeholder="0" value="{{ request('price_min') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        </div>

                        <!-- Harga Maksimum -->
                        <div>
                            <label for="price_max" class="block text-sm font-medium text-gray-700 mb-2">Harga Maksimum (Rp)</label>
                            <input type="number" name="price_max" id="price_max" placeholder="0" value="{{ request('price_max') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                            Cari Kamar
                        </button>
                        <a href="{{ route('kamar.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded-lg transition-colors">
                            Reset Filter
                        </a>
                    </div>
                </form>
            </div>

            <!-- Rooms Grid -->
            @if($kamars->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach($kamars as $kamar)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                            <!-- Image Section -->
                            <div class="h-56 bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center overflow-hidden">
                                <svg class="w-20 h-20 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4V5h12v10z"/>
                                </svg>
                            </div>

                            <!-- Content Section -->
                            <div class="p-6 flex flex-col h-full">
                                <!-- Room Info -->
                                <div class="mb-6">
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <h3 class="text-2xl font-bold text-gray-900">Kamar {{ $kamar->nomor_kamar }}</h3>
                                            <p class="text-gray-600 text-sm mt-1">{{ $kamar->tipe->nama_tipe ?? 'Tipe Kamar' }}</p>
                                        </div>
                                        <!-- Status Badge -->
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                            @if($kamar->status_ketersediaan == 'available') bg-green-100 text-green-800
                                            @elseif($kamar->status_ketersediaan == 'booked') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            @if($kamar->status_ketersediaan == 'available') Tersedia
                                            @elseif($kamar->status_ketersediaan == 'booked') Dipesan
                                            @else Perbaikan @endif
                                        </span>
                                    </div>

                                    <!-- Price -->
                                    <div class="mb-3">
                                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Harga Per Malam</p>
                                        <p class="text-2xl font-bold text-yellow-600">Rp {{ number_format($kamar->tipe->harga_dasar ?? 0, 0, ',', '.') }}</p>
                                    </div>

                                    <!-- Description -->
                                    @if($kamar->deskripsi)
                                        <p class="text-gray-600 text-sm line-clamp-2">{{ $kamar->deskripsi }}</p>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-3 mt-auto">
                                    <!-- View Detail Button -->
                                    <a href="{{ route('member.kamar.show', $kamar->id_kamar) }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-900 font-semibold py-2 px-4 rounded-lg transition-colors">
                                        Detail
                                    </a>

                                    <!-- Book/Action Button -->
                                    @if(auth()->check() && !auth()->user()->isAdmin())
                                        @if($kamar->status_ketersediaan == 'available')
                                            <a href="{{ route('member.pemesanan.create') }}?kamar={{ $kamar->id_kamar }}" class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                                Pesan
                                            </a>
                                        @else
                                            <button disabled class="flex-1 text-center bg-gray-400 text-white font-semibold py-2 px-4 rounded-lg cursor-not-allowed">
                                                Tidak Tersedia
                                            </button>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                            Pesan
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-12">
                    {{ $kamars->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4V5h12v10z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada kamar ditemukan</h3>
                    <p class="text-gray-600 mb-6">Tidak ada kamar yang sesuai dengan kriteria pencarian Anda.</p>
                    <a href="{{ route('kamar.index') }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                        Lihat Semua Kamar
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
