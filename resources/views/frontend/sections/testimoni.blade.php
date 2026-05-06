<section class="bg-black py-24 overflow-hidden">

    <div class="container-main">

        {{-- SECTION HEADER --}}
        <div class="max-w-2xl mx-auto text-center mb-16 reveal">

            <span
                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-orange-500/10 text-orange-400 text-xs font-medium tracking-wider uppercase mb-5 ring-1 ring-orange-500/20">
                <span class="w-1.5 h-1.5 rounded-full bg-orange-400 animate-pulse"></span>
                Testimoni
            </span>

            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 tracking-tight">
                <span class="text-white">
                    Apa Kata
                </span>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500">
                    Mereka
                </span>
            </h2>

            <p class="text-zinc-400 text-base leading-relaxed">
                Pengalaman para PEcinta Rajanya Sate yang telah menikmati cita rasa autentik dari Sate Simpangtiga.
            </p>
        </div>

        @php
            $displayTestimonials = collect($testimonis ?? [])->whenEmpty(function () {
                return collect([
                    [
                        'author_name' => 'Dema',
                        'text' => 'Innal fatta man yakuulu haanadaa liasa man yakuulu kaana abii',
                        'rating' => 5,
                        'profile_photo_url' => asset('images/menu/sate.jpg'),
                        'relative_time_description' => '1 hari lalu',
                        'source' => 'Manual',
                    ],
                    [
                        'author_name' => 'Aisyah',
                        'text' => 'Pelayanan cepat dan rasa makanannya sangat enak. Recommended!',
                        'rating' => 5,
                        'profile_photo_url' => asset('images/menu/nasi-kebuli.jpg'),
                        'relative_time_description' => '2 hari lalu',
                        'source' => 'Manual',
                    ],
                    [
                        'author_name' => 'Rudi',
                        'text' => 'Tempat nyaman, harga terjangkau, dan suasana sangat cocok untuk keluarga.',
                        'rating' => 5,
                        'profile_photo_url' => asset('images/menu/food-plate.jpg'),
                        'relative_time_description' => '3 hari lalu',
                        'source' => 'Manual',
                    ],
                ]);
            });
        @endphp

        {{-- CARD GRID --}}
        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-8">

            @foreach ($displayTestimonials as $index => $testimoni)
                <div class="group relative bg-zinc-900/70 backdrop-blur-sm border border-white/5 rounded-3xl overflow-hidden hover:border-orange-500/30 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-orange-500/10 reveal"
                    style="animation-delay: {{ $index * 0.1 }}s">

                    {{-- IMAGE --}}
                    <div class="relative h-52 overflow-hidden">

                        <img src="{{ data_get($testimoni, 'profile_photo_url', asset('images/menu/sate.jpg')) }}"
                            class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110">

                        {{-- OVERLAY --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent">
                        </div>

                        {{-- SOURCE --}}
                        <div class="absolute top-4 right-4">

                            <span
                                class="px-3 py-1 rounded-full bg-orange-500/90 backdrop-blur-sm text-white text-xs font-semibold">

                                {{ data_get($testimoni, 'source', 'Manual') }}

                            </span>

                        </div>

                    </div>

                    {{-- CONTENT --}}
                    <div class="p-6">

                        {{-- STARS --}}
                        <div class="flex items-center gap-1 mb-4">

                            @for ($i = 0; $i < data_get($testimoni, 'rating', 5); $i++)
                                <i class="fas fa-star text-amber-400 text-sm"></i>
                            @endfor

                            <span class="text-zinc-500 text-xs ml-2">
                                {{ data_get($testimoni, 'rating', 5) }}/5
                            </span>

                        </div>

                        {{-- TESTI --}}
                        <p class="text-zinc-300 leading-relaxed mb-6 line-clamp-4">

                            “{{ data_get($testimoni, 'text', 'Belum ada testimoni.') }}”

                        </p>

                        {{-- USER --}}
                        <div class="flex items-center justify-between">

                            <div>

                                <h3 class="text-white font-semibold text-lg">
                                    {{ data_get($testimoni, 'author_name', 'Anonymous') }}
                                </h3>

                                <p class="text-zinc-500 text-sm">
                                    {{ data_get($testimoni, 'relative_time_description', 'Baru saja') }}
                                </p>

                            </div>

                            {{-- QUOTE ICON --}}
                            <div class="w-12 h-12 rounded-2xl bg-orange-500/10 flex items-center justify-center">

                                <i class="fas fa-quote-right text-orange-400"></i>

                            </div>

                        </div>

                    </div>

                </div>
            @endforeach

        </div>

        {{-- DOT INDICATOR --}}
        <div class="flex justify-center items-center gap-3 mt-14">

            <div class="w-2.5 h-2.5 bg-zinc-700 rounded-full"></div>

            <div class="w-10 h-2 rounded-full bg-gradient-to-r from-orange-400 to-amber-500">
            </div>

            <div class="w-2.5 h-2.5 bg-zinc-700 rounded-full"></div>

        </div>

    </div>

</section>
