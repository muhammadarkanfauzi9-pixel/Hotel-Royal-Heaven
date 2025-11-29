@extends('layouts.app')

@section('title', 'Daftar Kamar')

@section('content')

{{-- TEMPATKAN PEMANGGILAN NAVBAR ANDA DI SINI --}}
@include('components.Navbar')
@include('components.herosectionkamar')

{{-- Search/Filter Bar --}}
<div class="relative z-30 -mt-16 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <x-filter-section
        title="Find Your Perfect Stay"
        :showSearch="true"
        :showTypeFilter="true"
        :showSortFilter="true"
        :showPriceFilter="true"
        searchPlaceholder="Search by room name or type..."
        :tipeKamars="$tipeKamars ?? []"
    />
</div>

{{-- Room List Content --}}
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
    {{-- Grid Kamar (grid-cols-3) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
        @forelse($kamars ?? [] as $kamar)
            {{-- Kamar Card (Styling: rounded-2xl, shadow-xl, hover:shadow-2xl, hover:scale-[1.01], transition) --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 transform hover:shadow-2xl hover:scale-[1.01] transition duration-300">
                {{-- Image Placeholder Area --}}
                <div class="relative h-60">
                    <img class="w-full h-full object-cover"
                         src="https://placehold.co/600x400/FACC15/FFFFFF/PNG?text={{ $kamar->tipe->nama_tipe ?? 'ROOM' }}"
                         alt="Gambar Kamar {{ $kamar->nomor_kamar }}">

                    {{-- Status Badge (Styling: rounded-full, bg-green-600/bg-red-600, shadow-lg) --}}
                    <span class="absolute top-4 right-4 px-4 py-1.5 rounded-full text-xs font-bold uppercase shadow-lg
                        @if(($kamar->status_ketersediaan ?? 'booked') == 'available')
                            bg-green-600 text-white
                        @else
                            bg-red-600 text-white
                        @endif">
                        {{ ucfirst($kamar->status_ketersediaan ?? 'Booked') }}
                    </span>
                </div>

                <div class="p-6">
                    {{-- Price (Styling: text-yellow-600, font-extrabold) --}}
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Room</p>
                            <h3 class="text-2xl font-bold text-gray-900">Kamar {{ $kamar->nomor_kamar }}</h3>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Price</p>
                            <p class="text-2xl font-extrabold text-yellow-600">
                                Rp {{ number_format($kamar->tipe->harga_dasar ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Type</p>
                    <p class="text-base font-semibold text-gray-700 mb-2">{{ $kamar->tipe->nama_tipe ?? 'Tipe Standar' }}</p>

                    <p class="text-sm text-gray-500 mb-6 line-clamp-2">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Perfect comfort with our selection of luxury hotel rooms.
                    </p>

                    {{-- Action Buttons --}}
                    <div class="flex space-x-4">
                        {{-- Detail Button (Styling: bg-gray-100, border, shadow-inner) --}}
                        <a href="{{ route('member.kamar.show', $kamar) }}" class="flex-1 text-center px-4 py-3 rounded-xl text-gray-700 bg-gray-100 border border-gray-300 hover:bg-gray-200 transition font-semibold shadow-inner">
                            Detail
                        </a>

                        {{-- Book Now Button (Styling: bg-yellow-600, shadow-lg shadow-yellow-500/50, hover:-translate-y-0.5) --}}
                        @if(($kamar->status_ketersediaan ?? 'booked') == 'available')
                            <button onclick="openBookingModal({{ $kamar->id_kamar }})"
                               class="flex-1 text-center px-4 py-3 rounded-xl bg-yellow-600 text-white shadow-lg shadow-yellow-500/50 hover:bg-yellow-700 transition font-semibold transform hover:-translate-y-0.5">
                                Book Now
                            </button>
                        @else
                            {{-- Booked Button (Disabled) --}}
                            <button disabled class="flex-1 text-center px-4 py-3 rounded-xl bg-red-400 text-white font-semibold cursor-not-allowed opacity-70 shadow-inner">
                                Booked
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 bg-white rounded-2xl shadow-2xl border border-gray-100">
                <p class="text-3xl font-bold text-gray-900 mb-2">Tidak ada Kamar Ditemukan</p>
                <p class="text-gray-500 text-lg">Saat ini tidak ada kamar yang terdaftar atau tersedia untuk ditampilkan.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-16 flex justify-center">
        {{ $kamars->links() ?? '' }}
    </div>
</div>

<!-- Booking Modal -->
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
    let selectedKamarId = null;

    function openBookingModal(kamarId) {
        selectedKamarId = kamarId;
        const modal = document.getElementById('bookingModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Update Livewire component with selected room
        if (window.livewire) {
            window.livewire.find('booking-form').set('selectedKamarId', kamarId);
        }
    }

    function closeBookingModal() {
        const modal = document.getElementById('bookingModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        selectedKamarId = null;
    }

    // Event listeners
    document.getElementById('closeModalBtn').addEventListener('click', closeBookingModal);
    document.getElementById('modalBackdrop').addEventListener('click', closeBookingModal);

    // Listen for booking success event
    window.addEventListener('booking-success', function() {
        closeBookingModal();
    });
</script>
@endsection
