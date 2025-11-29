<div>
    {{-- Filter Section --}}
    <x-filter-section
        :tipeKamars="$tipeKamars"
        :showPriceFilter="true"
        :showDateFilter="true"
        :showCapacityFilter="true"
        :showSortFilter="true"
    />

    {{-- Results Section --}}
    <div class="mt-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Available Rooms</h2>
            <div class="text-sm text-gray-600">
                {{ $kamars->total() }} rooms found
            </div>
        </div>

        {{-- Rooms Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            @forelse($kamars as $kamar)
                <x-room-card :kamar="$kamar" />
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-.98-5.5-2.5m.5-4C6.5 9 4.5 9 4.5 9s2 0 2.5-2.5M19.5 9s-2 0-2.5-2.5m.5 4c.5-2.5 2.5-2.5 2.5-2.5s-2 0-2.5 2.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No rooms found</h3>
                    <p class="text-gray-600">Try adjusting your search criteria or filters.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($kamars->hasPages())
            <div class="mt-8">
                {{ $kamars->links() }}
            </div>
        @endif
    </div>

    {{-- Booking Modal --}}
    <div id="bookingModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div id="modalBackdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- Modal panel -->
            <div id="modalPanel" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Form Pemesanan Kamar
                        </h3>
                        <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="max-h-96 overflow-y-auto">
                        <livewire:booking-form :selectedKamarId="$selectedKamarId ?? null" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openBookingModal(kamarId) {
            const modal = document.getElementById('bookingModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Update Livewire component with selected room
            if (window.livewire) {
                window.livewire.find('booking-form').call('setSelectedRoom', kamarId);
            }
        }

        function closeBookingModal() {
            const modal = document.getElementById('bookingModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Event listeners
        document.getElementById('closeModalBtn').addEventListener('click', closeBookingModal);
        document.getElementById('modalBackdrop').addEventListener('click', closeBookingModal);

        // Listen for booking success event
        window.addEventListener('booking-success', function() {
            closeBookingModal();
        });
    </script>
</div>
