<div>
    <!-- Filter Bar -->
    <div class="bg-gray-100 p-4 rounded-xl mb-8 flex flex-col md:flex-row gap-4 items-center">
        <div class="relative flex-1 w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by name or room type..." class="block w-full pl-10 pr-3 py-2.5 border-none rounded-lg bg-gray-200 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 sm:text-sm">
        </div>
        
        <div class="w-full md:w-48">
            <select wire:model.live="type" class="block w-full py-2.5 px-3 border-none rounded-lg bg-gray-200 text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 sm:text-sm">
                <option value="">All type</option>
                @foreach($tipeKamars as $tipe)
                    <option value="{{ $tipe->id_tipe }}">{{ $tipe->nama_tipe }}</option>
                @endforeach
            </select>
        </div>

        <div class="w-full md:w-48">
             {{-- Placeholder for sort, currently just visual or can implement sorting logic later --}}
            <select class="block w-full py-2.5 px-3 border-none rounded-lg bg-gray-200 text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 sm:text-sm">
                <option>Recommendation</option>
                <option>Price: Low to High</option>
                <option>Price: High to Low</option>
            </select>
        </div>
    </div>

    <!-- Room Grid -->
    <div wire:loading class="w-full text-center py-12">
        <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-white bg-yellow-500 transition ease-in-out duration-150 cursor-not-allowed">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Loading...
        </div>
    </div>

    @if($kamars->isEmpty())
        <div class="text-center py-20 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No rooms found</h3>
            <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter to find what you're looking for.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($kamars as $room)
            <div class="bg-gray-100 rounded-3xl overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col">
                {{-- Image Placeholder --}}
                <div class="h-64 w-full bg-gray-300 relative overflow-hidden group">
                    @if($room->foto_kamar)
                        <img src="{{ asset('storage/' . $room->foto_kamar) }}" alt="{{ $room->nomor_kamar }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    
                    {{-- Options Menu (dots) --}}
                    <button class="absolute top-4 right-4 text-white hover:text-gray-200">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path></svg>
                    </button>
                </div>
                
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Kamar {{ $room->nomor_kamar }}</h3>
                    <p class="text-gray-500 text-sm line-clamp-2 mb-4 flex-grow">
                        {{ $room->deskripsi }}
                    </p>
                    
                    <div class="space-y-1 mb-6">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-yellow-600 uppercase">Price</span>
                            <span class="text-sm font-medium text-gray-900">Rp {{ number_format($room->tipe->harga_dasar, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-gray-900 uppercase">Room Type</span>
                            <span class="text-sm font-medium text-gray-500">{{ $room->tipe->nama_tipe }}</span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mt-auto">
                        <a href="{{ route('member.kamar.show', $room) }}" class="px-4 py-2.5 text-center text-sm font-semibold text-gray-700 border border-gray-400 rounded-full hover:bg-white hover:border-gray-500 transition">
                            Detail
                        </a>
                        @if($room->status_ketersediaan === 'available')
                            <a href="{{ route('member.pemesanan.create', ['kamar' => $room->id_kamar]) }}" class="px-4 py-2.5 text-center text-sm font-semibold text-white bg-yellow-500 rounded-full hover:bg-yellow-600 transition shadow-md shadow-yellow-200">
                                Booking Now
                            </a>
                        @else
                             <button disabled class="px-4 py-2.5 text-center text-sm font-semibold text-white bg-gray-400 rounded-full cursor-not-allowed">
                                Booked
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $kamars->links() }}
        </div>
    @endif
</div>
