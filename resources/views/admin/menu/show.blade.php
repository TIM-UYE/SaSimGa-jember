@extends('admin.layout.main')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="w-full px-3">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl">
            <div class="p-4 flex justify-between items-center border-b">
                <h5 class="font-bold">Detail Menu</h5>
                <a href="{{ route('admin.menu.index') }}" class="btn-admin-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Gambar Menu -->
                    <div>
                        @if($menu->gambar)
                            <img src="{{ asset('storage/menu/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}"
                                class="w-full h-64 object-cover rounded-xl shadow-lg">
                        @else
                            <div class="w-full h-64 bg-gray-200 rounded-xl flex items-center justify-center">
                                <i class="fas fa-utensils text-6xl text-gray-400"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Detail Menu -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $menu->nama_menu }}</h2>

                        <div class="flex items-center gap-2 mb-4">
                            <span class="px-3 py-1 text-sm rounded-full bg-purple-100 text-purple-800">
                                {{ $menu->kategori->nama_kategori ?? 'Tidak ada kategori' }}
                            </span>
                            <span class="px-3 py-1 text-sm rounded-full {{ $menu->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $menu->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Harga:</span>
                                <span class="font-semibold text-lg">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Stok:</span>
                                <span class="font-semibold">{{ $menu->stok }} unit</span>
                            </div>
                            @if($menu->ukuran)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ukuran:</span>
                                <span class="font-semibold">{{ $menu->ukuran }}</span>
                            </div>
                            @endif
                            @if($menu->durasi_persiapan)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Durasi Persiapan:</span>
                                <span class="font-semibold">{{ $menu->durasi_persiapan }} menit</span>
                            </div>
                            @endif
                        </div>

                        @if($menu->deskripsi)
                        <div class="mt-4">
                            <h4 class="font-semibold text-gray-700 mb-2">Deskripsi</h4>
                            <p class="text-gray-600 text-sm">{{ $menu->deskripsi }}</p>
                        </div>
                        @endif

                        @if($menu->bahan)
                        <div class="mt-4">
                            <h4 class="font-semibold text-gray-700 mb-2">Bahan Utama</h4>
                            <p class="text-gray-600 text-sm">{{ $menu->bahan }}</p>
                        </div>
                        @endif

                        <div class="mt-6 flex gap-2">
                            <a href="{{ route('admin.menu.edit', $menu) }}" class="btn-admin">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('admin.menu.destroy', $menu) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-admin-danger">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
