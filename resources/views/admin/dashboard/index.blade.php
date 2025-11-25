@extends('layouts.admin')

@section('page_title', 'Dashboard')
@section('page_subtitle', 'Selamat datang di dashboard admin hotel Royal Heaven')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card: Total Kamar -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 14V6a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H6a2 2 0 01-2-2zM6 8h8v6H6V8z"></path></svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Kamar</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $totalKamar ?? 0 }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Card: Kamar Tersedia -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Kamar Tersedia</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $kamarTersedia ?? 0 }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Card: Total Pemesanan -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2h16V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h12a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Pemesanan</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $totalPemesanan ?? 0 }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Card: Total Member -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 12a6 6 0 11-12 0 6 6 0 0112 0z"></path></svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Member</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $totalMember ?? 0 }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold mb-4">Pemesanan Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Pemesanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Pemesan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kamar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings ?? [] as $booking)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm">{{ $booking->kode_pemesanan }}</td>
                            <td class="px-6 py-4 text-sm">{{ $booking->nama_pemesan }}</td>
                            <td class="px-6 py-4 text-sm">{{ $booking->kamar->nomor_kamar ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-medium 
                                    @if($booking->status_pemesanan == 'confirmed') bg-green-100 text-green-800
                                    @elseif($booking->status_pemesanan == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($booking->status_pemesanan == 'cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($booking->status_pemesanan) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada pemesanan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
