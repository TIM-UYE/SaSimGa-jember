@extends('frontend.layout.app')

@section('content')

<!-- HERO / HEADER -->
<section class="bg-black text-white pt-32 pb-16 px-6 border-b border-gray-800">

    <div class="max-w-7xl mx-auto">

        <h1 class="text-4xl font-bold mb-2">
            Semua <span class="text-orange-500">Menu</span>
        </h1>

        <p class="text-gray-400">
            Nikmati berbagai pilihan menu terbaik dari Simpang Tiga
        </p>

        <div class="mt-4 text-sm text-gray-500">

            <a href="/" class="hover:text-orange-500">
                Home
            </a>

            <span class="mx-2">/</span>

            <span class="text-white">
                Menu
            </span>

        </div>

    </div>

</section>



<!-- FILTER -->
<section class="bg-black px-6 py-6">

    <div class="max-w-7xl mx-auto flex flex-wrap gap-3">

        <button
            onclick="filterMenuByCategory(0)"
            class="px-4 py-2 rounded-lg text-sm kategori-btn text-white bg-orange-500"
            data-kategori-id="0"
        >
            Semua
        </button>

        @foreach($kategoris as $kat)

            <button
                onclick="filterMenuByCategory({{ $kat->id }})"
                class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-500 transition kategori-btn"
                data-kategori-id="{{ $kat->id }}"
            >
                {{ $kat->nama_kategori }} ({{ $kat->menus_count }})
            </button>

        @endforeach

    </div>

</section>



<!-- MENU -->
<section class="bg-black px-6 pb-24">

    <div class="max-w-7xl mx-auto">

        @if($menus->isEmpty())

            <div class="mb-8 rounded-3xl bg-orange-500/10 border border-orange-500/20 p-5 text-orange-50">

                <strong>Perhatian:</strong> Belum ada menu tersedia saat ini.

            </div>

        @endif



        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

            @foreach ($menus as $menu)

                <div
                    class="group bg-white rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition duration-300 menu-card"
                    data-kategori-id="{{ $menu->kategori_id ?? 0 }}"
                >

                    {{-- IMAGE --}}
                    <div class="relative overflow-hidden">

                        @if($menu->gambar)

                            <img
                                src="{{ asset('storage/menu/' . $menu->gambar) }}"
                                alt="{{ $menu->nama_menu }}"
                                class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-105"
                            >

                        @else

                            <div class="w-full h-56 bg-gray-200 flex items-center justify-center">

                                <i class="fas fa-utensils text-gray-500 text-3xl"></i>

                            </div>

                        @endif



                        {{-- CATEGORY --}}
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-4">

                            <p class="text-xs uppercase tracking-[0.25em] text-white/80">

                                {{ $menu->kategori->nama_kategori ?? 'Menu Pilihan' }}

                            </p>

                        </div>



                        {{-- STATUS --}}
                        <span class="absolute top-4 left-4 rounded-full bg-orange-500 text-white text-[11px] px-3 py-1 uppercase">

                            {{ $menu->is_available ? 'Tersedia' : 'Habis' }}

                        </span>

                    </div>



                    {{-- CONTENT --}}
                    <div class="p-5">

                        {{-- NAMA --}}
                        <h3 class="font-semibold text-xl text-slate-900 mb-2">

                            {{ $menu->nama_menu }}

                        </h3>



                        {{-- DESKRIPSI --}}
                        <p class="text-sm text-slate-500 mb-4 leading-relaxed min-h-[48px]">

                            {{ $menu->deskripsi ?? 'Tidak ada deskripsi' }}

                        </p>



                        {{-- HARGA --}}
                        <div class="flex items-center justify-between gap-3">

                            <span class="text-orange-500 font-bold text-lg">

                                Rp {{ number_format($menu->harga, 0, ',', '.') }}

                            </span>

                        </div>



                        {{-- BUTTON --}}
                        <div class="flex items-center gap-2 mt-4">

                            {{-- PESAN --}}
                            <form
                                action="{{ route('cart.add', $menu->id) }}"
                                method="POST"
                                class="flex-1"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="w-full inline-flex items-center justify-center rounded-full bg-orange-500 text-white px-4 py-2 text-sm font-semibold hover:bg-orange-600 transition-all duration-300 hover:scale-[1.02]"
                                >

                                    <i class="fas fa-cart-shopping mr-2"></i>

                                    Pesan

                                </button>

                            </form>



                            {{-- DETAIL --}}
                            <button
                                onclick='openMenuDetail(@json($menu))'
                                class="inline-flex items-center justify-center rounded-full bg-slate-900 text-white px-4 py-2 text-sm font-semibold hover:bg-slate-800 transition-all duration-300"
                            >

                                <i class="fas fa-eye mr-2"></i>

                                Detail

                            </button>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>



{{-- MODAL DETAIL --}}
<div
    id="menuDetailModal"
    class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4"
    onclick="closeMenuDetail(event)"
>

    <div
        class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto"
        onclick="event.stopPropagation()"
    >

        {{-- HEADER --}}
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">

            <h2 class="text-2xl font-bold text-gray-800">
                Detail Menu
            </h2>

            <button
                onclick="closeMenuDetail()"
                class="text-gray-500 hover:text-gray-700 text-2xl"
            >
                &times;
            </button>

        </div>



        {{-- BODY --}}
        <div class="p-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                {{-- IMAGE --}}
                <div>

                    <div class="bg-gray-200 rounded-xl overflow-hidden mb-4">

                        <img
                            id="modalImage"
                            src=""
                            alt="Menu"
                            class="w-full h-64 object-cover"
                        >

                    </div>

                </div>



                {{-- CONTENT --}}
                <div>

                    <div
                        id="modalCategory"
                        class="inline-block bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-semibold mb-4"
                    ></div>



                    <h1
                        id="modalMenuName"
                        class="text-3xl font-bold text-gray-800 mb-3"
                    ></h1>



                    <p
                        id="modalPrice"
                        class="text-3xl font-bold text-orange-500 mb-4"
                    ></p>



                    <div id="modalStatus" class="mb-4"></div>

                    <hr class="my-4">



                    {{-- DESKRIPSI --}}
                    <div class="mb-4">

                        <h3 class="font-bold text-gray-800 mb-2">
                            Deskripsi
                        </h3>

                        <p
                            id="modalDescription"
                            class="text-gray-600 leading-relaxed"
                        ></p>

                    </div>



                    {{-- BAHAN --}}
                    <div id="bahanSection" class="mb-4 hidden">

                        <h3 class="font-bold text-gray-800 mb-2">
                            Bahan Utama
                        </h3>

                        <p id="modalBahan" class="text-gray-600"></p>

                    </div>



                    {{-- INFO --}}
                    <div id="infoTambahanSection" class="grid grid-cols-2 gap-3 mb-4">

                        <div id="ukuranInfo" class="bg-gray-100 p-3 rounded-lg hidden">

                            <p class="text-xs text-gray-600">
                                Ukuran
                            </p>

                            <p id="modalUkuran" class="font-semibold text-gray-800"></p>

                        </div>



                        <div id="durasiInfo" class="bg-gray-100 p-3 rounded-lg hidden">

                            <p class="text-xs text-gray-600">
                                Durasi Persiapan
                            </p>

                            <p id="modalDurasi" class="font-semibold text-gray-800"></p>

                        </div>

                    </div>

                    <hr class="my-4">



                    {{-- BUTTON --}}
                    <div class="flex gap-3">

                        {{-- FORM CART --}}
                        <form id="modalCartForm" method="POST" class="flex-1">

                            @csrf

                            <button
                                type="submit"
                                id="modalOrderBtn"
                                class="w-full bg-orange-500 text-white py-3 rounded-xl font-bold hover:bg-orange-600 transition"
                            >

                                <i class="fas fa-shopping-cart mr-2"></i>

                                Tambah ke Keranjang

                            </button>

                        </form>



                        {{-- FAVORITE --}}
                        <button
                            class="px-4 py-3 border-2 border-orange-500 text-orange-500 rounded-xl font-bold hover:bg-orange-50 transition"
                        >

                            <i class="fas fa-heart"></i>

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



<script>

function filterMenuByCategory(categoryId) {

    document.querySelectorAll('.kategori-btn').forEach(btn => {

        btn.classList.remove('text-white', 'bg-orange-500');

        btn.classList.add('hover:text-white');

    });


    const activeBtn = document.querySelector(`.kategori-btn[data-kategori-id="${categoryId}"]`);

    if (activeBtn) {

        activeBtn.classList.add('text-white', 'bg-orange-500');

        activeBtn.classList.remove('hover:text-white');

    }


    const menuCards = document.querySelectorAll('.menu-card');


    menuCards.forEach(card => {

        const menuCategoryId = parseInt(card.getAttribute('data-kategori-id'));

        const filterCategoryId = parseInt(categoryId);


        if (filterCategoryId === 0 || menuCategoryId === filterCategoryId) {

            card.style.display = 'block';

        } else {

            card.style.display = 'none';

        }

    });

}



function openMenuDetail(menu) {

    // IMAGE
    const imagePath = menu.gambar
        ? `{{ asset('storage/menu/') }}/${menu.gambar}`
        : '';

    document.getElementById('modalImage').src =
        imagePath || '{{ asset('images/placeholder.jpg') }}';


    // TITLE
    document.getElementById('modalMenuName').textContent =
        menu.nama_menu;


    // CATEGORY
    document.getElementById('modalCategory').innerHTML =
        menu.kategori
            ? `<span>${menu.kategori.nama_kategori}</span>`
            : '';


    // PRICE
    const price = new Intl.NumberFormat(
        'id-ID',
        {
            style: 'currency',
            currency: 'IDR'
        }
    ).format(menu.harga);

    document.getElementById('modalPrice').textContent = price;


    // STATUS
    document.getElementById('modalStatus').innerHTML = menu.is_available

        ? `
            <div class="flex items-center gap-2">

                <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>

                <span class="text-green-700 font-semibold">
                    Tersedia
                </span>

            </div>
        `

        : `
            <div class="flex items-center gap-2">

                <span class="inline-block w-3 h-3 bg-red-500 rounded-full"></span>

                <span class="text-red-700 font-semibold">
                    Tidak Tersedia
                </span>

            </div>
        `;


    // DESCRIPTION
    document.getElementById('modalDescription').textContent =
        menu.deskripsi || 'Tidak ada deskripsi';


    // BAHAN
    if (menu.bahan) {

        document.getElementById('modalBahan').textContent = menu.bahan;

        document.getElementById('bahanSection').classList.remove('hidden');

    } else {

        document.getElementById('bahanSection').classList.add('hidden');

    }


    // UKURAN
    if (menu.ukuran) {

        document.getElementById('modalUkuran').textContent = menu.ukuran;

        document.getElementById('ukuranInfo').classList.remove('hidden');

    } else {

        document.getElementById('ukuranInfo').classList.add('hidden');

    }


    // DURASI
    if (menu.durasi_persiapan) {

        document.getElementById('modalDurasi').textContent =
            `${menu.durasi_persiapan} menit`;

        document.getElementById('durasiInfo').classList.remove('hidden');

    } else {

        document.getElementById('durasiInfo').classList.add('hidden');

    }


    // BUTTON
    const orderBtn = document.getElementById('modalOrderBtn');

    if (!menu.is_available) {

        orderBtn.disabled = true;

        orderBtn.classList.add('opacity-50', 'cursor-not-allowed');

    } else {

        orderBtn.disabled = false;

        orderBtn.classList.remove('opacity-50', 'cursor-not-allowed');

    }


    // ACTION CART
    document.getElementById('modalCartForm').action =
        `/cart/add/${menu.id}`;


    // OPEN MODAL
    document.getElementById('menuDetailModal').classList.remove('hidden');

    document.body.style.overflow = 'hidden';

}



function closeMenuDetail(event) {

    if (event && event.target.id !== 'menuDetailModal') return;

    document.getElementById('menuDetailModal').classList.add('hidden');

    document.body.style.overflow = 'auto';

}



document.addEventListener('keydown', function(event) {

    if (event.key === 'Escape') {

        closeMenuDetail();

    }

});



document.addEventListener('DOMContentLoaded', function() {

    const firstBtn = document.querySelector('.kategori-btn');

    if (firstBtn) {

        firstBtn.classList.add('text-white', 'bg-orange-500');

        firstBtn.classList.remove('hover:text-white');

    }

});

</script>

@endsection
