@extends('layouts.app')

@section('title', 'Daftar Kamar')

@section('content')

{{-- TEMPATKAN PEMANGGILAN NAVBAR ANDA DI SINI --}}
@include('components.herosectionkamar')

{{-- Search/Filter Bar --}}
<div id="main-content" class="relative z-30 -mt-16 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
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
    {{-- Grid Kamar (grid-cols-5) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        @forelse($kamars ?? [] as $kamar)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 group flex flex-col">
                {{-- Image --}}
                <div class="h-64 w-full overflow-hidden bg-gray-200 relative">
                    @if($kamar->foto_kamar)
                        <img src="{{ asset('storage/' . $kamar->foto_kamar) }}" alt="{{ $kamar->nomor_kamar }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-gray-900 shadow-sm">
                        {{ $kamar->tipe->nama_tipe }}
                    </div>
                    {{-- Status Badge --}}
                    <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-bold uppercase shadow-sm
                        @if(($kamar->status_ketersediaan ?? 'booked') == 'available')
                            bg-green-500 text-white
                        @else
                            bg-red-500 text-white
                        @endif">
                        {{ ucfirst($kamar->status_ketersediaan ?? 'Booked') }}
                    </span>
                </div>

                {{-- Content --}}
                <div class="p-4 bg-gray-100/50 flex flex-col flex-grow">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Kamar {{ $kamar->nomor_kamar }}</h3>
                    <p class="text-gray-500 text-xs line-clamp-2 mb-3 flex-grow">
                        {{ $kamar->deskripsi ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Perfect comfort with our selection of luxury hotel rooms.' }}
                    </p>

                    <div class="flex flex-col gap-1 mb-3">
                        <span class="text-xs font-semibold text-yellow-600 uppercase tracking-wider">Price</span>
                        <span class="text-sm font-bold text-gray-900">Rp {{ number_format($kamar->tipe->harga_dasar ?? 0, 0, ',', '.') }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-2 mt-auto">
                        <a href="{{ route('member.kamar.show', $kamar) }}" class="px-2 py-2 text-center text-xs font-semibold text-gray-700 border border-gray-300 rounded-lg hover:bg-white hover:border-gray-400 transition">
                            Detail
                        </a>
                        @if(($kamar->status_ketersediaan ?? 'booked') == 'available')
                            <button onclick="openBookingModal({{ $kamar->id_kamar }})" class="px-2 py-2 text-center text-xs font-semibold text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 transition shadow-md shadow-yellow-200">
                                Book
                            </button>
                        @else
                            <button disabled class="px-2 py-2 text-center text-xs font-semibold text-white bg-red-400 rounded-lg cursor-not-allowed opacity-70">
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
@endsection
