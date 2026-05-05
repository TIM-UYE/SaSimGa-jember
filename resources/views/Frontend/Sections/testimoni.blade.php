<section class="bg-black py-24">

    <div class="container-main">

        {{-- TITLE --}}
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold">
                <span class="text-white">Our</span>
                <span class="text-[var(--color-primary)]">Testimoni</span>
            </h2>
        </div>

        {{-- CARD WRAPPER --}}
        <div class="grid md:grid-cols-3 gap-6">

            @for ($i = 0; $i < 3; $i++)
            <div class="bg-white rounded-2xl overflow-hidden shadow-lg">

                {{-- IMAGE --}}
                <img src="{{ asset('images/menu/sate.jpg') }}"
                     class="w-full h-40 object-cover">

                {{-- CONTENT --}}
                <div class="p-4">

                    <h3 class="font-semibold text-black text-lg">
                        Dema
                    </h3>

                    <p class="text-gray-500 text-sm mt-1">
                        Innal fatta man yakuulu haanadaa
                        liasa man yakuulu kaana abii
                    </p>

                    {{-- FOOTER --}}
                    <div class="flex items-center justify-between mt-4">

                        {{-- RATING --}}
                        <div class="text-yellow-400 text-sm">
                            ★★★★★ <span class="text-gray-500 text-xs">5/5</span>
                        </div>

                        {{-- BUTTON --}}
                        <button class="bg-[var(--color-primary)] text-black text-xs px-3 py-1 rounded-full">
                            Selengkapnya
                        </button>

                    </div>

                </div>

            </div>
            @endfor

        </div>

        {{-- DOT INDICATOR --}}
        <div class="flex justify-center items-center gap-3 mt-10">

            <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
            <div class="w-6 h-6 bg-[var(--color-primary)] rounded-full"></div>
            <div class="w-3 h-3 bg-gray-400 rounded-full"></div>

        </div>

    </div>

</section>
