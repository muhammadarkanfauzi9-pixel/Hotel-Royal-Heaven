<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title', 'Admin Dashboard') - Royal Heaven Hotel</title>
    
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* CSS Sidebar */
        .sidebar {
            background-color: #ffb833; /* Warna kuning oranye */
        }
        .nav-item {
            padding: 1rem 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            padding-left: 2rem;
            transition: background-color 0.2s;
            text-decoration: none;
            color: #374151; /* text-gray-700 */
        }
        .nav-item.active {
            background-color: #f7a817; 
            border-right: 5px solid #fff; 
        }
        .nav-item:hover {
            background-color: rgba(247, 168, 23, 0.9);
        }
        .logout-link {
            padding: 1rem 0;
            cursor: pointer;
            display: block;
            padding-left: 2rem;
            color: #b91c1c;
            font-weight: 600;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            margin-top: auto;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        .logout-link:hover {
            background-color: #f7a817; 
            color: #fff;
        }
    </style>
</head>
<body class="bg-gray-50 flex h-screen">

    <div class="sidebar w-64 flex-shrink-0 text-gray-800 shadow-xl flex flex-col">
        <div class="p-6 flex-grow overflow-y-auto">
            <div class="flex flex-col items-center mb-10">
                <div class="w-24 h-24 rounded-full bg-white border-4 border-gray-100 overflow-hidden shadow-lg mb-3">
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-yellow-400 to-yellow-600 text-white text-2xl font-bold">
                        ♛
                    </div>
                </div>
                <div class="text-lg font-semibold text-gray-800">{{ Auth::user()->nama_lengkap ?? Auth::user()->username }}</div>
                <div class="text-xs text-gray-600 mt-1">{{ Auth::user()->level === 'admin' ? 'Administrator' : 'Member' }}</div>
            </div>

            <nav class="space-y-1">
                <a href="{{ route('admin.index') }}" class="nav-item @if(request()->routeIs('admin.index')) active @endif">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                    Dashboard
                </a>

                <a href="{{ route('kamar.index') }}" class="nav-item @if(request()->routeIs('kamar.*')) active @endif">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M4 14V6a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H6a2 2 0 01-2-2zM6 8h8v6H6V8z"></path></svg>
                    Manajemen Kamar
                </a>

                <a href="{{ route('admin.pemesanan.index') }}" class="nav-item @if(request()->routeIs('admin.pemesanan.*')) active @endif">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-8a1 1 0 112 0v3a1 1 0 11-2 0v-3z" clip-rule="evenodd"></path></svg>
                    Pemesanan
                </a>
            </nav>
        </div>
        
        <a href="#" class="logout-link" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h5a1 1 0 000-2H4V4h4a1 1 0 100-2H3zm13 9a1 1 0 00.293-.707l-3-3a1 1 0 00-1.414 1.414L13.586 11H9a1 1 0 100 2h4.586l-1.293 1.293a1 1 0 001.414 1.414l3-3A1 1 0 0016 12z" clip-rule="evenodd"></path></svg>
            Logout
        </a>
        
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <div class="flex-grow flex flex-col overflow-hidden">
        <div class="bg-white border-b border-gray-200 px-8 py-6 shadow-sm">
            <h1 class="text-2xl font-bold text-gray-800">
                @yield('page_title', 'Dashboard')
            </h1>
            <p class="text-sm text-gray-500 mt-1">@yield('page_subtitle')</p>
        </div>

        <div class="flex-grow overflow-y-auto p-8">
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

</body>
</html>
