<section class="relative h-[220vh]">

    {{-- FIXED BACKGROUND --}}
    <div class="fixed inset-0 -z-10">

        <video autoplay muted loop playsinline class="w-full h-full object-cover">

            <source src="{{ asset('videos/sate.mp4') }}" type="video/mp4">

        </video>

        {{-- DARK OVERLAY --}}
        <div class="absolute inset-0 bg-black/70"></div>

        {{-- GRADIENT --}}
        <div
            class="absolute inset-0
            bg-gradient-to-b
            from-black/80
            via-black/20
            to-black">
        </div>

    </div>

    {{-- CONTENT --}}
    <div class="sticky top-0 h-screen
        flex items-center justify-center
        px-6 z-20">

        <div class="text-center max-w-5xl">

            <h2 class="text-2xl md:text-4xl lg:text-5xl
                font-bold leading-[0.95] tracking-tight">

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
