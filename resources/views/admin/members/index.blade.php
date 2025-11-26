@extends('layouts.admin')

@section('page_title', 'Manajemen Member')

@section('content')
<div class="overflow-x-auto">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Daftar Member</h2>
        <a href="{{ route('admin.members.create') }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition">
            Tambah Member
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white border border-gray-200 rounded">
        <thead>
            <tr class="bg-yellow-200 text-gray-700">
                <th class="text-left px-4 py-2">Nama Lengkap</th>
                <th class="text-left px-4 py-2">Username</th>
                <th class="text-left px-4 py-2">Email</th>
                <th class="text-left px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $member)
                <tr class="border-t border-gray-200">
                    <td class="px-4 py-2">{{ $member->nama_lengkap }}</td>
                    <td class="px-4 py-2">{{ $member->username }}</td>
                    <td class="px-4 py-2">{{ $member->email }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.members.edit', $member->id) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                        <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" class="inline"
                              onsubmit="return confirm('Anda yakin ingin menghapus member ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4">Tidak ada member ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $members->links() }}
    </div>
</div>
@endsection
