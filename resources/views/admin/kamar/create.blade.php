@extends('layouts.admin')

@section('page_title', 'Tambah Kamar Baru')
@section('page_subtitle', 'Menambahkan kamar baru ke sistem hotel')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('kamar.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="nomor_kamar" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Kamar
                    </label>
                    <input 
                        type="text" 
                        id="nomor_kamar" 
                        name="nomor_kamar" 
                        placeholder="Cth: 101, 102, A-01" 
                        required
                        value="{{ old('nomor_kamar') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('nomor_kamar') border-red-500 @enderror"
                    >
                    @error('nomor_kamar')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="id_tipe" class="block text-sm font-medium text-gray-700 mb-2">
                        Tipe Kamar
                    </label>
                    <select 
                        id="id_tipe" 
                        name="id_tipe" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('id_tipe') border-red-500 @enderror"
                    >
                        <option value="">-- Pilih Tipe Kamar --</option>
                        @foreach($tipe as $t)
                            <option value="{{ $t->id_tipe }}" @selected(old('id_tipe') == $t->id_tipe)>
                                {{ $t->nama_tipe }} (Rp {{ number_format($t->harga_dasar, 0, ',', '.') }}/malam)
                            </option>
                        @endforeach
                    </select>
                    @error('id_tipe')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status_ketersediaan" class="block text-sm font-medium text-gray-700 mb-2">
                        Status Ketersediaan
                    </label>
                    <select 
                        id="status_ketersediaan" 
                        name="status_ketersediaan" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('status_ketersediaan') border-red-500 @enderror"
                    >
                        <option value="">-- Pilih Status --</option>
                        <option value="available" @selected(old('status_ketersediaan') == 'available')>Tersedia</option>
                        <option value="booked" @selected(old('status_ketersediaan') == 'booked')>Dipesan</option>
                        <option value="maintenance" @selected(old('status_ketersediaan') == 'maintenance')>Pemeliharaan</option>
                    </select>
                    @error('status_ketersediaan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Kamar
                    </label>
                    <textarea 
                        id="deskripsi" 
                        name="deskripsi" 
                        placeholder="Deskripsikan fitur dan fasilitas kamar"
                        rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror"
                    >{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 pt-6">
                    <button 
                        type="submit" 
                        class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200"
                    >
                        Simpan Kamar
                    </button>
                    <a 
                        href="{{ route('kamar.index') }}" 
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition-colors duration-200 text-center"
                    >
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
