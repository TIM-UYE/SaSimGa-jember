<section class="relative bg-black py-24 overflow-hidden">

    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 left-10 w-64 h-64 bg-orange-500 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-orange-600 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 container-main">
        {{-- HEADER --}}
        <div class="text-center mb-12 reveal">
            <span class="inline-block px-4 py-2 bg-orange-500/20 border border-orange-500/30 rounded-full text-orange-400 text-sm font-semibold mb-6">
                <i class="fas fa-fire mr-2"></i>Hot Menu
            </span>

            <h2 class="text-5xl font-bold mb-4">
                <span class="text-white">Semua</span>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Menu</span>
            </h2>

            <p class="text-xl text-gray-400 max-w-2xl mx-auto">
                Nikmati berbagai pilihan menu terbaik dari Simpang Tiga
            </p>

            <div class="mt-8">
                <a href="{{ route('frontend.menu') }}" class="inline-flex items-center bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-full font-semibold transition-all hover:scale-105">
                    <i class="fas fa-utensils mr-2"></i>Lihat Semua Menu
                </a>
            </div>
        </div>

        {{-- CATEGORY FILTERS --}}
        <div class="flex flex-wrap gap-3 justify-center mb-10 reveal delay-200">
            <button onclick="filterMenuByCategory(0)"
               class="px-5 py-2.5 rounded-full text-sm font-semibold kategori-btn text-white bg-orange-500 hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/25"
               data-kategori-id="0">
                <i class="fas fa-th mr-2"></i>Semua
            </button>

            @foreach($kategoris as $kat)
                <button onclick="filterMenuByCategory({{ $kat->id }})"
                   class="px-5 py-2.5 rounded-full text-sm font-semibold kategori-btn bg-gray-800 text-gray-300 hover:bg-orange-500 hover:text-white transition-all"
                   data-kategori-id="{{ $kat->id }}">
                    {{ $kat->nama_kategori }}
                    <span class="ml-2 text-xs opacity-70">({{ $kat->menus_count }})</span>
                </button>
            @endforeach
        </div>

        {{-- GRID MENU --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($menus as $menu)
<<<<<<< Updated upstream
                <div class="group bg-gradient-to-b from-gray-900 to-gray-950 rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl hover:shadow-orange-500/10 transition-all duration-500 menu-card border border-gray-800 hover:border-orange-500/30 reveal"
                     style="--delay: {{ $loop->index * 0.1 }}s"
                     data-kategori-id="{{ $menu->kategori_id }}">
=======
            
            <div class="bg-white rounded-xl overflow-hidden shadow-lg 
            hover:shadow-[0_10px_30px_rgba(235,129,50,0.3)] 
            transition transform hover:scale-105 hover:-translate-y-2 
            menu-card reveal

            {{ $loop->index >= 4 ? 'hidden md:block' : '' }}
            {{ $loop->index >= 8 ? 'md:hidden extra-menu' : '' }}"
            
            style="--delay: {{ $loop->index * 0.1 }}s"
            data-kategori-id="{{ $menu->kategori_id }}">
>>>>>>> Stashed changes

                    <!-- IMAGE -->
                    <div class="relative overflow-hidden h-56">
                        @if($menu->gambar)
                            <img src="{{ asset('storage/menu/' . $menu->gambar) }}"
                                 alt="{{ $menu->nama_menu }}"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                                <i class="fas fa-utensils text-gray-600 text-5xl"></i>
                            </div>
                        @endif

                        <!-- Overlay on hover -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        <!-- Category Badge -->
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-black/60 backdrop-blur-sm rounded-full text-xs text-white font-semibold">
                                {{ $menu->kategori->nama_kategori ?? 'Menu' }}
                            </span>
                        </div>

                        <!-- Availability Badge -->
                        <div class="absolute top-4 right-4">
                            @if($menu->is_available)
                                <span class="px-3 py-1 bg-green-500/90 backdrop-blur-sm rounded-full text-xs text-white font-semibold flex items-center gap-1">
                                    <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                    Tersedia
                                </span>
                            @else
                                <span class="px-3 py-1 bg-red-500/90 backdrop-blur-sm rounded-full text-xs text-white font-semibold">
                                    Habis
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- CONTENT -->
                    <div class="p-5">
                        <h3 class="font-bold text-xl text-white mb-2 line-clamp-1 group-hover:text-orange-400 transition-colors">
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
                                <button
                                    type="button"
                                    onclick="quickAddToCart({{ $menu->id }})"
                                    class="w-12 h-12 rounded-full bg-orange-500 hover:bg-orange-600 text-white flex items-center justify-center transition-all hover:scale-110 disabled:opacity-50 disabled:cursor-not-allowed"
                                    {{ !$menu->is_available ? 'disabled' : '' }}
                                    title="Tambah ke keranjang"
                                >
                                    <i class="fas fa-plus"></i>
                                </button>

                                <!-- Detail Button -->
                                <button
                                    onclick='openMenuDetail(@json($menu))'
                                    class="w-12 h-12 rounded-full bg-gray-800 hover:bg-gray-700 text-white flex items-center justify-center transition-all hover:scale-110"
                                    title="Lihat detail"
                                >
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 menu-empty-state" style="display: none;">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gray-800 mb-6">
                        <i class="fas fa-utensils text-4xl text-gray-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-400 mb-2">Belum Ada Menu</h3>
                    <p class="text-gray-500">Menu akan segera tersedia</p>
                </div>
            @endforelse
        </div>
<<<<<<< Updated upstream
=======

        @if($menus->count() > 8)
        <div class="text-center mt-10 reveal delay-400">
            <a href="{{ route('frontend.menu') }}"
   class="inline-block text-[var(--color-primary)] font-semibold hover:underline transition">
    Lihat Selengkapnya
</a>

</div>
@endif

>>>>>>> Stashed changes
    </div>

    {{-- SHAPE BAWAH --}}
    <div class="absolute bottom-0 left-0 w-full h-[150px] bg-black"
         style="clip-path: ellipse(70% 100% at 50% 100%);">
    </div>

    {{-- MODAL DETAIL MENU --}}
    <div id="menuDetailModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4" onclick="closeMenuDetail(event)">
        <div class="bg-gradient-to-b from-gray-900 to-gray-950 rounded-3xl max-w-3xl w-full max-h-[90vh] overflow-y-auto border border-gray-800 shadow-2xl" onclick="event.stopPropagation()">
            {{-- HEADER --}}
            <div class="sticky top-0 bg-gray-900/95 backdrop-blur-sm border-b border-gray-800 px-6 py-4 flex items-center justify-between z-10">
                <h2 class="text-2xl font-bold text-white">
                    <i class="fas fa-info-circle mr-2 text-orange-500"></i>
                    Detail Menu
                </h2>
                <button onclick="closeMenuDetail()" class="w-10 h-10 rounded-full bg-gray-800 hover:bg-gray-700 text-white flex items-center justify-center transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- BODY --}}
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- IMAGE --}}
                    <div>
                        <div class="rounded-2xl overflow-hidden mb-4">
                            <img id="modalImage" src="" alt="Menu" class="w-full h-72 object-cover">
                        </div>
                    </div>

                    {{-- CONTENT --}}
                    <div class="text-white">
                        <div id="modalCategory" class="inline-block bg-orange-500/20 text-orange-400 px-4 py-2 rounded-full text-sm font-semibold mb-4"></div>

                        <h1 id="modalMenuName" class="text-3xl font-bold text-white mb-3"></h1>

                        <p id="modalPrice" class="text-3xl font-bold text-orange-400 mb-4"></p>

                        <div id="modalStatus" class="mb-4"></div>

                        <hr class="border-gray-700 my-4">

                        {{-- DESCRIPTION --}}
                        <div class="mb-4">
                            <h3 class="font-bold text-white mb-2 flex items-center">
                                <i class="fas fa-align-left mr-2 text-orange-500"></i>
                                Deskripsi
                            </h3>
                            <p id="modalDescription" class="text-gray-400 leading-relaxed"></p>
                        </div>

                        {{-- BAHAN --}}
                        <div id="bahanSection" class="mb-4 hidden">
                            <h3 class="font-bold text-white mb-2 flex items-center">
                                <i class="fas fa-leaf mr-2 text-green-500"></i>
                                Bahan Utama
                            </h3>
                            <p id="modalBahan" class="text-gray-400"></p>
                        </div>

                        {{-- INFO --}}
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

                        {{-- QUANTITY SELECTOR --}}
                        <div class="mb-6">
                            <label class="font-bold text-white mb-3 block">Quantity:</label>
                            <div class="flex items-center gap-4">
                                <button type="button" onclick="decreaseModalQty()" class="w-12 h-12 rounded-full bg-gray-800 hover:bg-gray-700 text-white flex items-center justify-center text-xl font-bold transition-all">
                                    -
                                </button>
                                <input type="number" id="modalQtyInput" value="1" min="1" max="99" class="w-24 text-center bg-gray-800 border border-gray-700 rounded-xl py-3 text-white font-bold text-lg">
                                <button type="button" onclick="increaseModalQty()" class="w-12 h-12 rounded-full bg-gray-800 hover:bg-gray-700 text-white flex items-center justify-center text-xl font-bold transition-all">
                                    +
                                </button>
                            </div>
                        </div>

                        {{-- ACTION BUTTON --}}
                        <button type="button" id="modalOrderBtn" onclick="addToCartFromModal()" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-4 rounded-xl font-bold transition-all hover:scale-[1.02] flex items-center justify-center gap-2">
                            <i class="fas fa-shopping-cart"></i>
                            Tambah ke Keranjang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Filter by category
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
        let visibleCount = 0;

        menuCards.forEach(card => {
            const menuCategoryId = parseInt(card.getAttribute('data-kategori-id'));
            const filterCategoryId = parseInt(categoryId);

            if (filterCategoryId === 0 || menuCategoryId === filterCategoryId) {
                card.style.display = 'block';
                card.style.animation = 'fadeIn 0.3s ease-in-out';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide empty state
        const emptyState = document.querySelector('.menu-empty-state');
        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    // Quick add to cart
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

    // Open menu detail modal
    function openMenuDetail(menu) {
        // Reset quantity
        document.getElementById('modalQtyInput').value = 1;

        // Set image
        const imagePath = menu.gambar ? `{{ asset('storage/menu/') }}/${menu.gambar}` : '';
        document.getElementById('modalImage').src = imagePath || '{{ asset('images/placeholder.jpg') }}';

        // Set title
        document.getElementById('modalMenuName').textContent = menu.nama_menu;

        // Set category
        const categoryHtml = menu.kategori ? `<span>${menu.kategori.nama_kategori}</span>` : '<span>Menu Pilihan</span>';
        document.getElementById('modalCategory').innerHTML = categoryHtml;

        // Set price
        const price = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(menu.harga);
        document.getElementById('modalPrice').textContent = price;

        // Set status
        const statusHtml = menu.is_available
            ? `<div class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
                    <span class="text-green-400 font-semibold">Tersedia</span>
                </div>`
            : `<div class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 bg-red-500 rounded-full"></span>
                    <span class="text-red-400 font-semibold">Tidak Tersedia</span>
                </div>`;
        document.getElementById('modalStatus').innerHTML = statusHtml;

        // Set description
        document.getElementById('modalDescription').textContent = menu.deskripsi || 'Tidak ada deskripsi';

        // Set bahan
        if (menu.bahan) {
            document.getElementById('modalBahan').textContent = menu.bahan;
            document.getElementById('bahanSection').classList.remove('hidden');
        } else {
            document.getElementById('bahanSection').classList.add('hidden');
        }

        // Set ukuran
        if (menu.ukuran) {
            document.getElementById('modalUkuran').textContent = menu.ukuran;
            document.getElementById('ukuranInfo').classList.remove('hidden');
        } else {
            document.getElementById('ukuranInfo').classList.add('hidden');
        }

        // Set durasi
        if (menu.durasi_persiapan) {
            document.getElementById('modalDurasi').textContent = `${menu.durasi_persiapan} menit`;
            document.getElementById('durasiInfo').classList.remove('hidden');
        } else {
            document.getElementById('durasiInfo').classList.add('hidden');
        }

        // Set button state
        const orderBtn = document.getElementById('modalOrderBtn');
        if (!menu.is_available) {
            orderBtn.disabled = true;
            orderBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            orderBtn.disabled = false;
            orderBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }

        // Open modal
        document.getElementById('menuDetailModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // Modal quantity controls
    function increaseModalQty() {
        const input = document.getElementById('modalQtyInput');
        let value = parseInt(input.value) || 1;
        if (value < 99) input.value = value + 1;
    }

    function decreaseModalQty() {
        const input = document.getElementById('modalQtyInput');
        let value = parseInt(input.value) || 1;
        if (value > 1) input.value = value - 1;
    }

    // Add to cart from modal
    function addToCartFromModal() {
        const menuId = currentModalMenuId;
        if (!menuId) return;

        const qty = document.getElementById('modalQtyInput').value;

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
        qtyInput.value = qty;

        form.appendChild(csrfInput);
        form.appendChild(qtyInput);
        document.body.appendChild(form);
        form.submit();
    }

    // Close modal
    function closeMenuDetail(event) {
        if (event && event.target.id !== 'menuDetailModal') return;
        document.getElementById('menuDetailModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        currentModalMenuId = null;
    }

    // Close on escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeMenuDetail();
        }
    });

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const firstBtn = document.querySelector('.kategori-btn');
        if (firstBtn) {
            firstBtn.classList.add('text-white', 'bg-orange-500', 'shadow-lg', 'shadow-orange-500/25');
            firstBtn.classList.remove('bg-gray-800', 'text-gray-300');
        }
    });

    function showMoreMenu() {

    const hiddenCards = document.querySelectorAll('.extra-menu');

    hiddenCards.forEach((card, index) => {

        setTimeout(() => {

            // tampilkan card
            card.classList.remove('hidden');

            // reset animasi
            card.classList.remove('active');

            // trigger ulang animasi reveal
            setTimeout(() => {
                card.classList.add('active');
            }, 50);

        }, index * 120);

    });

    // sembunyikan tombol
    const btn = document.getElementById('showMoreBtn');

    btn.style.opacity = '0';

    setTimeout(() => {
        btn.style.display = 'none';
    }, 300);
}

    </script>

    <style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
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
    </style>

</section>
