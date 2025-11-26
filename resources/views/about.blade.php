@extends('layouts.app')
@section('page_title', 'About Us')
@include('components.hero-section')
@section('content')
<div class="max-w-4xl mx-auto py-16">
    <h1 class="text-4xl font-bold text-blue-900 mb-6">About Royal Heaven Hotel</h1>
    <div class="mb-8 text-lg text-gray-700">Royal Heaven Hotel adalah hotel bintang 4 yang telah berdiri sejak 1999 di Kota Malang. Kami menawarkan pengalaman menginap mewah, fasilitas lengkap, dan pelayanan profesional untuk keluarga, bisnis, maupun wisatawan.</div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
        <div>
            <h2 class="text-xl font-semibold mb-2 text-yellow-600">Visi</h2>
            <p class="text-gray-700">Menjadi hotel terbaik di Malang yang memberikan kenyamanan, kemewahan, dan pengalaman tak terlupakan bagi setiap tamu.</p>
        </div>
        <div>
            <h2 class="text-xl font-semibold mb-2 text-yellow-600">Misi</h2>
            <ul class="list-disc ml-6 text-gray-700">
                <li>Menyediakan fasilitas hotel modern dan lengkap</li>
                <li>Memberikan pelayanan ramah dan profesional</li>
                <li>Menjaga kebersihan dan keamanan lingkungan hotel</li>
                <li>Mendukung pariwisata dan ekonomi lokal</li>
            </ul>
        </div>
    </div>
    <div class="bg-gray-100 rounded-xl p-8 shadow">
        <h3 class="text-lg font-bold mb-2 text-blue-900">Kontak & Lokasi</h3>
        <ul class="text-gray-700">
            <li>Alamat: Jl. Garuda No. 1, Malang</li>
            <li>Telepon: +62 821 xxxx xxxx</li>
            <li>Email: info@royalheaven.com</li>
        </ul>
    </div>
</div>
@endsection
