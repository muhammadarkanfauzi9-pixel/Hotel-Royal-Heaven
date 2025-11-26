@extends('layouts.admin')

@section('page_title', 'Tambah Member')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-6">Tambah Member Baru</h2>

        <form method="POST" action="{{ route('admin.members.store') }}">
            @csrf

            <div class="mb-4">
                <label for="nama_lengkap" class="block mb-1 font-semibold">Nama Lengkap</label>
                <input id="nama_lengkap" name="nama_lengkap" type="text" value="{{ old('nama_lengkap') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 @error('nama_lengkap') border-red-500 @enderror" required>
                @error('nama_lengkap')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="username" class="block mb-1 font-semibold">Username</label>
                <input id="username" name="username" type="text" value="{{ old('username') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 @error('username') border-red-500 @enderror" required>
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block mb-1 font-semibold">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 @error('email') border-red-500 @enderror" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block mb-1 font-semibold">Password</label>
                <input id="password" name="password" type="password"
                       class="w-full border border-gray-300 rounded px-3 py-2 @error('password') border-red-500 @enderror" required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block mb-1 font-semibold">Konfirmasi Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password"
                       class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 transition">
                Simpan
            </button>
            <a href="{{ route('admin.members.index') }}" class="ml-4 text-gray-600 hover:underline">Batal</a>
        </form>
    </div>
@endsection
