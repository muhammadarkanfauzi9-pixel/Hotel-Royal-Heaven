@extends('layouts.app')

@section('title', 'Daftar Kamar')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Daftar Kamar Hotel Royal Heaven</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($kamars ?? [] as $kamar)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <div class="bg-gray-200 h-48 flex items-center justify-center">
                    <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"></path>
                    </svg>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Kamar {{ $kamar->nomor_kamar }}</h3>
                    <p class="text-sm text-gray-600 mb-2">{{ $kamar->tipe->nama_tipe ?? '-' }}</p>
                    <p class="text-lg font-bold text-blue-600 mb-3">Rp {{ number_format($kamar->tipe->harga_dasar ?? 0, 0, ',', '.') }}/malam</p>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium 
                        @if($kamar->status_ketersediaan == 'available') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($kamar->status_ketersediaan) }}
                    </span>
                    @if($kamar->status_ketersediaan == 'available')
                        <a href="{{ route('member.pemesanan.create', ['kamar' => $kamar->id_kamar]) }}" class="block mt-3 w-full bg-blue-500 text-white text-center px-3 py-2 rounded hover:bg-blue-600">
                            Pesan Sekarang
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">Tidak ada kamar tersedia</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $kamars->links() ?? '' }}
    </div>
</div>
@endsection
