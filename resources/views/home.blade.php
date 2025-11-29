@extends('layouts.app')

@section('page_title', 'Home')

@section('content')

{{-- Pastikan Anda tidak memiliki tag <body> atau </head> yang terbuka atau tertutup di sini 
karena sudah ada di 'layouts.app' --}}

    {{-- Header dipisah ke komponen --}}
    

    {{-- HERO SECTION --}}
    {{-- Menggunakan komponen Blade seperti kode asli dan mengisi data (props) --}}
    <x-hero-section 
        title="Hotel for Every Moment Rich in Money"
        subtitle="The Ultimate Luxury Experience"
        description="A hotel that has been established for a long time and has a cool be used as a family vacation spot."
        image='user/GambarHeroSection.jpg'
        ctaText="Know More About Hotel"
        ctaLink="{{ route('about') }}"
        splitPercent="50"
        angle="105"
    />
        
    <hr class="max-w-7xl mx-auto border-gray-200 my-8">

    {{-- START: A Little About Us Section (Mengambil desain dari kode kedua Anda) --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 animate-on-scroll">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

            {{-- Kiri: Teks dan Deskripsi --}}
            <div class="pr- lg:pr-6">
                <h2 class="text-3xl font-extrabold mb-3 text-gray-900">
                    A <span class="text-yellow-500">little</span> about us
                </h2>
                <p class="text-base text-gray-600 leading-relaxed mb-4">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut perspiciatis unde omnis iste
                    natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.
                </p>
                <p class="text-base text-gray-600 leading-relaxed">
                    Kami adalah Royal Heaven, destinasi terbaik untuk pengalaman menginap mewah dan tak terlupakan.
                    Setiap detail kami rancang untuk kenyamanan Anda.
                </p>
            </div>

            {{-- Kanan: Grid Gambar (Diambil dari kode kedua Anda) --}}
            <div class="image-gallery grid grid-cols-2 grid-rows-2 gap-4 min-h-[300px]">

                {{-- Placeholder Atas Kiri --}}
                <div class="rounded-2xl h-48 bg-gray-300 relative overflow-hidden">
                    <img src="{{ asset('user/ruangkanan.jpg') }}" alt="Kamar Deluxe" class="absolute inset-0 w-full h-full object-cover lazy" data-src="{{ asset('user/ruangkanan.jpg') }}">
                </div>

                {{-- Placeholder Atas Kanan --}}
                <div class="rounded-2xl h-48 bg-gray-300 relative overflow-hidden">
                    <img src="{{ asset('user/ruangkiri.jpg') }}" alt="Kolam Renang" class="absolute inset-0 w-full h-full object-cover lazy" data-src="{{ asset('user/ruangkiri.jpg') }}">
                </div>

                {{-- Placeholder Besar Bawah (Col Span 2) --}}
                <div class="col-span-2 rounded-2xl h-48 bg-gray-300 relative overflow-hidden">
                    <img src="{{ asset('user/fotoblokbawah.avif') }}" alt="Lobi Hotel Utama" class="absolute inset-0 w-full h-full object-cover lazy" data-src="{{ asset('user/fotoblokbawah.avif') }}">
                </div>
            </div>

        </div>
    </section>
    {{-- END: A Little About Us Section --}}

    <hr class="max-w-7xl mx-auto border-gray-200 my-8">

    {{-- Popular Rooms Section (Menggunakan variabel $featured_kamar yang BENAR) --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-3xl font-serif font-bold text-center text-gray-900 mb-12">Our Most Popular Rooms</h2>
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            
            {{-- Loop data: WAJIB DISEDIAKAN oleh Controller Anda --}}
            @foreach($featured_kamar as $room)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 group flex flex-col">
                {{-- Image --}}
                <div class="h-64 w-full overflow-hidden bg-gray-200 relative">
                    @if($room->foto_kamar)
                        <img src="{{ asset('storage/' . $room->foto_kamar) }}" alt="{{ $room->nomor_kamar }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-gray-900 shadow-sm">
                        {{ $room->tipe->nama_tipe }}
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-8 bg-gray-100/50 flex flex-col flex-grow">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Kamar {{ $room->nomor_kamar }}</h3>
                    <p class="text-gray-500 text-sm line-clamp-2 mb-6 flex-grow">
                        {{ $room->deskripsi }}
                    </p>
                    
                    <div class="flex flex-col gap-1 mb-6">
                        <span class="text-xs font-semibold text-yellow-600 uppercase tracking-wider">Price</span>
                        <span class="text-xl font-bold text-gray-900">Rp {{ number_format($room->tipe->harga_dasar, 0, ',', '.') }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-auto">
                        <a href="{{ route('member.kamar.show', $room) }}" class="px-4 py-3 text-center text-sm font-semibold text-gray-700 border border-gray-300 rounded-xl hover:bg-white hover:border-gray-400 transition">
                            Detail
                        </a>
                        <a href="{{ route('member.kamar.show', $room) }}" class="px-4 py-3 text-center text-sm font-semibold text-white bg-yellow-500 rounded-xl hover:bg-yellow-600 transition shadow-md shadow-yellow-200">
                            Booking Now
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

@endsection