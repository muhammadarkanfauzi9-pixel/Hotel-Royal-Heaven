@extends('layouts.app')

@section('page_title', 'Pemesanan Saya')

@section('content')
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Pemesanan Saya</h1>
                <p class="text-gray-600 mt-1">Kelola semua pemesanan kamar Anda</p>
            </div>
            <a href="{{ route('member.pemesanan.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                Pesan Kamar
            </a>
        </div>

        @if($pemesanan->count() > 0)
            <div class="space-y-4">
                @foreach($pemesanan as $booking)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">
                                        Kamar {{ $booking->kamar->nomor_kamar ?? '-' }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        Kode Pemesanan: <span class="font-mono font-semibold">{{ $booking->kode_pemesanan }}</span>
                                    </p>
                                </div>
                                
                                @php
                                    $statusClass = 'bg-gray-100 text-gray-800';
                                    if (strpos(strtolower($booking->status_pemesanan), 'pending') !== false) {
                                        $statusClass = 'bg-yellow-100 text-yellow-800';
                                    } elseif (strpos(strtolower($booking->status_pemesanan), 'confirmed') !== false) {
                                        $statusClass = 'bg-green-100 text-green-800';
                                    } elseif (strpos(strtolower($booking->status_pemesanan), 'completed') !== false) {
                                        $statusClass = 'bg-blue-100 text-blue-800';
                                    } elseif (strpos(strtolower($booking->status_pemesanan), 'cancelled') !== false) {
                                        $statusClass = 'bg-red-100 text-red-800';
                                    }
                                @endphp
                                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($booking->status_pemesanan) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4 pb-4 border-b border-gray-200">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Check-in</p>
                                    <p class="font-semibold text-gray-800">
                                        {{ $booking->tgl_check_in ? \Carbon\Carbon::parse($booking->tgl_check_in)->format('d M Y') : '-' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Check-out</p>
                                    <p class="font-semibold text-gray-800">
                                        {{ $booking->tgl_check_out ? \Carbon\Carbon::parse($booking->tgl_check_out)->format('d M Y') : '-' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Total Malam</p>
                                    <p class="font-semibold text-gray-800">{{ $booking->total_malam }} malam</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Total Harga</p>
                                    <p class="font-semibold text-yellow-600">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 pb-4 border-b border-gray-200">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Tipe Kamar</p>
                                    <p class="font-semibold text-gray-800">{{ $booking->kamar->tipe->nama_tipe ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Metode Pembayaran</p>
                                    <p class="font-semibold text-gray-800">
                                        @if($booking->pilihan_pembayaran == 'cash')
                                            Tunai
                                        @elseif($booking->pilihan_pembayaran == 'transfer')
                                            Transfer Bank
                                        @elseif($booking->pilihan_pembayaran == 'kartu_kredit')
                                            Kartu Kredit
                                        @else
                                            {{ $booking->pilihan_pembayaran }}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            @if($booking->catatan)
                                <div class="mb-4 pb-4 border-b border-gray-200">
                                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Catatan</p>
                                    <p class="text-gray-700">{{ $booking->catatan }}</p>
                                </div>
                            @endif

                            <div class="flex gap-2">
                                <a href="{{ route('member.pemesanan.show', $booking) }}" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors text-center">
                                    Lihat Detail
                                </a>
                                @if($booking->status_pemesanan == 'pending')
                                    <button 
                                        type="button" 
                                        onclick="if(confirm('Batalkan pemesanan ini?')) cancelBooking({{ $booking->id_pemesanan }})"
                                        class="flex-1 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors"
                                    >
                                        Batalkan
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $pemesanan->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-8a1 1 0 112 0v3a1 1 0 11-2 0v-3z" clip-rule="evenodd"></path></svg>
                <p class="text-gray-500 text-lg mb-6">Anda belum memiliki pemesanan</p>
                <a href="{{ route('member.pemesanan.create') }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                    Pesan Kamar Sekarang
                </a>
            </div>
        @endif
    </div>

    <script>
        function cancelBooking(id) {
            // For now, we'll just show a message
            // In a real app, you'd submit a form to cancel the booking
            alert('Fitur pembatalan akan diimplementasikan');
        }
    </script>
@endsection
