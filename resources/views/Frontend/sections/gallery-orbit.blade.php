<section class="relative min-h-screen bg-black overflow-hidden">

    {{-- BACKGROUND GLOW --}}
    <div class="absolute inset-0 pointer-events-none z-0">

        <div
            class="glow-blob glow-blob-1
            absolute top-[8%] left-[5%]
            w-[520px] h-[520px]
            bg-orange-500/10
            rounded-full blur-3xl">
        </div>

        <div
            class="glow-blob glow-blob-2
            absolute bottom-[5%] right-[8%]
            w-[420px] h-[420px]
            bg-amber-500/10
            rounded-full blur-3xl">
        </div>

    </div>

    {{-- BACK ORBIT --}}
    <div class="orbit-scene orbit-back">

        <div class="orbit-world" id="orbitBack">

            @foreach ([1, 2, 3, 4, 5, 1, 2] as $index => $img)
                <div class="orbit-card orbit-back-card {{ ['orbit-sm', 'orbit-md', 'orbit-lg'][$index % 3] }}">

                    <div class="orbit-float">

                        <div class="orbit-face">

                            <img src="{{ asset('images/gallery/gallery' . $img . '.jpg') }}" loading="lazy"
                                alt="Gallery Image">

                        </div>

                    </div>

                </div>
            @endforeach

        </div>

    </div>

    {{-- CENTER TEXT --}}
    <div class="relative z-30
        flex items-center justify-center
        min-h-screen px-6">

        <div class="text-center max-w-5xl
            gallery-headline">

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

    {{-- FRONT ORBIT --}}
    <div class="orbit-scene orbit-front">

        <div class="orbit-world" id="orbitFront">

            @foreach ([3, 4, 5, 2, 1] as $index => $img)
                <div class="orbit-card orbit-front-card {{ ['orbit-sm', 'orbit-md', 'orbit-lg'][$index % 3] }}">

                    <div class="orbit-float">

                        <div class="orbit-face">

                            <img src="{{ asset('images/gallery/gallery' . $img . '.jpg') }}" loading="lazy"
                                alt="Gallery Image">

                        </div>

                    </div>

                </div>
            @endforeach

        </div>

    </div>

    {{-- VIGNETTE --}}
    <div class="orbit-vignette"></div>

</section>
