@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Edit Profil Member</h1>

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('member.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm px-3 py-2 border focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm px-3 py-2 border focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="nohp" class="block text-sm font-medium text-gray-700">No. HP</label>
                <input type="text" id="nohp" name="nohp" value="{{ old('nohp', $user->nohp) }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm px-3 py-2 border focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                <input type="text" id="nik" name="nik" value="{{ old('nik', $user->nik) }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm px-3 py-2 border focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" id="password" name="password" class="mt-1 w-full border-gray-300 rounded-md shadow-sm px-3 py-2 border focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 w-full border-gray-300 rounded-md shadow-sm px-3 py-2 border focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Simpan Perubahan
                </button>
                <a href="{{ route('member.profile.show') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
