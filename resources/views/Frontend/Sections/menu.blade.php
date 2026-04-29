<section class="relative bg-black py-24 overflow-hidden">

    {{-- Background --}}
    <div class="absolute inset-0">
        <img src="{{ asset('images/menu/background.jpg') }}" 
             class="w-full h-full object-cover opacity-30">
    </div>

    <div class="relative z-10 container-main">

        {{-- HEADER --}}
        <div class="flex items-center gap-8 mb-10">

            <h2 class="text-3xl font-bold text-white">
                Semua Menu
            </h2>

            <div class="flex gap-6 text-gray-400 text-sm">
                <button class="text-white">Sate Kambing</button>
                <button class="hover:text-white">Paket Hemat</button>
            </div>

        </div>

        {{-- GRID MENU --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            {{-- CARD --}}
            @for ($i = 0; $i < 8; $i++)
            <div class="bg-white rounded-xl overflow-hidden shadow-lg">

                <img src="{{ asset('images/menu/sate.jpg') }}" 
                     class="w-full h-48 object-cover">

                <div class="p-4">

                    <h3 class="font-semibold text-gray-800">
                        Sate Kambing Bumbu Original
                    </h3>

                    <div class="flex items-center justify-between mt-2 text-sm">

                        <div class="text-yellow-400">
                            ★★★★★ <span class="text-gray-500 text-xs">5/5</span>
                        </div>

                        <span class="text-gray-500 text-xs cursor-pointer">
                            Detail >
                        </span>

                    </div>

                </div>

            </div>
            @endfor

        </div>

        {{-- LIHAT SELENGKAPNYA --}}
        <div class="text-center mt-10 text-gray-300 text-sm cursor-pointer">
            &lt;&lt; Lihat Selengkapnya &gt;&gt;
        </div>

    </div>

    {{-- SHAPE BAWAH --}}
    <div class="absolute bottom-0 left-0 w-full h-[150px] bg-black"
         style="clip-path: ellipse(70% 100% at 50% 100%);">
    </div>

</section>