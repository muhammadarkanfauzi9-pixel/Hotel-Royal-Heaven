@extends('layouts.admin')

@section('page_title', 'Edit Kamar')
@section('page_subtitle', 'Ubah data kamar')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Edit Kamar</h2>

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.kamar.update', $kamar->id_kamar) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="nomor_kamar" class="block text-sm font-medium text-gray-700">Nomor Kamar</label>
                <input type="text" id="nomor_kamar" name="nomor_kamar" value="{{ old('nomor_kamar', $kamar->nomor_kamar) }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm px-3 py-2 border focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="id_tipe" class="block text-sm font-medium text-gray-700">Tipe Kamar</label>
                <select id="id_tipe" name="id_tipe" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm px-3 py-2 border focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @foreach($tipe as $t)
                        <option value="{{ $t->id_tipe }}" @if(old('id_tipe', $kamar->id_tipe) == $t->id_tipe) selected @endif>
                            {{ $t->nama_tipe }} - Rp {{ number_format($t->harga_dasar, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="mt-1 w-full border-gray-300 rounded-md shadow-sm px-3 py-2 border focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('deskripsi', $kamar->deskripsi) }}</textarea>
            </div>

            <div>
                <label for="status_ketersediaan" class="block text-sm font-medium text-gray-700">Status Ketersediaan</label>
                <select id="status_ketersediaan" name="status_ketersediaan" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm px-3 py-2 border focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="available" @if(old('status_ketersediaan', $kamar->status_ketersediaan) == 'available') selected @endif>Tersedia</option>
                    <option value="booked" @if(old('status_ketersediaan', $kamar->status_ketersediaan) == 'booked') selected @endif>Dipesan</option>
                    <option value="maintenance" @if(old('status_ketersediaan', $kamar->status_ketersediaan) == 'maintenance') selected @endif>Perbaikan</option>
                </select>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
                    Perbarui
                </button>
                <a href="{{ route('admin.kamar.index') }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded hover:bg-gray-400 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
