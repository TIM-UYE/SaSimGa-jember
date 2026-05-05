<section class="bg-black py-24">

    <div class="container-main">

        {{-- TITLE --}}
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold">
                <span class="text-white">Our</span>
                <span class="text-[var(--color-primary)]">Testimoni</span>
            </h2>
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
                        'text' => 'Pelayanan cepat dan rasa makanannya sangat enak. Recomended!',
                        'rating' => 5,
                        'profile_photo_url' => asset('images/menu/nasi-kebuli.jpg'),
                        'relative_time_description' => '2 hari lalu',
                        'source' => 'Manual',
                    ],
                    [
                        'author_name' => 'Rudi',
                        'text' => 'Tempat nyaman, harga terjangkau, dan testimoni Google Maps sangat membantu kami memilih menu.',
                        'rating' => 5,
                        'profile_photo_url' => asset('images/menu/food-plate.jpg'),
                        'relative_time_description' => '3 hari lalu',
                        'source' => 'Manual',
                    ],
                ]);
            });
        @endphp

        {{-- CARD WRAPPER --}}
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($displayTestimonials as $testimoni)
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg">
                    <img src="{{ data_get($testimoni, 'profile_photo_url', asset('images/menu/sate.jpg')) }}"
                         class="w-full h-40 object-cover">

                    <div class="p-4">
                        <h3 class="font-semibold text-black text-lg">
                            {{ data_get($testimoni, 'author_name', 'Anonymous') }}
                        </h3>

                        <p class="text-gray-500 text-sm mt-1">
                            {{ data_get($testimoni, 'text', 'Belum ada testimoni.') }}
                        </p>

                        <div class="flex items-center justify-between mt-4">
                            <div class="text-yellow-400 text-sm">
                                {{ str_repeat('★', max(1, min(5, data_get($testimoni, 'rating', 5)))) }}
                                <span class="text-gray-500 text-xs">{{ data_get($testimoni, 'rating', 5) }}/5</span>
                            </div>

                            <button class="bg-[var(--color-primary)] text-black text-xs px-3 py-1 rounded-full">
                                {{ data_get($testimoni, 'source', 'Manual') }}
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- DOT INDICATOR --}}
        <div class="flex justify-center items-center gap-3 mt-10">
            <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
            <div class="w-6 h-6 bg-[var(--color-primary)] rounded-full"></div>
            <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
        </div>

    </div>

</section>
