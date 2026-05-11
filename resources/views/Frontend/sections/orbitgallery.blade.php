<section class="relative min-h-screen bg-[#f5f1eb] overflow-hidden">

    {{-- BACKGROUND GLOW --}}
    <div class="absolute inset-0">

        <div
            class="absolute top-20 left-20
            w-[500px] h-[500px]
            bg-orange-300/20
            rounded-full blur-3xl">
        </div>

        <div
            class="absolute bottom-10 right-10
            w-[400px] h-[400px]
            bg-amber-300/10
            rounded-full blur-3xl">
        </div>

    </div>

    {{-- MAIN TEXT --}}
    <div class="relative z-20
        flex items-center justify-center
        min-h-screen px-6">

        <div class="max-w-5xl text-center">

            <h2
                class="text-2xl md:text-3xl lg:text-4xl
                font-bold leading-[0.95]
                tracking-tight text-black">
                Hangatnya Kebersamaan Dalam Setiap
                <span
                    class="text-transparent bg-clip-text
                    bg-gradient-to-r
                    from-orange-400
                    via-orange-500
                    to-amber-500">

                    Sajian

                </span>

            </h2>

        </div>

    </div>

    {{-- DEPTH ORBIT --}}
    <div class="depth-orbit">

        {{-- ITEM 1 --}}
        <div class="depth-item item-1">
            <img src="{{ asset('images/gallery/gallery1.jpg') }}" alt="Gallery 1">
        </div>

        {{-- ITEM 2 --}}
        <div class="depth-item item-2">
            <img src="{{ asset('images/gallery/gallery2.jpg') }}" alt="Gallery 2">
        </div>

        {{-- ITEM 3 --}}
        <div class="depth-item item-3">
            <img src="{{ asset('images/gallery/gallery3.jpg') }}" alt="Gallery 3">
        </div>

        {{-- ITEM 4 --}}
        <div class="depth-item item-4">
            <img src="{{ asset('images/gallery/gallery4.jpg') }}" alt="Gallery 4">
        </div>

        {{-- ITEM 5 --}}
        <div class="depth-item item-5">
            <img src="{{ asset('images/gallery/gallery5.jpg') }}" alt="Gallery 5">
        </div>

    </div>

</section>
