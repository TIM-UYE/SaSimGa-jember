<section class="relative bg-black py-24 overflow-hidden">

    {{-- Background --}}
    <div class="absolute inset-0">
        <img src="{{ asset('images/menu/background.jpg') }}"
             class="w-full h-full object-cover opacity-30">
    </div>

    <div class="text-center mb-12 reveal">
        <h2 class="text-4xl font-bold">
            <span class="text-white">Semua</span>
            <span class="text-[var(--color-primary)]">Menu</span>
        </h2>
    </div>

    <div class="relative z-10 container-main">

        {{-- HEADER --}}
        <div class="flex items-center gap-8 mb-10 flex-wrap">

            <div class="flex gap-6 text-gray-400 text-sm flex-wrap reveal delay-200">
                <button onclick="filterMenuByCategory(0)"
                   class="px-4 py-2 rounded transition text-white bg-orange-500 kategori-btn" data-kategori-id="0">
                    Semua
                </button>
                @foreach($kategoris as $kat)
                <button onclick="filterMenuByCategory({{ $kat->id }})"
                   class="px-4 py-2 rounded transition hover:text-white kategori-btn" data-kategori-id="{{ $kat->id }}">
                    {{ $kat->nama_kategori }} ({{ $kat->menus_count }})
                </button>
                @endforeach
            </div>

        </div>

        {{-- GRID MENU --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($menus as $menu)
            <div class="bg-white rounded-xl overflow-hidden shadow-lg 
            hover:shadow-[0_10px_30px_rgba(235,129,50,0.3)] 
            transition transform hover:scale-105 hover:-translate-y-2 
            menu-card reveal"
            style="--delay: {{ $loop->index * 0.1 }}s"
            data-kategori-id="{{ $menu->kategori_id }}">

                <div class="relative">
                    @if($menu->gambar)
                        <img src="{{ asset('storage/menu/' . $menu->gambar) }}"
                             alt="{{ $menu->nama_menu }}"
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                            <i class="fas fa-utensils text-gray-500 text-3xl"></i>
                        </div>
                    @endif

                    @if(!$menu->is_available)
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                        <span class="text-white font-semibold">Tidak Tersedia</span>
                    </div>
                    @endif
                </div>

                <div class="p-4">

                    <h3 class="font-semibold text-gray-800 line-clamp-2">
                        {{ $menu->nama_menu }}
                    </h3>

                    @if($menu->kategori)
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $menu->kategori->nama_kategori }}
                    </p>
                    @endif

                    <p class="text-sm text-gray-600 mt-2 line-clamp-2">
                        {{ $menu->deskripsi ?? 'Tidak ada deskripsi' }}
                    </p>

                    <div class="flex items-center justify-between mt-4">

                        <div class="font-bold text-orange-500 text-lg">
                            Rp {{ number_format($menu->harga, 0, ',', '.') }}
                        </div>

                        <button onclick="openMenuDetail({{ $menu->toJson() }})"
                           class="text-orange-500 text-xs font-semibold cursor-pointer hover:text-orange-600 transition">
                            Detail >
                        </button>

                    </div>

                </div>

            </div>
            @empty
            <div class="col-span-full text-center py-12 menu-empty-state" style="display: none;">
                <p class="text-gray-400 text-lg">Belum ada menu tersedia</p>
            </div>
            @endforelse

        </div>

    </div>

    {{-- SHAPE BAWAH --}}
    <div class="absolute bottom-0 left-0 w-full h-[150px] bg-black"
         style="clip-path: ellipse(70% 100% at 50% 100%);">
    </div>

    {{-- MODAL DETAIL MENU --}}
    <div id="menuDetailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" onclick="closeMenuDetail(event)">
        <div class="bg-white rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-800" id="modalTitle">Detail Menu</h2>
                <button onclick="closeMenuDetail()" class="text-gray-500 hover:text-gray-700 text-2xl">
                    &times;
                </button>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Gambar --}}
                    <div>
                        <div class="bg-gray-200 rounded-lg overflow-hidden mb-4">
                            <img id="modalImage" src="" alt="Menu" class="w-full h-64 object-cover">
                        </div>
                    </div>

                    {{-- Informasi --}}
                    <div>
                        <div id="modalCategory" class="inline-block bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-semibold mb-4"></div>

                        <h1 id="modalMenuName" class="text-3xl font-bold text-gray-800 mb-3"></h1>

                        <p id="modalPrice" class="text-3xl font-bold text-orange-500 mb-4"></p>

                        {{-- Status --}}
                        <div id="modalStatus" class="mb-4"></div>

                        <hr class="my-4">

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <h3 class="font-bold text-gray-800 mb-2">Deskripsi</h3>
                            <p id="modalDescription" class="text-gray-600 leading-relaxed"></p>
                        </div>

                        {{-- Bahan --}}
                        <div id="bahanSection" class="mb-4 hidden">
                            <h3 class="font-bold text-gray-800 mb-2">Bahan Utama</h3>
                            <p id="modalBahan" class="text-gray-600"></p>
                        </div>

                        {{-- Info Tambahan --}}
                        <div id="infoTambahanSection" class="grid grid-cols-2 gap-3 mb-4">
                            <div id="ukuranInfo" class="bg-gray-100 p-3 rounded-lg hidden">
                                <p class="text-xs text-gray-600">Ukuran</p>
                                <p id="modalUkuran" class="font-semibold text-gray-800"></p>
                            </div>
                            <div id="durasiInfo" class="bg-gray-100 p-3 rounded-lg hidden">
                                <p class="text-xs text-gray-600">Durasi Persiapan</p>
                                <p id="modalDurasi" class="font-semibold text-gray-800"></p>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Tombol Aksi --}}
                        <div class="flex gap-3">
                            <button class="flex-1 bg-orange-500 text-white py-3 rounded-lg font-bold hover:bg-orange-600 transition" id="modalOrderBtn">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Pesan Sekarang
                            </button>
                            <button class="px-4 py-3 border-2 border-orange-500 text-orange-500 rounded-lg font-bold hover:bg-orange-50 transition">
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
        // Update button active state
        document.querySelectorAll('.kategori-btn').forEach(btn => {
            btn.classList.remove('text-white', 'bg-orange-500');
            btn.classList.add('hover:text-white');
        });

        // Set the clicked button as active
        const activeBtn = document.querySelector(`.kategori-btn[data-kategori-id="${categoryId}"]`);
        if (activeBtn) {
            activeBtn.classList.add('text-white', 'bg-orange-500');
            activeBtn.classList.remove('hover:text-white');
        }

        // Filter menu cards
        const menuCards = document.querySelectorAll('.menu-card');
        let visibleCount = 0;

        menuCards.forEach(card => {
            const menuCategoryId = parseInt(card.getAttribute('data-kategori-id'));
            const filterCategoryId = parseInt(categoryId);

            // Jika Semua (0) dipilih, tampilkan semua menu
            if (filterCategoryId === 0) {
                card.style.display = 'block';
                visibleCount++;
            }
            // Jika kategori spesifik dipilih, tampilkan menu dengan kategori yang sama
            else if (menuCategoryId === filterCategoryId) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide empty state
        const emptyState = document.querySelector('.menu-empty-state');
        if (visibleCount === 0 && emptyState) {
            emptyState.style.display = 'block';
        } else if (emptyState) {
            emptyState.style.display = 'none';
        }
    }

    function openMenuDetail(menu) {
        // Set image
        const imagePath = menu.gambar ? `{{ asset('storage/menu/') }}/${menu.gambar}` : '';
        document.getElementById('modalImage').src = imagePath || '{{ asset('images/placeholder.jpg') }}';

        // Set title
        document.getElementById('modalMenuName').textContent = menu.nama_menu;

        // Set category
        const categoryHtml = menu.kategori ? `<span>${menu.kategori.nama_kategori}</span>` : '';
        document.getElementById('modalCategory').innerHTML = categoryHtml;
        document.getElementById('modalCategory').classList.toggle('hidden', !menu.kategori);

        // Set price
        const price = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(menu.harga);
        document.getElementById('modalPrice').textContent = price;

        // Set status
        const statusHtml = menu.is_available
            ? `<div class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                    <span class="text-green-700 font-semibold">Tersedia</span>
                    ${menu.stok ? `<span class="text-gray-600 text-sm ml-2">Stok: ${menu.stok} unit</span>` : ''}
                </div>`
            : `<div class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 bg-red-500 rounded-full"></span>
                    <span class="text-red-700 font-semibold">Tidak Tersedia</span>
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

        // Set durasi persiapan
        if (menu.durasi_persiapan) {
            document.getElementById('modalDurasi').textContent = `${menu.durasi_persiapan} menit`;
            document.getElementById('durasiInfo').classList.remove('hidden');
        } else {
            document.getElementById('durasiInfo').classList.add('hidden');
        }

        // Set order button
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

    function closeMenuDetail(event) {
        if (event && event.target.id !== 'menuDetailModal') return;
        document.getElementById('menuDetailModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal when pressing Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeMenuDetail();
        }
    });

    // Initialize category filter on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Highlight first button (Semua) by default
        const firstBtn = document.querySelector('.kategori-btn');
        if (firstBtn) {
            firstBtn.classList.add('text-white', 'bg-orange-500');
            firstBtn.classList.remove('hover:text-white');
        }
    });
    </script>

</section>
