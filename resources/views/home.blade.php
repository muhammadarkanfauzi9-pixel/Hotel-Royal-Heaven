@extends('layouts.app')

@section('page_title', 'Home')

@section('content')
</head>
<body class="bg-white font-sans">

    {{-- Header dipisah ke komponen --}}
    @include('components.Navbar')
    @include('components.hero-section')
        

        <hr class="max-w-7xl mx-auto">


        <!-- Popular Rooms Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h2 class="text-2xl font-bold text-center text-gray-900 mb-12">Our Most Popular Rooms</h2>
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @for ($i = 0; $i < 3; $i++)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gray-200 h-48 w-full"></div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900">Headline</h3>
                        <p class="mt-2 text-sm text-gray-500 line-clamp-3">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                        <div class="mt-4 flex justify-end">
                            <a href="#" class="text-sm font-medium text-orange-500 hover:text-orange-600 border border-orange-500 px-3 py-1 rounded-full transition duration-150 ease-in-out">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </section>

    </main>

    </body>
</html>