@extends('Frontend.Layout.app')

@section('content')

<!-- HERO / HEADER -->
<section class="bg-black text-white py-16 px-6 border-b border-gray-800">
    <div class="max-w-7xl mx-auto">

        <h1 class="text-4xl font-bold mb-2">
            Semua <span class="text-orange-500">Menu</span>
        </h1>

        <p class="text-gray-400">
            Nikmati berbagai pilihan menu terbaik dari Simpang Tiga
        </p>

        <!-- Breadcrumb -->
        <div class="mt-4 text-sm text-gray-500">
            <a href="/" class="hover:text-orange-500">Home</a>
            <span class="mx-2">/</span>
            <span class="text-white">Menu</span>
        </div>

    </div>
</section>

<!-- FILTER -->
<section class="bg-black px-6 py-6">
    <div class="max-w-7xl mx-auto flex flex-wrap gap-3">

        <button class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm">
            Semua
        </button>

        <button class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-500 transition">
            Sate Kambing
        </button>

        <button class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-500 transition">
            Sate Ayam
        </button>

        <button class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-500 transition">
            Paket Hemat
        </button>

    </div>
</section>

<!-- LIST MENU -->
@php
    $dummyMenus = [
        [
            'nama_menu' => 'Sate Kambing Bumbu Original',
            'harga' => 35000,
            'gambar' => 'https://source.unsplash.com/500x380/?satay',
            'deskripsi' => 'Sate kambing empuk dengan bumbu kacang khas Simpang Tiga yang gurih dan legit.',
            'kategori' => ['nama_kategori' => 'Sate Kambing'],
            'is_available' => true,
        ],
        [
            'nama_menu' => 'Sate Ayam Bumbu Kacang',
            'harga' => 26000,
            'gambar' => 'https://source.unsplash.com/500x380/?chicken-satay',
            'deskripsi' => 'Sate ayam spesial dengan saus kacang creamy dan aroma bakaran yang menggoda.',
            'kategori' => ['nama_kategori' => 'Sate Ayam'],
            'is_available' => true,
        ],
        [
            'nama_menu' => 'Gulai Kambing Istimewa',
            'harga' => 32000,
            'gambar' => 'https://source.unsplash.com/500x380/?gulai',
            'deskripsi' => 'Gulai kambing rempah pedas manis dengan santan kental, pas disantap bersama nasi hangat.',
            'kategori' => ['nama_kategori' => 'Gulai'],
            'is_available' => true,
        ],
        [
            'nama_menu' => 'Sop Kambing Segar',
            'harga' => 28000,
            'gambar' => 'https://source.unsplash.com/500x380/?soup',
            'deskripsi' => 'Sop kambing dengan kuah bening dan rempah yang ringan, cocok untuk segala suasana.',
            'kategori' => ['nama_kategori' => 'Sop'],
            'is_available' => false,
        ],
        [
            'nama_menu' => 'Nasi Kebuli Premium',
            'harga' => 42000,
            'gambar' => 'https://source.unsplash.com/500x380/?nasi-kebuli',
            'deskripsi' => 'Nasi kebuli wangi lengkap dengan ayam suwir, kismis, dan kacang mede.',
            'kategori' => ['nama_kategori' => 'Nasi'],
            'is_available' => true,
        ],
        [
            'nama_menu' => 'Paket Hemat Keluarga',
            'harga' => 95000,
            'gambar' => 'https://source.unsplash.com/500x380/?food-plate',
            'deskripsi' => 'Paket lengkap untuk keluarga, berisi sate, gulai, dan nasi hangat.',
            'kategori' => ['nama_kategori' => 'Paket Hemat'],
            'is_available' => true,
        ],
    ];

    $displayMenus = collect($menus)->isNotEmpty() ? collect($menus) : collect($dummyMenus);
@endphp

<section class="bg-black px-6 pb-24">
    <div class="max-w-7xl mx-auto">

        @if(collect($menus)->isEmpty())
            <div class="mb-8 rounded-3xl bg-orange-500/10 border border-orange-500/20 p-5 text-orange-50">
                <strong>Perhatian:</strong> Menu belum diisi dalam database. Menampilkan data contoh untuk demo.
            </div>
        @endif

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($displayMenus as $menu)
                @php
                    $image = data_get($menu, 'gambar') ?: 'https://source.unsplash.com/500x380/?indonesian-food';
                    $title = data_get($menu, 'nama_menu') ?: data_get($menu, 'nama') ?: 'Menu Spesial';
                    $price = data_get($menu, 'harga') ?: 0;
                    $category = data_get($menu, 'kategori.nama_kategori') ?: data_get($menu, 'kategori') ?: 'Menu Pilihan';
                    $description = data_get($menu, 'deskripsi') ?: 'Nikmati hidangan istimewa dari dapur Simpang Tiga.';
                    $available = data_get($menu, 'is_available', true);
                @endphp

                <div class="group bg-white rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition duration-300">
                    <div class="relative overflow-hidden">
                        <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-xs uppercase tracking-[0.25em] text-white/80">{{ $category }}</p>
                        </div>
                        <span class="absolute top-4 left-4 rounded-full bg-orange-500 text-white text-[11px] px-3 py-1 uppercase">
                            {{ $available ? 'Tersedia' : 'Habis' }}
                        </span>
                    </div>
                    <div class="p-5">
                        <h3 class="font-semibold text-xl text-slate-900 mb-2">{{ $title }}</h3>
                        <p class="text-sm text-slate-500 mb-4 leading-relaxed" style="min-height: 3rem;">{{ $description }}</p>

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-orange-500 font-bold text-lg">Rp {{ number_format($price, 0, ',', '.') }}</span>
                            <button class="inline-flex items-center rounded-full bg-slate-900 text-white px-4 py-2 text-sm font-semibold hover:bg-orange-500 transition">
                                Detail
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
