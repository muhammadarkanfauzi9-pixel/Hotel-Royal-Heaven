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
                                    <form method="POST" action="{{ route('pemesanan.cancel', $booking) }}" onsubmit="return confirm('Batalkan pemesanan ini?')" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit"
                                            class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors"
                                        >
                                            Batalkan
                                        </button>
                                    </form>
                                @endif
                            </div>

                            {{-- Review Section --}}
                            @if($booking->status_pemesanan == 'completed')
                            <div class="mt-6 pt-4 border-t border-gray-200">
                                @if(in_array($booking->id_kamar, $reviewedKamarIds))
                                    <div class="text-sm text-center text-gray-600 bg-gray-50 p-4 rounded-lg">
                                        <p class="font-semibold">Anda sudah memberi review untuk kamar ini.</p>
                                        <p>Terima kasih atas masukan Anda!</p>
                                    </div>
                                @else
                                    <h4 class="text-lg font-semibold text-gray-800 mb-3">Tulis Review Anda</h4>
                                    
                                    @if(session('success'))
                                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md" role="alert">
                                            <p>{{ session('success') }}</p>
                                        </div>
                                    @endif
                                    @if(session('error'))
                                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-md" role="alert">
                                            <p>{{ session('error') }}</p>
                                        </div>
                                    @endif

                                    <form action="{{ route('reviews.store') }}" method="POST" class="space-y-4">
                                        @csrf
                                        <input type="hidden" name="id_kamar" value="{{ $booking->id_kamar }}">
                                        
                                        <div>
                                            <label for="rating-{{$booking->id_pemesanan}}" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                                            <div class="flex items-center gap-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <input type="radio" id="rating-{{$booking->id_pemesanan}}-{{$i}}" name="rating" value="{{$i}}" class="form-radio h-5 w-5 text-yellow-500" required>
                                                    <label for="rating-{{$booking->id_pemesanan}}-{{$i}}">{{$i}}</label>
                                                @endfor
                                            </div>
                                            @error('rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label for="komentar-{{$booking->id_pemesanan}}" class="block text-sm font-medium text-gray-700">Komentar (Opsional)</label>
                                            <textarea 
                                                id="komentar-{{$booking->id_pemesanan}}"
                                                name="komentar" 
                                                rows="3" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm" 
                                                placeholder="Bagaimana pengalaman menginap Anda?"
                                            ></textarea>
                                            @error('komentar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                                Kirim Review
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                            @endif
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
