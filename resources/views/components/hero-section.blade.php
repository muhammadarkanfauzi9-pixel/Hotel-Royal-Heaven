@props([
    'title' => 'Hotel for Every Moment Rich in Money',
    'subtitle' => 'The Ultimate Luxury Experience',
    'description' => 'A hotel that has been established for a long time and has a cool be used as a family vacation spot.',
    'image' => 'user/kmrbnt5 (1).jpg',
    'ctaText' => 'Know More About Hotel',
    'ctaLink' => '#',
    'splitPercent' => 50, // Default split at 50% width
    'angle' => 105, // Default angle
    'bgHex' => '#E3A008' // Default to gold-500 from palette
])

<section class="relative w-full min-h-[600px] lg:h-screen flex items-center overflow-hidden bg-gray-900">
    {{-- Background with Diagonal Split using Linear Gradient --}}
    <div class="absolute inset-0 z-0 hidden lg:block" 
         style="background: linear-gradient({{ $angle }}deg, {{ $bgHex }} 0%, {{ $bgHex }} {{ $splitPercent }}%, transparent {{ $splitPercent }}.1%, transparent 100%), url('{{ $image }}'); 
                background-size: cover; 
                background-position: center;">
    </div>

    {{-- Mobile Background (Stacked) --}}
    <div class="absolute inset-0 z-0 lg:hidden">
        <div class="absolute inset-0 bg-gold-500 opacity-95 z-10"></div>
        <img src="{{ $image }}" class="absolute inset-0 w-full h-full object-cover opacity-30 z-0" alt="Background">
    </div>

    {{-- Content Container --}}
    <div class="relative z-10 max-w-[100rem] mx-auto px-4 sm:px-6 lg:px-8 w-full h-full flex items-center">
        {{-- Dynamic Width based on splitPercent for Desktop --}}
        <div class="w-full lg:w-[{{ $splitPercent }}%] py-20 lg:py-0" style="@media (min-width: 1024px) { width: {{ $splitPercent }}%; }">
             {{-- Subtitle --}}
             <span class="block text-sm font-bold tracking-widest uppercase mb-4 text-gray-800 lg:text-gray-800">
                 {{ $subtitle }}
             </span>
             
             {{-- Title --}}
             <h1 class="max-w-2xl text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6 text-gray-900">
                 {!! nl2br(e($title)) !!}
             </h1>
             
             {{-- Description --}}
             <p class="text-lg mb-8 text-gray-800 lg:text-gray-800 max-w-md leading-relaxed font-medium">
                 {{ $description }}
             </p>
             
             {{-- CTA Button --}}
             @if($ctaText)
             <a href="{{ $ctaLink }}" class="inline-flex items-center px-8 py-4 border-2 border-gray-100 text-base font-bold rounded-full text-white bg-gold-600 hover:bg-gold-700 hover:border-gold-600 transition shadow-lg transform hover:-translate-y-1">
                 {{ $ctaText }}
                 <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
             </a>
             @endif
        </div>
    </div>
</section>