<div>
    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('daftarkamar') }}" class="space-y-3">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                {{-- Search Input --}}
                <div class="lg:col-span-2">
                    <label for="search" class="block text-xs font-medium text-gray-700 mb-1">Cari Kamar</label>
                    <div class="relative">
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Cari berdasarkan nomor kamar atau tipe..."
                               class="w-full pl-8 pr-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Room Type Filter --}}
                <div>
                    <label for="tipe_kamar" class="block text-xs font-medium text-gray-700 mb-1">Tipe Kamar</label>
                    <select name="tipe_kamar" id="tipe_kamar"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="">Semua Tipe</option>
                        @foreach($tipeKamars as $tipe)
                            <option value="{{ $tipe->id_tipe }}" {{ request('tipe_kamar') == $tipe->id_tipe ? 'selected' : '' }}>
                                {{ $tipe->nama_tipe }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Availability Filter --}}
                <div>
                    <label for="status" class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                        <option value="unavailable" {{ request('status') == 'unavailable' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                </div>
            </div>

            {{-- Price Range and Sort --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                    <label for="harga_min" class="block text-xs font-medium text-gray-700 mb-1">Harga Min</label>
                    <input type="number" name="harga_min" id="harga_min" value="{{ request('harga_min') }}"
                           placeholder="Rp 0"
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                </div>
                <div>
                    <label for="harga_max" class="block text-xs font-medium text-gray-700 mb-1">Harga Max</label>
                    <input type="number" name="harga_max" id="harga_max" value="{{ request('harga_max') }}"
                           placeholder="Rp 9999999"
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                </div>
                <div>
                    <label for="sort" class="block text-xs font-medium text-gray-700 mb-1">Urutkan</label>
                    <select name="sort" id="sort"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama (A-Z)</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Rendah</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tinggi</option>
                    </select>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-3 pt-3 border-t border-gray-200">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium text-sm rounded-md transition-colors duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari & Filter
                </button>
                <a href="{{ route('daftarkamar') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-md transition-colors duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Reset
                </a>
                @if(request()->hasAny(['search', 'tipe_kamar', 'status', 'harga_min', 'harga_max', 'sort']))
                    <div class="text-xs text-gray-600 flex items-center ml-auto">
                        <span>{{ $kamars->total() }} hasil</span>
                    </div>
                @endif
            </div>
        </form>
    </div>

    <!-- Rooms Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($kamars as $kamar)
            <x-room-card :kamar="$kamar" :showWishlist="false" />
        @empty
            <div class="col-span-full text-center py-16">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Rooms Found</h3>
                <p class="text-gray-600">Try adjusting your search criteria or filters.</p>
            </div>
        @endforelse
    </div>
</div>
