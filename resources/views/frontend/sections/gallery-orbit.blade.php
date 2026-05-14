<section class="relative min-h-screen bg-black overflow-hidden">

    {{-- BACKGROUND GLOW --}}
    <div class="absolute inset-0 pointer-events-none z-0">

        <div
            class="absolute top-[10%] left-[5%]
            w-[500px] h-[500px]
            bg-orange-500/10 rounded-full blur-3xl">
        </div>

        <div
            class="absolute bottom-[5%] right-[5%]
            w-[400px] h-[400px]
            bg-amber-500/10 rounded-full blur-3xl">
        </div>

    </div>

    {{-- ORBIT --}}
    <div class="orbit-scene">

        <div class="orbit-world" id="orbitWorld">

            @forelse($galeris->take(15) as $g)
                <div class="orbit-card">

                    <div class="orbit-float">

                        <div class="orbit-face">

                            <img src="{{ asset('storage/' . $g->image) }}" loading="lazy"
                                alt="{{ $g->title }}">

                        </div>

                    </div>

                </div>
            @empty
                @for ($i = 0; $i < 5; $i++)
                <div class="orbit-card">

                    <div class="orbit-float">

                        <div class="orbit-face">

                            <img src="{{ asset('images/gallery/gallery' . ($i % 5 + 1) . '.jpg') }}" loading="lazy"
                                alt="Gallery Image">

                        </div>

                    </div>

                </div>
                @endfor
            @endforelse

        </div>

    </div>

    {{-- TEXT --}}
    <div class="relative z-30
        min-h-screen
        flex items-center justify-center
        px-6">

        <div class="text-center max-w-5xl">

            <h2
                class="text-3xl md:text-5xl lg:text-6xl
                font-bold leading-[0.95]
                tracking-tight">

                <span class="text-white">
                    Authentic
                </span>

                <span
                    class="text-transparent bg-clip-text
                    bg-gradient-to-r
                    from-orange-400
                    via-orange-500
                    to-amber-500">

                    Culinary Experience

                </span>

            </h2>

        </div>

    </div>

    {{-- VIGNETTE --}}
    <div class="orbit-vignette"></div>

</section>
