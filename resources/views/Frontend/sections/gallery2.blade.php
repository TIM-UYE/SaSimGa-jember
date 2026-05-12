<section class="relative min-h-screen bg-dark overflow-hidden">

    {{-- BACKGROUND GLOW --}}
    <div class="absolute inset-0 pointer-events-none">

        <div
            class="absolute top-[10%] left-[8%]
        w-[520px] h-[520px]
        bg-orange-500/10
        rounded-full blur-3xl glow-blob-1">
        </div>

        <div
            class="absolute bottom-[8%] right-[6%]
        w-[420px] h-[420px]
        bg-amber-500/10
        rounded-full blur-3xl glow-blob-2">
        </div>

    </div>

    {{-- ORBIT --}}
    <div class="orbit-scene">

        <div class="orbit-world" id="orbitWorld">

            {{-- CARD 1 --}}
            <div class="orbit-card orbit-card-1">
                <div class="orbit-face">
                    <img src="{{ asset('images/gallery/gallery1.jpg') }}" alt="Gallery 1" loading="lazy">
                </div>
            </div>

            {{-- CARD 2 --}}
            <div class="orbit-card orbit-card-2">
                <div class="orbit-face">
                    <img src="{{ asset('images/gallery/gallery2.jpg') }}" alt="Gallery 2" loading="lazy">
                </div>
            </div>

            {{-- CARD 3 --}}
            <div class="orbit-card orbit-card-3">
                <div class="orbit-face">
                    <img src="{{ asset('images/gallery/gallery3.jpg') }}" alt="Gallery 3" loading="lazy">
                </div>
            </div>

            {{-- CARD 4 --}}
            <div class="orbit-card orbit-card-4">
                <div class="orbit-face">
                    <img src="{{ asset('images/gallery/gallery4.jpg') }}" alt="Gallery 4" loading="lazy">
                </div>
            </div>

            {{-- CARD 5 --}}
            <div class="orbit-card orbit-card-5">
                <div class="orbit-face">
                    <img src="{{ asset('images/gallery/gallery5.jpg') }}" alt="Gallery 5" loading="lazy">
                </div>
            </div>

        </div>

    </div>

    {{-- VIGNETTE --}}
    <div class="orbit-vignette"></div>

    {{-- TEXT --}}
    <div class="relative z-30
        flex items-center justify-center
        min-h-screen px-6">

        <div class="text-center max-w-5xl gallery-headline">

            <h2 class="text-2xl md:text-4xl lg:text-5xl
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

</section>
