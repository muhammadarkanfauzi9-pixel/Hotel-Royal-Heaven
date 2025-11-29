@extends('layouts.app')

@section('page_title', 'Home')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Welcome to Royal Heaven Hotel</h1>
    <!-- Home page content here -->
</div>
@endsection
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title', 'Hotel Royal Heaven')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hero-section {
            background-image: url('{{ asset('public/user/GambarHeroSection.jpg') }}');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-white font-sans">

    {{-- Header dipisah ke komponen --}}
    @include('components.Navbar')


    <main>
        <!-- Hero Section -->
        <section class="relative w-full min-h-[730px] flex items-stretch">
    
    <div class="relative flex-1 min-h-[600px] bg-gray-200">
        <img src="{{ asset('user/GambarHeroSection.jpg') }}" alt="Hotel Pool" class="absolute inset-0 w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black bg-opacity-10"></div>
    </div>
    
    <div class="absolute left-0 top-0 bottom-0 w-3/3 lg:w-2/4 xl:w-1/1 z-20"> 
        <div class="w-full h-full" style="background: #FFC83D; clip-path: polygon(0 0, 100% 0%, 80% 100%, 0% 100%);">
        </div>
    </div>
    
    <div class="absolute left-0 top-0 bottom-0 w-3/5 lg:w-2/5 xl:w-1/3 z-30 flex items-center justify-start px-12 py-16">
        <div class="max-w-lg">
            <p class="text-base font-semibold uppercase tracking-wider text-gray-700 mb-4">The Ultimate Luxury Experience</p>
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 mb-4 leading-tight">
                Hotel for Every<br>Moment Rich in Money
            </h1>
            <p class="mb-8 text-base text-gray-700">
                A hotel that has been established for a long time and has a cool be used as a family vacation spot
            </p>
            <a href="#" class="inline-flex items-center justify-center px-6 py-3 border border-orange-500 text-base font-semibold rounded-full text-orange-500 bg-white hover:bg-orange-50 transition">
                Know More About Hotel
                <span class="ml-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            </a>
        </div>
    </div>
</section>
        

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