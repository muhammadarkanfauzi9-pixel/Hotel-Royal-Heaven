@extends(auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.app')

@section('page_title', 'Detail Pemesanan')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Detail Pemesanan</h1>
                    <p class="text-gray-600 mt-1">Kode: <span class="font-mono font-semibold">{{ $pemesanan->kode_pemesanan }}</span></p>
                </div>
                
                @php
                    $statusClass = 'bg-gray-100 text-gray-800';
                    if (strpos(strtolower($pemesanan->status_pemesanan), 'pending') !== false) {
                        $statusClass = 'bg-yellow-100 text-yellow-800';
                    } elseif (strpos(strtolower($pemesanan->status_pemesanan), 'confirmed') !== false) {
                        $statusClass = 'bg-green-100 text-green-800';
                    } elseif (strpos(strtolower($pemesanan->status_pemesanan), 'completed') !== false) {
                        $statusClass = 'bg-blue-100 text-blue-800';
                    } elseif (strpos(strtolower($pemesanan->status_pemesanan), 'cancelled') !== false) {
                        $statusClass = 'bg-red-100 text-red-800';
                    }
                @endphp
                <span class="px-4 py-2 text-lg font-semibold rounded-full {{ $statusClass }}">
                    {{ ucfirst($pemesanan->status_pemesanan) }}
                </span>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Tanggal Pemesanan</p>
                    <p class="font-semibold text-gray-800">
                        {{ $pemesanan->tgl_pemesanan ? \Carbon\Carbon::parse($pemesanan->tgl_pemesanan)->format('d M Y H:i') : '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Check-in</p>
                    <p class="font-semibold text-gray-800">
                        {{ $pemesanan->tgl_check_in ? \Carbon\Carbon::parse($pemesanan->tgl_check_in)->format('d M Y') : '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Check-out</p>
                    <p class="font-semibold text-gray-800">
                        {{ $pemesanan->tgl_check_out ? \Carbon\Carbon::parse($pemesanan->tgl_check_out)->format('d M Y') : '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Total Malam</p>
                    <p class="font-semibold text-gray-800">{{ $pemesanan->total_malam }} malam</p>
                </div>
            </div>
        </div>

        <!-- Kamar Information -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Kamar</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Nomor Kamar</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $pemesanan->kamar->nomor_kamar ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Tipe Kamar</p>
                    <p class="text-xl font-semibold text-gray-800">{{ $pemesanan->kamar->tipe->nama_tipe ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Harga Per Malam</p>
                    <p class="text-xl font-semibold text-yellow-600">
                        Rp {{ number_format($pemesanan->kamar->tipe->harga_dasar ?? 0, 0, ',', '.') }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Status Kamar</p>
                    @php
                        $kamarStatusClass = 'bg-red-100 text-red-800';
                        if ($pemesanan->kamar->status_ketersediaan == 'available') {
                            $kamarStatusClass = 'bg-green-100 text-green-800';
                        } elseif ($pemesanan->kamar->status_ketersediaan == 'maintenance') {
                            $kamarStatusClass = 'bg-yellow-100 text-yellow-800';
                        }
                    @endphp
                    <span class="px-3 py-1 inline-block text-sm font-semibold rounded-full {{ $kamarStatusClass }}">
                        @if($pemesanan->kamar->status_ketersediaan == 'available')
                            Tersedia
                        @elseif($pemesanan->kamar->status_ketersediaan == 'booked')
                            Dipesan
                        @elseif($pemesanan->kamar->status_ketersediaan == 'maintenance')
                            Pemeliharaan
                        @else
                            {{ ucfirst($pemesanan->kamar->status_ketersediaan) }}
                        @endif
                    </span>
                </div>
            </div>

            @if($pemesanan->kamar->deskripsi)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Deskripsi Kamar</p>
                    <p class="text-gray-700">{{ $pemesanan->kamar->deskripsi }}</p>
                </div>
            @endif
        </div>

        <!-- Guest Information -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Tamu</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Nama Pemesan</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $pemesanan->nama_pemesan ?? $pemesanan->user->nama_lengkap ?? $pemesanan->user->username }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">NIK</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $pemesanan->nik ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Nomor Telepon</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $pemesanan->nohp ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Email</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $pemesanan->user->email ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Booking Details -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Pemesanan</h2>
            
            <div class="space-y-4">
                <div class="flex justify-between py-3 border-b border-gray-200">
                    <span class="text-gray-700">Harga Per Malam</span>
                    <span class="font-semibold">Rp {{ number_format($pemesanan->kamar->tipe->harga_dasar ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-3 border-b border-gray-200">
                    <span class="text-gray-700">Jumlah Malam</span>
                    <span class="font-semibold">{{ $pemesanan->total_malam }} malam</span>
                </div>
                <div class="flex justify-between py-3 bg-yellow-50 px-4 rounded-lg">
                    <span class="text-lg font-semibold text-gray-800">Total Harga</span>
                    <span class="text-2xl font-bold text-yellow-600">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Metode Pembayaran</p>
                <p class="text-lg font-semibold text-gray-800">
                    @if($pemesanan->pilihan_pembayaran == 'cash')
                        Tunai
                    @elseif($pemesanan->pilihan_pembayaran == 'transfer')
                        Transfer Bank
                    @elseif($pemesanan->pilihan_pembayaran == 'kartu_kredit')
                        Kartu Kredit
                    @else
                        {{ $pemesanan->pilihan_pembayaran }}
                    @endif
                </p>
            </div>

            @if($pemesanan->catatan)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Catatan Khusus</p>
                    <p class="text-gray-700">{{ $pemesanan->catatan }}</p>
                </div>
            @endif
        </div>

        <!-- Admin Actions -->
        @if(auth()->user()->isAdmin() && $pemesanan->status_pemesanan != 'cancelled' && $pemesanan->status_pemesanan != 'completed')
            <div class="bg-white rounded-lg shadow-md p-8 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Kelola Pemesanan</h2>
                
                <form method="POST" action="{{ route('member.pemesanan.updateStatus', $pemesanan) }}" class="flex gap-3">
                    @csrf
                    
                    <select 
                        name="status_pemesanan" 
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                    >
                        <option value="pending" @selected($pemesanan->status_pemesanan == 'pending')>Pending</option>
                        <option value="confirmed" @selected($pemesanan->status_pemesanan == 'confirmed')>Confirmed</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="completed" @selected($pemesanan->status_pemesanan == 'completed')>Completed</option>
                    </select>
                    
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        @endif

        <!-- Back Button -->
        <div class="flex gap-3">
            @if(auth()->user()->isAdmin())
                <a href="{{ route('member.pemesanan.my') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-4 rounded-lg transition-colors text-center">
                    Kembali ke Daftar Pemesanan
                </a>
            @else
                <a href="{{ route('member.pemesanan.my') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-4 rounded-lg transition-colors text-center">
                    Kembali ke Pemesanan Saya
                </a>
            @endif
        </div>
    </div>
@endsection
