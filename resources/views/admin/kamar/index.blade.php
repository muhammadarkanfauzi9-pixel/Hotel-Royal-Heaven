@if(auth()->check() && auth()->user()->isAdmin())
    @extends('layouts.admin')
    @section('page_title', 'Manajemen Kamar')
    @section('page_subtitle', 'Kelola semua kamar di hotel Royal Heaven')
@else
    @extends('layouts.app')
    @section('page_title', 'Daftar Kamar')
@endif

@section('content')
    <!-- HERO SECTION (responsive) -->
    <section class="relative w-full mb-12 overflow-hidden">
        <!-- ...existing code... -->
    </section>

    <!-- GROUPED ROOMS BY TIPE -->
    <section class="w-full max-w-7xl mx-auto py-12 px-6">
        <h2 class="text-3xl font-bold text-center mb-10">Daftar <span class="text-yellow-500">Kamar</span> Berdasarkan Tipe</h2>
        @foreach($tipeKamars as $tipe)
            @php
                $groupKamars = $kamarsAll->where('id_tipe', $tipe->id_tipe);
            @endphp
            @if($groupKamars->count() > 0)
                <div class="mb-12">
                    <h3 class="text-2xl font-bold text-blue-900 mb-6">{{ $tipe->nama_tipe }} <span class="text-yellow-500">({{ $groupKamars->count() }})</span></h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($groupKamars as $kamar)
                            <div class="bg-white rounded-2xl shadow-xl border border-blue-900/10 overflow-hidden flex flex-col">
                                <div class="h-48 bg-white flex items-center justify-center border-b border-blue-900/5">
                                    @php
                                        $imgPath = 'user/kamar-' . $kamar->id_kamar . '.jpg';
                                    @endphp
                                    @if(file_exists(public_path($imgPath)))
                                        <img src="{{ asset($imgPath) }}" alt="Kamar {{ $kamar->nomor_kamar }}" class="w-full h-full object-cover">
                                    @else
                                        <img src="{{ asset('user/hotel-pool.jpg') }}" alt="Default Room" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="p-6 flex-1 flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-xl font-bold text-blue-900 mb-2">Kamar {{ $kamar->nomor_kamar }}</h3>
                                        <p class="text-sm text-gray-600 mb-2">{{ $tipe->nama_tipe }}</p>
                                        <p class="text-xs text-gray-500 uppercase tracking-wide">Harga Per Malam</p>
                                        <p class="text-lg font-bold text-yellow-600">Rp{{ number_format($tipe->harga_dasar ?? 0, 0, ',', '.') }}</p>
                                        @if($kamar->deskripsi)
                                            <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $kamar->deskripsi }}</p>
                                        @endif
                                    </div>
                                    <div class="mt-4 flex gap-2">
                                        @if(auth()->check())
                                            @if(auth()->user()->isAdmin())
                                                <a href="{{ route('kamar.edit', $kamar) }}" class="flex-1 text-center bg-blue-900 hover:bg-blue-800 text-white py-2 rounded font-semibold transition-colors">Edit</a>
                                            @else
                                                <a href="{{ route('pemesanan.create') }}?kamar={{ $kamar->id_kamar }}" class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded font-semibold transition-colors">Pesan</a>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded font-semibold transition-colors">Login untuk Pesan</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </section>

    <!-- ABOUT SECTION -->
    <section id="about" class="w-full max-w-6xl mx-auto py-12 px-6 flex flex-col lg:flex-row items-center gap-12">
        <div class="lg:w-1/2">
            <h2 class="text-2xl font-bold mb-4"><span class="text-yellow-500">A little</span> <span class="text-blue-900">about us</span></h2>
            <p class="text-gray-700 mb-6">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
        </div>
        <div class="lg:w-1/2 grid grid-cols-2 gap-4">
            <div class="bg-gray-200 rounded-xl h-24"></div>
            <div class="bg-gray-200 rounded-xl h-24"></div>
            <div class="bg-gray-200 rounded-xl h-24 col-span-2"></div>
        </div>
    </section>

    <!-- POPULAR ROOMS SECTION -->
    <section class="w-full max-w-6xl mx-auto py-12 px-6">
        <h2 class="text-3xl font-bold text-center mb-10">Our Most <span class="text-yellow-500">Popular Rooms</span></h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($kamars->take(3) as $kamar)
                <div class="bg-white rounded-2xl shadow-xl border border-blue-900/10 overflow-hidden flex flex-col">
                    <div class="h-48 bg-white flex items-center justify-center border-b border-blue-900/5">
                        <img src="{{ asset('user/hotel-pool.jpg') }}" alt="Kamar {{ $kamar->nomor_kamar }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-blue-900 mb-2">Kamar {{ $kamar->nomor_kamar }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $kamar->tipe->nama_tipe ?? '-' }}</p>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Harga Per Malam</p>
                            <p class="text-lg font-bold text-yellow-600">Rp{{ number_format($kamar->tipe->harga_dasar ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-900 text-white shadow">Popular</span>
                            <a href="{{ route('pemesanan.create') }}?kamar={{ $kamar->id_kamar }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-6 rounded-full transition-colors text-sm">Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- SEARCH & FILTER + ALL ROOMS -->
    <section class="w-full max-w-6xl mx-auto py-12 px-6">
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-blue-900 mb-4">Cari & Filter Kamar</h2>
            <form method="GET" action="{{ route('kamar.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search by Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-blue-900 mb-1">Tipe Kamar</label>
                        <select name="type" id="type" class="w-full px-3 py-2 border border-blue-900/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                            <option value="">-- Semua Tipe --</option>
                            @foreach($tipeKamars as $tipe)
                                <option value="{{ $tipe->nama_tipe }}" @selected(request('type') == $tipe->nama_tipe)>
                                    {{ $tipe->nama_tipe }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Filter Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-blue-900 mb-1">Status</label>
                        <select name="status" id="status" class="w-full px-3 py-2 border border-blue-900/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                            <option value="">-- Semua Status --</option>
                            <option value="available" @selected(request('status') == 'available')>Tersedia</option>
                            <option value="booked" @selected(request('status') == 'booked')>Dipesan</option>
                            <option value="maintenance" @selected(request('status') == 'maintenance')>Pemeliharaan</option>
                        </select>
                    </div>
                    <!-- Min Price -->
                    <div>
                        <label for="price_min" class="block text-sm font-medium text-blue-900 mb-1">Harga Minimum</label>
                        <input type="number" name="price_min" id="price_min" placeholder="Rp..." value="{{ request('price_min') }}" class="w-full px-3 py-2 border border-blue-900/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                    </div>
                    <!-- Max Price -->
                    <div>
                        <label for="price_max" class="block text-sm font-medium text-blue-900 mb-1">Harga Maksimum</label>
                        <input type="number" name="price_max" id="price_max" placeholder="Rp..." value="{{ request('price_max') }}" class="w-full px-3 py-2 border border-blue-900/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                    </div>
                </div>
                <div class="flex gap-3 mt-4">
                    <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                        Cari
                    </button>
                    <a href="{{ route('kamar.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded-lg transition-colors">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Kamar Grid -->
        @if($kamars->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($kamars as $kamar)
                    <div class="bg-white rounded-2xl shadow-xl border border-blue-900/10 overflow-hidden flex flex-col">
                        <div class="h-48 bg-gradient-to-br from-blue-900 via-yellow-100 to-yellow-50 flex items-center justify-center">
                            <svg class="w-16 h-16 text-yellow-300" fill="currentColor" viewBox="0 0 20 20"><path d="M4 14V6a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H6a2 2 0 01-2-2zM6 8h8v6H6V8z"></path></svg>
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-blue-900 mb-2">Kamar {{ $kamar->nomor_kamar }}</h3>
                                <p class="text-sm text-gray-600 mb-2">{{ $kamar->tipe->nama_tipe ?? '-' }}</p>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Harga Per Malam</p>
                                <p class="text-lg font-bold text-yellow-600">Rp{{ number_format($kamar->tipe->harga_dasar ?? 0, 0, ',', '.') }}</p>
                                @if($kamar->deskripsi)
                                    <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $kamar->deskripsi }}</p>
                                @endif
                            </div>
                            <div class="mt-4 flex gap-2">
                                @if(auth()->check())
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('kamar.edit', $kamar) }}" class="flex-1 text-center bg-blue-900 hover:bg-blue-800 text-white py-2 rounded font-semibold transition-colors">Edit</a>
                                        <form method="POST" action="{{ route('kamar.destroy', $kamar) }}" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kamar ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded font-semibold transition-colors">Hapus</button>
                                        </form>
                                    @else
                                        @if($kamar->status_ketersediaan == 'available')
                                            <a href="{{ route('pemesanan.create') }}?kamar={{ $kamar->id_kamar }}" class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded font-semibold transition-colors">Pesan Sekarang</a>
                                        @else
                                            <button disabled class="flex-1 text-center bg-gray-400 text-white py-2 rounded font-semibold cursor-not-allowed">Tidak Tersedia</button>
                                        @endif
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded font-semibold transition-colors">Login untuk Pesan</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Pagination -->
            <div class="mt-8">
                {{ $kamars->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4 14V6a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H6a2 2 0 01-2-2zM6 8h8v6H6V8z"></path></svg>
                <p class="text-gray-500 text-lg">Tidak ada kamar yang sesuai dengan kriteria pencarian</p>
            </div>
        @endif
    </section>
@endsection
