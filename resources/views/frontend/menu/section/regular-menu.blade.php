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