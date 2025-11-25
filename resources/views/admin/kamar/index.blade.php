@extends('layouts.admin')

@section('page_title', 'Manajemen Kamar')
@section('page_subtitle', 'Kelola data kamar hotel')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Daftar Kamar</h2>
        <a href="{{ route('admin.kamar.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            + Tambah Kamar
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nomor Kamar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe Kamar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kamars ?? [] as $kamar)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $kamar->nomor_kamar }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $kamar->tipe->nama_tipe ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1 rounded-full text-xs font-medium 
                                @if($kamar->status_ketersediaan == 'available') bg-green-100 text-green-800
                                @elseif($kamar->status_ketersediaan == 'booked') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($kamar->status_ketersediaan) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">Rp {{ number_format($kamar->tipe->harga_dasar ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('admin.kamar.edit', $kamar->id_kamar) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('admin.kamar.destroy', $kamar->id_kamar) }}" method="POST" class="inline" onclick="return confirm('Apakah Anda yakin?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada kamar</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $kamars->links() ?? '' }}
    </div>
@endsection
