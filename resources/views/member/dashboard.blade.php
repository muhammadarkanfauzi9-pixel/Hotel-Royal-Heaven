@extends('layouts.app')

@section('title', 'Member Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard Member</h1>
        <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Menu: Daftar Kamar -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center mb-4">
                <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 ml-3">Daftar Kamar</h3>
            </div>
            <p class="text-gray-600 mb-4">Lihat dan pilih kamar yang tersedia untuk dipesan</p>
            <a href="{{ route('member.kamar.index') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Lihat Kamar
            </a>
        </div>

        <!-- Menu: Riwayat Pemesanan -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center mb-4">
                <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 ml-3">Riwayat Pemesanan</h3>
            </div>
            <p class="text-gray-600 mb-4">Cek status dan detail riwayat pemesanan Anda</p>
            <a href="{{ route('member.pemesanan.index') }}" class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                Lihat Riwayat
            </a>
        </div>

        <!-- Menu: Profil -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center mb-4">
                <svg class="h-8 w-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 ml-3">Profil Saya</h3>
            </div>
            <p class="text-gray-600 mb-4">Kelola informasi pribadi dan pengaturan akun Anda</p>
            <a href="{{ route('member.profile.show') }}" class="inline-block bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600">
                Lihat Profil
            </a>
        </div>
    </div>
</div>
@endsection
