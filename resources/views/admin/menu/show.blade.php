@extends('admin.layout.main')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-800 md:text-3xl">Detail Menu</h1>
                    <p class="mb-0 text-sm text-slate-500">Informasi lengkap menu untuk pengecekan cepat.</p>
                </div>
                <a href="{{ route('admin.menu.index') }}" class="btn-admin-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
    </div>
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/80">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Gambar Menu -->
                    <div>
                        @if($menu->gambar)
                            <img src="{{ asset('storage/menu/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}"
                                class="h-64 w-full rounded-xl object-cover shadow-lg">
                        @else
                            <div class="flex h-64 w-full items-center justify-center rounded-xl bg-slate-100">
                                <i class="fas fa-utensils text-6xl text-slate-400"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Detail Menu -->
                    <div>
                        <h2 class="mb-2 text-2xl font-bold text-slate-800">{{ $menu->nama_menu }}</h2>

                        <div class="mb-4 flex items-center gap-2">
                            <span class="rounded-full bg-purple-100 px-3 py-1 text-sm font-semibold text-purple-700">
                                {{ $menu->kategori->nama_kategori ?? 'Tidak ada kategori' }}
                            </span>
                            <span class="rounded-full px-3 py-1 text-sm font-semibold {{ $menu->is_available ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                {{ $menu->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </div>

                        <div class="space-y-3 rounded-xl border border-slate-100 bg-slate-50 p-4">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Harga:</span>
                                <span class="text-lg font-semibold text-slate-700">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Stok:</span>
                                <span class="font-semibold text-slate-700">{{ $menu->stok }} unit</span>
                            </div>
                            @if($menu->ukuran)
                            <div class="flex justify-between">
                                <span class="text-slate-500">Ukuran:</span>
                                <span class="font-semibold text-slate-700">{{ $menu->ukuran }}</span>
                            </div>
                            @endif
                            @if($menu->durasi_persiapan)
                            <div class="flex justify-between">
                                <span class="text-slate-500">Durasi Persiapan:</span>
                                <span class="font-semibold text-slate-700">{{ $menu->durasi_persiapan }} menit</span>
                            </div>
                            @endif
                        </div>

                        @if($menu->deskripsi)
                        <div class="mt-4">
                            <h4 class="mb-2 font-semibold text-slate-700">Deskripsi</h4>
                            <p class="text-sm text-slate-600">{{ $menu->deskripsi }}</p>
                        </div>
                        @endif

                        @if($menu->bahan)
                        <div class="mt-4">
                            <h4 class="mb-2 font-semibold text-slate-700">Bahan Utama</h4>
                            <p class="text-sm text-slate-600">{{ $menu->bahan }}</p>
                        </div>
                        @endif

                        <div class="mt-6 flex gap-2 border-t border-slate-100 pt-4">
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
@endsection
