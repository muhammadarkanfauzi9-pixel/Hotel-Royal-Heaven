@extends('layouts.app')

@section('page_title', 'Riwayat Pemesanan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Order History</h1>
        <p class="text-gray-600">Manage and view all your hotel room booking history.</p>
    </div>

    <!-- Search Bar -->
    <div class="mb-8">
        <div class="relative">
            <input type="text" placeholder="Search by booking code or room name..." class="w-full bg-gray-100 border-none rounded-lg py-3 px-4 pl-12 text-gray-700 focus:ring-2 focus:ring-yellow-500">
            <div class="absolute left-4 top-3.5 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="flex space-x-1 bg-gray-100 p-1 rounded-xl mb-8 overflow-x-auto">
        <button class="flex-1 py-2.5 px-4 rounded-lg bg-yellow-500 text-white font-medium text-sm shadow-sm transition">All Order History</button>
        <button class="flex-1 py-2.5 px-4 rounded-lg text-gray-600 hover:bg-white hover:shadow-sm font-medium text-sm transition">Will come</button>
        <button class="flex-1 py-2.5 px-4 rounded-lg text-gray-600 hover:bg-white hover:shadow-sm font-medium text-sm transition">Finished</button>
        <button class="flex-1 py-2.5 px-4 rounded-lg text-gray-600 hover:bg-white hover:shadow-sm font-medium text-sm transition">Canceled</button>
    </div>

    <!-- Booking List -->
    <div class="space-y-6">
        @forelse($pemesanan as $booking)
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Room Image (Placeholder if none) -->
                <div class="w-full md:w-48 h-32 bg-gray-200 rounded-xl overflow-hidden flex-shrink-0">
                    @if($booking->kamar->foto_kamar)
                        <img src="{{ asset('storage/' . $booking->kamar->foto_kamar) }}" alt="Room" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </div>

                <!-- Details -->
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $booking->nama_pemesan }}</h3>
                            <p class="text-gray-500 text-sm">Kamar {{ $booking->kamar->nomor_kamar }} • {{ $booking->kamar->tipe->nama_tipe }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold 
                            @if($booking->status_pemesanan == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($booking->status_pemesanan == 'confirmed') bg-green-100 text-green-800
                            @elseif($booking->status_pemesanan == 'cancelled') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($booking->status_pemesanan) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div class="flex items-center text-gray-600 text-sm">
                            <svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Check-in: {{ \Carbon\Carbon::parse($booking->tgl_check_in)->format('d M Y') }}
                        </div>
                        <div class="flex items-center text-gray-600 text-sm">
                            <svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Check-out: {{ \Carbon\Carbon::parse($booking->tgl_check_out)->format('d M Y') }}
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="bg-yellow-50 px-4 py-2 rounded-lg w-full md:w-auto">
                            <span class="text-xs text-gray-500 block">Total Payment</span>
                            <span class="text-lg font-bold text-yellow-700">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex gap-3 w-full md:w-auto">
                            @if($booking->status_pemesanan == 'pending')
                                <form action="{{ route('member.pemesanan.cancel', $booking->id_pemesanan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full md:w-auto px-6 py-2.5 border border-red-200 text-red-600 font-medium rounded-lg hover:bg-red-50 transition">
                                        Cancel
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('member.pemesanan.show', $booking->id_pemesanan) }}" class="w-full md:w-auto px-6 py-2.5 bg-yellow-500 text-white font-medium rounded-lg hover:bg-yellow-600 transition text-center shadow-md shadow-yellow-200">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12 bg-white rounded-2xl border border-gray-200">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900">No bookings found</h3>
            <p class="text-gray-500 mt-1">You haven't made any room bookings yet.</p>
            <a href="{{ route('daftarkamar') }}" class="inline-block mt-4 px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                Book a Room
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $pemesanan->links() }}
    </div>
</div>
@endsection
