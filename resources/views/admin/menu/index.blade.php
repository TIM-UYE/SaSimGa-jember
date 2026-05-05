@extends('admin.layout.main')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
@endif

<div class="flex flex-wrap -mx-3 mb-4">
    <div class="w-full px-3">
        <div class="relative flex flex-col min-w-0 mb-4 wrap-break-words bg-white shadow-soft-xl rounded-2xl">
            <div class="p-4 flex justify-between items-center">
                <h5 class="font-bold">Menu Restaurant</h5>
                <a href="{{ route('admin.menu.create') }}" class="btn-admin">Tambah Menu</a>
            </div>
            <div class="p-4 overflow-x-auto">
                <table class="items-center w-full mb-0 align-top border-gray-200 text-gray-700">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Gambar</th>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Nama Menu</th>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Kategori</th>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Harga</th>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Stok</th>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Status</th>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menus as $menu)
                        <tr>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                @if($menu->gambar)
                                    <img src="{{ asset('storage/menu/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}" class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-utensils text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <h6 class="mb-0 text-sm leading-normal">{{ $menu->nama_menu }}</h6>
                                <p class="mb-0 text-xs text-gray-500">{{ Str::limit($menu->deskripsi, 50) }}</p>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">
                                    {{ $menu->kategori->nama_kategori ?? 'Tidak ada' }}
                                </span>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <p class="mb-0 text-sm font-semibold">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <p class="mb-0 text-sm">{{ $menu->stok }}</p>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <span class="px-2 py-1 text-xs rounded-full {{ $menu->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $menu->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <a href="{{ route('admin.menu.show', $menu->id) }}" class="btn-admin-secondary">Detail</a>
                                <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn-admin-secondary ml-2">Edit</a>
                                <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-admin-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="p-4 text-center text-gray-500">
                                Tidak ada menu yang tersedia. Silakan tambah menu baru.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
