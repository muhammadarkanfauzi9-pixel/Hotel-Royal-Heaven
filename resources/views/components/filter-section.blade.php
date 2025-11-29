@props([
    'title' => 'Filter & Search',
    'showSearch' => true,
    'showTypeFilter' => true,
    'showPriceFilter' => false,
    'showSortFilter' => true,
    'searchPlaceholder' => 'Search...',
    'tipeKamars' => []
])

<div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-yellow-100 rounded-lg">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900">{{ $title }}</h2>
        </div>

        {{-- Active Filters Count --}}
        <div class="text-sm text-gray-600">
            <span id="activeFiltersCount" class="hidden">0 active filters</span>
        </div>
    </div>

    {{-- Filter Form --}}
    <form class="space-y-6">
        {{-- Main Filters Row --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Search Input --}}
            @if($showSearch)
                <div class="lg:col-span-2">
                    <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" id="search" name="search"
                               placeholder="{{ $searchPlaceholder }}"
                               class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
                    </div>
                </div>
            @endif

            {{-- Room Type Filter --}}
            @if($showTypeFilter)
                <div>
                    <label for="tipe_kamar" class="block text-sm font-semibold text-gray-700 mb-2">Room Type</label>
                    <div class="relative">
                        <select id="tipe_kamar" name="tipe_kamar"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white appearance-none">
                            <option value="">All Types</option>
                            @foreach($tipeKamars as $tipe)
                                <option value="{{ $tipe->id_tipe }}">{{ $tipe->nama_tipe }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Sort Filter --}}
            @if($showSortFilter)
                <div>
                    <label for="sort" class="block text-sm font-semibold text-gray-700 mb-2">Sort By</label>
                    <div class="relative">
                        <select id="sort" name="sort"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white appearance-none">
                            <option value="recommendation">Recommendation</option>
                            <option value="price_low">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>
                            <option value="rating">Top Rated</option>
                            <option value="newest">Newest</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Price Range Filters --}}
        @if($showPriceFilter)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="harga_min" class="block text-sm font-semibold text-gray-700 mb-2">Minimum Price</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-gray-400 font-medium">Rp</span>
                        </div>
                        <input type="number" id="harga_min" name="harga_min"
                               placeholder="0"
                               class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
                    </div>
                </div>
                <div>
                    <label for="harga_max" class="block text-sm font-semibold text-gray-700 mb-2">Maximum Price</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-gray-400 font-medium">Rp</span>
                        </div>
                        <input type="number" id="harga_max" name="harga_max"
                               placeholder="9999999"
                               class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
                    </div>
                </div>
            </div>
        @endif

        {{-- Action Buttons --}}
        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-100">
            <button type="submit"
                    class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-semibold rounded-xl shadow-lg shadow-yellow-500/30 hover:shadow-yellow-500/50 transition-all duration-200 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Apply Filters
            </button>

            <button type="button"
                    onclick="resetFilters()"
                    class="inline-flex items-center justify-center px-8 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Reset Filters
            </button>

            {{-- Results Count --}}
            <div class="flex items-center text-sm text-gray-600 ml-auto">
                <span id="resultsCount" class="hidden">0 results found</span>
            </div>
        </div>
    </form>
</div>

<script>
function resetFilters() {
    // Reset all form inputs
    const form = event.target.closest('form');
    form.reset();

    // Reset select elements to default values
    const selects = form.querySelectorAll('select');
    selects.forEach(select => {
        select.selectedIndex = 0;
    });

    // Submit form to refresh results
    form.submit();
}

function updateActiveFiltersCount() {
    const form = document.querySelector('.filter-section form');
    if (!form) return;

    const inputs = form.querySelectorAll('input, select');
    let activeCount = 0;

    inputs.forEach(input => {
        if (input.type === 'text' || input.type === 'number') {
            if (input.value.trim() !== '') activeCount++;
        } else if (input.tagName === 'SELECT') {
            if (input.selectedIndex > 0) activeCount++;
        }
    });

    const counter = document.getElementById('activeFiltersCount');
    if (activeCount > 0) {
        counter.textContent = `${activeCount} active filter${activeCount > 1 ? 's' : ''}`;
        counter.classList.remove('hidden');
    } else {
        counter.classList.add('hidden');
    }
}

// Update counter on input changes
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.filter-section form');
    if (form) {
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('change', updateActiveFiltersCount);
            input.addEventListener('input', updateActiveFiltersCount);
        });
        updateActiveFiltersCount(); // Initial count
    }
});
</script>
