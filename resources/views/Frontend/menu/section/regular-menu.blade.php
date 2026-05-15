<!-- REGULAR MENU SECTION -->
    <section id="regularMenuSection" class="bg-black px-6 pb-32 section-reveal">
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
                    <div class="menu-frame" data-kategori-id="{{ $menu->kategori_id ?? 0 }}">
                        <div class="menu-frame-inner">
                            <div class="group w-full h-full overflow-hidden rounded-lg bg-gradient-to-b from-gray-800 to-gray-950 shadow-xl hover:shadow-2xl hover:shadow-orange-500/10 transition-all duration-500 menu-card border border-white/5 hover:border-orange-500/30 menu-card-tilt flex flex-col"
                                >
                                <div class="menu-card-tilt-inner flex flex-col flex-1 min-h-0">
                                    <!-- IMAGE (55% of height) -->
                                    <div class="relative menu-card-shine overflow-hidden" style="flex: 1.4;">
                                        @if ($menu->gambar)
                                            <img src="{{ asset('storage/menu/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}"
                                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                        @else
                                            <div
                                                class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                                                <i class="fas fa-utensils text-gray-500 text-3xl"></i>
                                            </div>
                                        @endif

                                        <!-- Overlay on hover -->
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        </div>

                                        <!-- Category Badge -->
                                        <div class="absolute top-2 left-2 z-10">
                                            <span
                                                class="px-2 py-0.5 bg-black/60 backdrop-blur-sm rounded-full text-[10px] text-white font-semibold">
                                                {{ $menu->kategori->nama_kategori ?? 'Menu' }}
                                            </span>
                                        </div>

                                        <!-- Availability Badge -->
                                        <div class="absolute top-2 right-2 z-10">
                                            @if ($menu->is_available)
                                                <span
                                                    class="px-2 py-0.5 bg-green-500/90 backdrop-blur-sm rounded-full text-[10px] text-white font-semibold flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                                                    Tersedia
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 py-0.5 bg-red-500/90 backdrop-blur-sm rounded-full text-[10px] text-white font-semibold">
                                                    Habis
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- CONTENT (45% of height) -->
                                    <div class="p-3 flex flex-col justify-center" style="flex: 1;">
                                        <h3
                                            class="font-bold text-sm text-white mb-1 line-clamp-1 group-hover:text-orange-400 transition-colors">
                                            {{ $menu->nama_menu }}
                                        </h3>

                                        <p class="text-[10px] text-gray-400 mb-2 line-clamp-2 leading-relaxed">
                                            {{ $menu->deskripsi ?? 'Tidak ada deskripsi' }}
                                        </p>

                                        <!-- Price & Actions -->
                                        <div class="flex items-center justify-between gap-1">
                                            <span class="text-sm font-bold text-orange-400 menu-price">
                                                Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                            </span>

                                            <div class="flex gap-1">
                                                <button type="button" onclick="quickAddToCart({{ $menu->id }}, this)"
                                                    class="w-7 h-7 rounded-full bg-orange-500 hover:bg-orange-600 text-white flex items-center justify-center transition-all hover:scale-110 disabled:opacity-50 disabled:cursor-not-allowed text-[10px]"
                                                    {{ !$menu->is_available ? 'disabled' : '' }}>
                                                    <i class="fas fa-plus"></i>
                                                </button>

                                                <button onclick='openMenuDetail(@json($menu))'
                                                    class="w-7 h-7 rounded-full bg-gray-700 hover:bg-gray-600 text-white flex items-center justify-center transition-all hover:scale-110 text-[10px]">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
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
