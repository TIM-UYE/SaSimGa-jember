@extends('frontend.layout.app')

@section('content')
    <!-- HERO / HEADER -->
    <section class="relative bg-gradient-to-br from-black via-gray-900 to-black text-white pt-40 pb-24 px-6 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-64 h-64 bg-orange-500 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-orange-600 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto relative z-10 text-center">
            <span
                class="inline-block px-4 py-2 bg-orange-500/20 border border-orange-500/30 rounded-full text-orange-400 text-sm font-semibold mb-6">
                <i class="fas fa-fire mr-2"></i>Hot Menu
            </span>

            <h1 class="text-5xl md:text-6xl font-bold mb-6">
                Semua <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Menu</span>
            </h1>

            <p class="text-xl text-gray-400 max-w-2xl mx-auto mb-8">
                Nikmati berbagai pilihan menu terbaik dari Simpang Tiga, dibuat dengan bahan berkualitas dan penuh cinta
            </p>

            <div class="flex flex-wrap justify-center gap-4">

                {{-- HOME --}}
                <a href="{{ route('frontend.home') }}"
                    class="border-2 border-gray-600 hover:border-orange-500 text-white px-8 py-3 rounded-full font-semibold transition-all">
                    <i class="fas fa-home mr-2"></i>Home
                </a>

                {{-- MENU REGULER --}}
                <button onclick="showMenuSection('regular')" id="regularBtn"
                    class="menu-switch-btn bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-full font-semibold transition-all hover:scale-105">
                    <i class="fas fa-utensils mr-2"></i>Menu Reguler
                </button>

                {{-- MENU SPESIAL --}}
                <button onclick="showMenuSection('special')" id="specialBtn"
                    class="menu-switch-btn border-2 border-gray-600 hover:border-orange-500 text-white px-8 py-3 rounded-full font-semibold transition-all">
                    <i class="fas fa-star mr-2"></i>Menu Spesial
                </button>

            </div>
        </div>
    </section>

    <!-- SEARCH & FILTER -->
    <section class="bg-black/50 backdrop-blur-sm border-y border-gray-800 px-6 py-6 sticky top-16 z-30">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                <!-- Search -->
                <div class="relative w-full lg:w-96">
                    <input type="text" id="searchInput" placeholder="Cari menu..."
                        class="w-full bg-gray-800 border border-gray-700 rounded-full px-5 py-3 pl-12 text-white focus:outline-none focus:border-orange-500 transition-all">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                </div>

                <!-- Category Filters -->
                <div class="flex flex-wrap gap-2 justify-center">
                    <button onclick="filterMenuByCategory(0)"
                        class="px-5 py-2.5 rounded-full text-sm font-semibold kategori-btn text-white bg-orange-500 hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/25"
                        data-kategori-id="0">
                        <i class="fas fa-th mr-2"></i>Semua
                    </button>

                    @foreach ($kategoris as $kat)
                        <button onclick="filterMenuByCategory({{ $kat->id }})"
                            class="px-5 py-2.5 rounded-full text-sm font-semibold kategori-btn bg-gray-800 text-gray-300 hover:bg-orange-500 hover:text-white transition-all"
                            data-kategori-id="{{ $kat->id }}">
                            {{ $kat->nama_kategori }}
                            <span class="ml-2 text-xs opacity-70">({{ $kat->menus_count }})</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- REGULAR MENU SECTION -->
    <section id="regularMenuSection" class="bg-black px-6 pb-32">
        <div class="max-w-7xl mx-auto mt-16">

            @if ($menus->isEmpty())
                <div class="text-center py-20">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gray-800 mb-6">
                        <i class="fas fa-utensils text-4xl text-gray-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-400 mb-2">Belum Ada Menu</h3>
                    <p class="text-gray-500">Menu akan segera tersedia</p>
                </div>
            @endif

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($menus as $menu)
                    <div class="group bg-gradient-to-b from-gray-900 to-gray-950 rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl hover:shadow-orange-500/10 transition-all duration-500 menu-card border border-gray-800 hover:border-orange-500/30"
                        data-kategori-id="{{ $menu->kategori_id ?? 0 }}">
                        <!-- IMAGE -->
                        <div class="relative overflow-hidden h-56">
                            @if ($menu->gambar)
                                <img src="{{ asset('storage/menu/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                                    <i class="fas fa-utensils text-gray-600 text-5xl"></i>
                                </div>
                            @endif

                            <!-- Overlay on hover -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>

                            <!-- Category Badge -->
                            <div class="absolute top-4 left-4">
                                <span
                                    class="px-3 py-1 bg-black/60 backdrop-blur-sm rounded-full text-xs text-white font-semibold">
                                    {{ $menu->kategori->nama_kategori ?? 'Menu' }}
                                </span>
                            </div>

                            <!-- Availability Badge -->
                            <div class="absolute top-4 right-4">
                                @if ($menu->is_available)
                                    <span
                                        class="px-3 py-1 bg-green-500/90 backdrop-blur-sm rounded-full text-xs text-white font-semibold flex items-center gap-1">
                                        <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                        Tersedia
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1 bg-red-500/90 backdrop-blur-sm rounded-full text-xs text-white font-semibold">
                                        Habis
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- CONTENT -->
                        <div class="p-5">
                            <h3
                                class="font-bold text-xl text-white mb-2 line-clamp-1 group-hover:text-orange-400 transition-colors">
                                {{ $menu->nama_menu }}
                            </h3>

                            <p class="text-sm text-gray-400 mb-4 line-clamp-2 min-h-[40px]">
                                {{ $menu->deskripsi ?? 'Tidak ada deskripsi' }}
                            </p>

                            <!-- Price & Actions -->
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <span class="text-2xl font-bold text-orange-400">
                                        Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="flex gap-2">
                                    <!-- Quick Add Button -->
                                    <button type="button" onclick="quickAddToCart({{ $menu->id }})"
                                        class="w-12 h-12 rounded-full bg-orange-500 hover:bg-orange-600 text-white flex items-center justify-center transition-all hover:scale-110 disabled:opacity-50 disabled:cursor-not-allowed"
                                        {{ !$menu->is_available ? 'disabled' : '' }} title="Tambah ke keranjang">
                                        <i class="fas fa-plus"></i>
                                    </button>

                                    <!-- Detail Button -->
                                    <button onclick='openMenuDetail(@json($menu))'
                                        class="w-12 h-12 rounded-full bg-gray-800 hover:bg-gray-700 text-white flex items-center justify-center transition-all hover:scale-110"
                                        title="Lihat detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- No Results Message -->
            <div id="noResults" class="hidden text-center py-20">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gray-800 mb-6">
                    <i class="fas fa-search text-4xl text-gray-600"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-400 mb-2">Menu Tidak Ditemukan</h3>
                <p class="text-gray-500">Coba dengan kata kunci lain</p>
            </div>
        </div>
    </section>

    <!-- SPECIAL MENU SECTION -->
    <section id="specialMenuSection" class="bg-black px-6 pb-32 hidden">
        <div class="max-w-7xl mx-auto mt-16">

            @if($specials->isEmpty())
                <div class="rounded-3xl border border-orange-500 bg-orange-950/10 p-10 text-center text-orange-200">
                    <p class="text-lg font-semibold">Belum ada menu specials aktif.</p>
                    <p class="mt-2 text-sm text-orange-300">Tambah menu specials di panel admin untuk menampilkan paket spesial di halaman ini.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                    @foreach($specials as $special)
                        <div onclick="openSpecialModal({{ $special->id }})"
                            class="group relative overflow-hidden rounded-3xl h-[420px] cursor-pointer border border-gray-800 hover:border-orange-500/40 transition-all duration-500">

                            <img src="{{ $special->banner_image ? asset('storage/' . $special->banner_image) : asset('images/menu-special/tumpeng.jpg') }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/30 to-transparent"></div>

                            <div class="absolute top-5 left-5">
                                <span class="px-4 py-2 rounded-full bg-orange-500 text-white text-xs font-bold shadow-lg shadow-orange-500/30">SPECIAL</span>
                            </div>

                            <div class="absolute bottom-0 left-0 p-8 w-full">
                                <h3 class="text-3xl font-bold text-white mb-3">{{ $special->title }}</h3>
                                <p class="text-gray-300 mb-5">{{ Str::limit($special->short_description, 120) }}</p>
                                <div class="inline-flex items-center gap-3 text-orange-400 font-semibold group-hover:gap-5 transition-all">
                                    <span>Lihat Detail</span>
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- REGULAR MENU MODAL -->
    <div id="menuDetailModal"
        class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4"
        onclick="closeMenuDetail(event)">
        <div class="bg-gradient-to-b from-gray-900 to-gray-950 rounded-3xl max-w-3xl w-full max-h-[90vh] overflow-y-auto border border-gray-800 shadow-2xl"
            onclick="event.stopPropagation()">
            <!-- HEADER -->
            <div
                class="sticky top-0 bg-gray-900/95 backdrop-blur-sm border-b border-gray-800 px-6 py-4 flex items-center justify-between z-10">
                <h2 class="text-2xl font-bold text-white">
                    <i class="fas fa-info-circle mr-2 text-orange-500"></i>
                    Detail Menu
                </h2>
                <button onclick="closeMenuDetail()"
                    class="w-11 h-11 rounded-full bg-gray-800 hover:bg-red-500/80 text-white flex items-center justify-center transition-all duration-300 hover:rotate-90">

                    <i class="fas fa-times text-lg"></i>

                </button>
            </div>

            <!-- BODY -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- IMAGE -->
                    <div>
                        <div class="rounded-2xl overflow-hidden mb-4">
                            <img id="modalImage" src="" alt="Menu" class="w-full h-72 object-cover">
                        </div>
                    </div>

                    <!-- CONTENT -->
                    <div class="text-white">
                        <div id="modalCategory"
                            class="inline-block bg-orange-500/20 text-orange-400 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                        </div>

                        <h1 id="modalMenuName" class="text-3xl font-bold text-white mb-3"></h1>

                        <p id="modalPrice" class="text-3xl font-bold text-orange-400 mb-4"></p>

                        <div id="modalStatus" class="mb-4"></div>

                        <hr class="border-gray-700 my-4">

                        <!-- DESCRIPTION -->
                        <div class="mb-4">
                            <h3 class="font-bold text-white mb-2 flex items-center">
                                <i class="fas fa-align-left mr-2 text-orange-500"></i>
                                Deskripsi
                            </h3>
                            <p id="modalDescription" class="text-gray-400 leading-relaxed"></p>
                        </div>

                        <!-- BAHAN -->
                        <div id="bahanSection" class="mb-4 hidden">
                            <h3 class="font-bold text-white mb-2 flex items-center">
                                <i class="fas fa-leaf mr-2 text-green-500"></i>
                                Bahan Utama
                            </h3>
                            <p id="modalBahan" class="text-gray-400"></p>
                        </div>

                        <!-- INFO -->
                        <div id="infoTambahanSection" class="grid grid-cols-2 gap-3 mb-4">
                            <div id="ukuranInfo" class="bg-gray-800 p-3 rounded-xl hidden">
                                <p class="text-xs text-gray-500">Ukuran</p>
                                <p id="modalUkuran" class="font-semibold text-white"></p>
                            </div>

                            <div id="durasiInfo" class="bg-gray-800 p-3 rounded-xl hidden">
                                <p class="text-xs text-gray-500">Durasi Persiapan</p>
                                <p id="modalDurasi" class="font-semibold text-white"></p>
                            </div>
                        </div>

                        <!-- QUANTITY SELECTOR -->
                        <div class="mb-6">
                            <label class="font-bold text-white mb-3 block">Quantity:</label>
                            <div class="flex items-center gap-4">
                                <button type="button" onclick="decreaseModalQty()"
                                    class="w-12 h-12 rounded-full bg-gray-800 hover:bg-gray-700 text-white flex items-center justify-center text-xl font-bold transition-all">
                                    -
                                </button>
                                <input type="number" id="modalQtyInput" value="1" min="1" max="99"
                                    class="w-24 text-center bg-gray-800 border border-gray-700 rounded-xl py-3 text-white font-bold text-lg">
                                <button type="button" onclick="increaseModalQty()"
                                    class="w-12 h-12 rounded-full bg-gray-800 hover:bg-gray-700 text-white flex items-center justify-center text-xl font-bold transition-all">
                                    +
                                </button>
                            </div>
                        </div>

                        <!-- ACTION BUTTON -->
                        <button type="button" id="modalOrderBtn" onclick="addToCartFromModal()"
                            class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-4 rounded-xl font-bold transition-all hover:scale-[1.02] flex items-center justify-center gap-2">
                            <i class="fas fa-shopping-cart"></i>
                            Tambah ke Keranjang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SPECIAL MENU MODAL -->
    <div id="specialMenuModal" onclick="closeSpecialModal(event)"
        class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">

        <div class="bg-gradient-to-b from-gray-900 to-black rounded-3xl w-full max-w-6xl border border-gray-800 overflow-hidden">

            <div class="sticky top-0 z-20 bg-gray-900/95 backdrop-blur-sm border-b border-gray-800 px-6 py-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white flex items-center gap-3"><i class="fas fa-star text-orange-500"></i> Detail Menu Special</h2>
                    <p class="text-sm text-gray-400 mt-1">Pilih varian paket special untuk melihat detail dan harga.</p>
                </div>
                <button onclick="closeSpecialModal()" class="w-11 h-11 rounded-full bg-gray-800 hover:bg-red-500/80 text-white flex items-center justify-center transition-all hover:rotate-90"><i class="fas fa-times text-lg"></i></button>
            </div>

            <div class="grid md:grid-cols-2">
                <div class="border-r border-gray-800 p-6">
                    <h2 class="text-2xl font-bold text-white mb-6">Pilih Varian</h2>
                    <div id="specialItemButtons" class="space-y-4"></div>
                </div>

                <div class="p-8 text-white">
                    <div class="rounded-3xl overflow-hidden mb-6">
                        <img id="specialImage" src="" alt="Special" class="w-full h-64 object-cover">
                    </div>
                    <h3 id="specialTitle" class="text-3xl font-bold mb-3"></h3>
                    <p id="specialPrice" class="text-orange-400 text-2xl font-bold mb-5"></p>
                    <p id="specialDescription" class="text-gray-400 leading-relaxed mb-8"></p>
                    <button class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 py-4 rounded-2xl font-bold transition-all hover:scale-[1.02]">Pesan Sekarang</button>
                </div>
            </div>
        </div>
    </div>

    <!-- FLOATING CHECKOUT BUTTON -->
<div id="floatingCheckout"
    class="hidden fixed bottom-5 right-5 z-40">

    <a href="{{ route('checkout.index') }}"
        class="group flex items-center gap-3
        bg-gradient-to-r from-orange-500 to-orange-600
        hover:from-orange-600 hover:to-orange-700
        text-white px-4 py-3 rounded-2xl
        shadow-2xl shadow-orange-500/30
        transition-all duration-300 hover:scale-105">

        {{-- ICON --}}
        <div
            class="w-10 h-10 rounded-xl
            bg-white/10 border border-white/10
            flex items-center justify-center shrink-0">

            <i class="fas fa-shopping-cart text-base text-white"></i>

        </div>

        {{-- TOTAL --}}
        <div class="leading-tight">

            <p class="text-[10px] text-white/80 font-medium">
                Total
            </p>

            <p id="floatingTotal"
                class="text-lg font-bold text-white">

                Rp 0

            </p>

        </div>

        {{-- CHECKOUT --}}
        <div class="flex items-center gap-1 ml-1 shrink-0">

            <span class="font-semibold text-sm text-white">
                Checkout
            </span>

            <i class="fas fa-arrow-right text-sm text-white"></i>

        </div>

    </a>

</div>

    <script>
        // Store current modal menu ID
        let currentModalMenuId = null;

        // Search functionality
        document.getElementById('searchInput')?.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const menuCards = document.querySelectorAll('.menu-card');
            let hasResults = false;

            menuCards.forEach(card => {
                const menuName = card.querySelector('h3').textContent.toLowerCase();
                const menuDesc = card.querySelector('p').textContent.toLowerCase();

                if (menuName.includes(searchTerm) || menuDesc.includes(searchTerm)) {
                    card.style.display = 'block';
                    hasResults = true;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide no results message
            const noResults = document.getElementById('noResults');
            if (noResults) {
                noResults.classList.toggle('hidden', hasResults || !searchTerm);
            }
        });

        function filterMenuByCategory(categoryId) {
            // Update button styles
            document.querySelectorAll('.kategori-btn').forEach(btn => {
                if (parseInt(btn.dataset.kategoriId) === parseInt(categoryId)) {
                    btn.classList.remove('bg-gray-800', 'text-gray-300');
                    btn.classList.add('text-white', 'bg-orange-500', 'shadow-lg', 'shadow-orange-500/25');
                } else {
                    btn.classList.add('bg-gray-800', 'text-gray-300');
                    btn.classList.remove('text-white', 'bg-orange-500', 'shadow-lg', 'shadow-orange-500/25');
                }
            });

            const menuCards = document.querySelectorAll('.menu-card');

            menuCards.forEach(card => {
                const menuCategoryId = parseInt(card.getAttribute('data-kategori-id'));
                const filterCategoryId = parseInt(categoryId);

                if (filterCategoryId === 0 || menuCategoryId === filterCategoryId) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeIn 0.3s ease-in-out';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Quick add to cart (direct add without showing quantity selector)
        function quickAddToCart(menuId) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/cart/add/' + menuId;

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';

            const qtyInput = document.createElement('input');
            qtyInput.type = 'hidden';
            qtyInput.name = 'qty';
            qtyInput.value = '1';

            form.appendChild(csrfInput);
            form.appendChild(qtyInput);
            document.body.appendChild(form);
            form.submit();
        }

        function openMenuDetail(menu) {
            currentModalMenuId = menu.id;

            // Reset modal quantity
            document.getElementById('modalQtyInput').value = 1;

            // IMAGE
            const imagePath = menu.gambar ?
                `{{ asset('storage/menu/') }}/${menu.gambar}` :
                '';

            document.getElementById('modalImage').src =
                imagePath || '{{ asset('images/placeholder.jpg') }}';

            // TITLE
            document.getElementById('modalMenuName').textContent =
                menu.nama_menu;

            // CATEGORY
            document.getElementById('modalCategory').innerHTML =
                menu.kategori ?
                `<span>${menu.kategori.nama_kategori}</span>` :
                '<span>Menu Pilihan</span>';

            // PRICE
            const price = new Intl.NumberFormat(
                'id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }
            ).format(menu.harga);

            document.getElementById('modalPrice').textContent = price;

            // STATUS
            document.getElementById('modalStatus').innerHTML = menu.is_available ?
                `
            <div class="flex items-center gap-2">
                <span class="inline-block w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
                <span class="text-green-400 font-semibold">Tersedia</span>
            </div>
        ` :
                `
            <div class="flex items-center gap-2">
                <span class="inline-block w-3 h-3 bg-red-500 rounded-full"></span>
                <span class="text-red-400 font-semibold">Tidak Tersedia</span>
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

            // OPEN MODAL
            document.getElementById('menuDetailModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Modal quantity controls
        function increaseModalQty() {
            const input = document.getElementById('modalQtyInput');
            let value = parseInt(input.value) || 1;
            if (value < 99) {
                input.value = value + 1;
            }
        }

        function decreaseModalQty() {
            const input = document.getElementById('modalQtyInput');
            let value = parseInt(input.value) || 1;
            if (value > 1) {
                input.value = value - 1;
            }
        }

        // Add to cart from modal
        function addToCartFromModal() {
            if (!currentModalMenuId) return;

            const qty = document.getElementById('modalQtyInput').value;

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/cart/add/' + currentModalMenuId;

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';

            const qtyInput = document.createElement('input');
            qtyInput.type = 'hidden';
            qtyInput.name = 'qty';
            qtyInput.value = qty;

            form.appendChild(csrfInput);
            form.appendChild(qtyInput);
            document.body.appendChild(form);
            form.submit();
        }

        function closeMenuDetail(event) {
            if (event && event.target.id !== 'menuDetailModal') return;

            document.getElementById('menuDetailModal').classList.add('hidden');
            document.body.style.overflow = 'auto';

            currentModalMenuId = null;
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeMenuDetail();
            }
        });

        // Floating checkout button
        function updateFloatingCheckout() {
            fetch('{{ route('cart.count') }}')
                .then(response => response.json())
                .then(data => {
                    const floatingCheckout = document.getElementById('floatingCheckout');
                    const floatingTotal = document.getElementById('floatingTotal');

                    if (data.count > 0) {
                        floatingCheckout.classList.remove('hidden');
                        floatingTotal.textContent = data.total_formatted;
                    } else {
                        floatingCheckout.classList.add('hidden');
                    }
                })
                .catch(() => {
                    document.getElementById('floatingCheckout').classList.add('hidden');
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Set initial active category button
            const firstBtn = document.querySelector('.kategori-btn');
            if (firstBtn) {
                firstBtn.classList.add('text-white', 'bg-orange-500', 'shadow-lg', 'shadow-orange-500/25');
                firstBtn.classList.remove('bg-gray-800', 'text-gray-300');
            }

            // Initialize floating checkout
            updateFloatingCheckout();
        });

        // Re-check floating checkout when page regains focus
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                updateFloatingCheckout();
            }
        });

        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        function showMenuSection(type) {

            const regular = document.getElementById('regularMenuSection');
            const special = document.getElementById('specialMenuSection');

            const regularBtn = document.getElementById('regularBtn');
            const specialBtn = document.getElementById('specialBtn');

            if (type === 'regular') {

                regular.classList.remove('hidden');
                special.classList.add('hidden');

                regularBtn.classList.add('bg-orange-500');
                specialBtn.classList.remove('bg-orange-500');

            } else {

                regular.classList.add('hidden');
                special.classList.remove('hidden');

                specialBtn.classList.add('bg-orange-500');
                regularBtn.classList.remove('bg-orange-500');

            }

            window.scrollTo({
                top: document.getElementById(type === 'regular' ?
                    'regularMenuSection' :
                    'specialMenuSection').offsetTop - 100,
                behavior: 'smooth'
            });
        }

        const specialData = [
            @forelse($specials as $special)
            {
                id: {{ $special->id }},
                title: {!! json_encode($special->title) !!},
                description: {!! json_encode($special->short_description) !!},
                banner_image: {!! json_encode($special->banner_image ? asset('storage/' . $special->banner_image) : asset('images/menu-special/tumpeng.jpg')) !!},
                items: [
                    @foreach($special->items as $item)
                    {
                        id: {{ $item->id }},
                        name: {!! json_encode($item->name) !!},
                        price: {!! json_encode(number_format($item->price, 0, ',', '.')) !!},
                        raw_price: {{ $item->price }},
                        description: {!! json_encode($item->description) !!},
                        image: {!! json_encode($item->image ? asset('storage/' . $item->image) : asset('images/menu-special/tumpeng.jpg')) !!}
                    }@if(!$loop->last),@endif
                    @endforeach
                ]
            }@if(!$loop->last),@endif
            @empty
            @endforelse
        ];

        function openSpecialModal(id) {
            const special = specialData.find(item => item.id === id);
            if (!special) {
                return;
            }

            const actions = document.getElementById('specialItemButtons');
            actions.innerHTML = '';

            special.items.forEach((item, index) => {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'special-item-btn w-full text-left bg-gray-800 hover:bg-orange-500 p-5 rounded-2xl transition-all text-white';
                button.textContent = item.name;
                button.addEventListener('click', () => selectSpecialItem(special, item));
                actions.appendChild(button);
            });

            selectSpecialItem(special, special.items[0] || null);
            document.getElementById('specialMenuModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSpecialModal(event) {
            if (event && event.target.id !== 'specialMenuModal') return;
            document.getElementById('specialMenuModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function selectSpecialItem(special, item) {
            if (!item) {
                document.getElementById('specialTitle').textContent = special.title;
                document.getElementById('specialPrice').textContent = 'Harga tidak tersedia';
                document.getElementById('specialDescription').textContent = special.description || '';
                document.getElementById('specialImage').src = special.banner_image;
                return;
            }

            document.getElementById('specialTitle').textContent = item.name;
            document.getElementById('specialPrice').textContent = `Rp ${item.price}`;
            document.getElementById('specialDescription').textContent = item.description || special.description || '';
            document.getElementById('specialImage').src = item.image || special.banner_image;
        }
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1a1a1a;
        }

        ::-webkit-scrollbar-thumb {
            background: #f97316;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #ea580c;
        }
    </style>
@endsection
