<!-- SPECIAL MENU SECTION -->
    <section id="specialMenuSection" class="bg-black px-6 pb-32 hidden">
        <div class="max-w-7xl mx-auto mt-16">

            <!-- SPECIAL GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

                @forelse($specials as $special)
                    <div
                        class="group relative overflow-hidden rounded-3xl h-[420px] cursor-pointer border border-gray-800 hover:border-orange-500/40 transition-all duration-500"
                        onclick="openSpecialMenuModal({{ json_encode($special) }})">

                        <!-- IMAGE -->
                        @if($special->banner_image)
                            <img src="{{ asset('storage/' . $special->banner_image) }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <img src="{{ asset('images/menu-special/tumpeng.jpg') }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @endif

                        <!-- OVERLAY -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/30 to-transparent"></div>

                        <!-- BADGE -->
                        <div class="absolute top-5 left-5">
                            <span class="px-4 py-2 rounded-full bg-orange-500 text-white text-xs font-bold shadow-lg shadow-orange-500/30">
                                PRE ORDER
                            </span>
                        </div>

                        <!-- CONTENT -->
                        <div class="absolute bottom-0 left-0 p-8 w-full">

                            <h3 class="text-3xl font-bold text-white mb-3">
                                {{ $special->title }}
                            </h3>

                            <p class="text-gray-300 mb-5">
                                {{ $special->short_description ?? 'Menu spesial untuk acara istimewa Anda.' }}
                            </p>

                            <div class="inline-flex items-center gap-3 text-orange-400 font-semibold group-hover:gap-5 transition-all">
                                <span>Lihat Detail</span>
                                <i class="fas fa-arrow-right"></i>
                            </div>

                        </div>

                    </div>
                @empty
                    <div class="col-span-3 text-center py-20">
                        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gray-800 mb-6">
                            <i class="fas fa-star text-4xl text-gray-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-400 mb-2">Belum Ada Menu Special</h3>
                        <p class="text-gray-500">Menu special akan segera tersedia</p>
                    </div>
                @endforelse

            </div>

        </div>
    </section>
