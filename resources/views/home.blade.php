@extends('layouts.app')

@section('page_title', 'Home')

@section('content')
</head>
<body class="bg-white font-sans">

    {{-- Header dipisah ke komponen --}}
    @include('components.Navbar')
    {{-- HERO SECTION --}}
    <x-hero-section 
        title="Hotel for Every Moment Rich in Money"
        subtitle="The Ultimate Luxury Experience"
        description="A hotel that has been established for a long time and has a cool be used as a family vacation spot."
        image="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
        ctaText="Know More About Hotel"
        ctaLink="{{ route('about') }}"
        splitPercent="50"
        angle="105"
    />
        

    <hr class="max-w-7xl mx-auto border-gray-200 my-8">

    {{-- ABOUT SNIPPET SECTION --}}
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                        A <span class="text-yellow-500">little</span> about us
                    </h2>
                    <p class="text-gray-600 text-lg leading-relaxed mb-6">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.
                    </p>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="h-48 bg-gray-300 rounded-2xl"></div>
                    <div class="h-48 bg-gray-300 rounded-2xl"></div>
                    <div class="col-span-2 h-48 bg-gray-300 rounded-2xl"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Rooms Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 bg-gray-50">
        <h2 class="text-3xl font-serif font-bold text-center text-gray-900 mb-12">Our Most Popular Rooms</h2>
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
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

    </main>

    </body>
</html>