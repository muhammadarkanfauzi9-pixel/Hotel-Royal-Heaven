@extends('layouts.admin')

@section('page_title', 'Manajemen Pemesanan')
@section('page_subtitle', 'Kelola semua pemesanan kamar')

@section('content')
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Daftar Pemesanan</h2>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Pemesanan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Pemesan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kamar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pemesanan ?? [] as $p)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $p->kode_pemesanan }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $p->nama_pemesan }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $p->kamar->nomor_kamar ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $p->tgl_check_in }} - {{ $p->tgl_check_out }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1 rounded-full text-xs font-medium 
                                @if($p->status_pemesanan == 'confirmed') bg-green-100 text-green-800
                                @elseif($p->status_pemesanan == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($p->status_pemesanan == 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($p->status_pemesanan) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('admin.pemesanan.show', $p->id_pemesanan) }}" class="text-blue-500 hover:underline">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada pemesanan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $pemesanan->links() ?? '' }}
    </div>
@endsection
