<section class="relative min-h-screen bg-[#f5f1eb] overflow-hidden">

    {{-- BACKGROUND GLOW --}}
    <div class="absolute inset-0">

        <div class="absolute top-20 left-20 w-[500px] h-[500px]
            bg-orange-300/20 rounded-full blur-3xl">
        </div>

    </div>

    {{-- MAIN TEXT --}}
    <div class="relative z-10 flex items-center justify-center min-h-screen px-6">

        <div class="max-w-5xl text-center">

            <h2
                class="text-5xl md:text-7xl lg:text-8xl
                font-bold leading-[0.95] tracking-tight text-black">

                Hangatnya
                <br>

                Kebersamaan
                <br>

                Dalam Setiap
                <br>

                <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500">

                    Sajian

                </span>

            </h2>

        </div>

    </div>

    {{-- FLOATING IMAGE 1 --}}
    <img src="{{ asset('images/gallery/gallery1.jpg') }}"
        class="absolute top-[18%] left-[8%]
        w-40 md:w-56 rounded-3xl
        shadow-2xl
        object-cover
        animate-float-slow">

    {{-- FLOATING IMAGE 2 --}}
    <img src="{{ asset('images/gallery/gallery2.jpg') }}"
        class="absolute top-[22%] right-[10%]
        w-52 md:w-72 rounded-3xl
        shadow-2xl
        object-cover
        animate-float-medium">

    {{-- FLOATING IMAGE 3 --}}
    <img src="{{ asset('images/gallery/gallery3.jpg') }}"
        class="absolute bottom-[18%] left-[15%]
        w-44 md:w-64 rounded-3xl
        shadow-2xl
        object-cover
        animate-float-fast">

    {{-- FLOATING IMAGE 4 --}}
    <img src="{{ asset('images/gallery/gallery4.jpg') }}"
        class="absolute bottom-[12%] right-[14%]
        w-48 md:w-60 rounded-3xl
        shadow-2xl
        object-cover
        animate-float-medium">

    {{-- CENTER IMAGE --}}
    <img src="{{ asset('images/gallery/gallery5.jpg') }}"
        class="absolute top-1/2 left-1/2
        -translate-x-1/2 -translate-y-1/2
        w-60 md:w-80 rounded-3xl
        shadow-2xl
        object-cover
        animate-float-slow">

</section>
