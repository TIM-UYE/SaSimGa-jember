<section class="relative min-h-screen overflow-hidden bg-black">

    {{-- Background kanan --}}
    <div class="absolute top-0 right-0 w-1/2 h-full">
        <img
            src="{{ asset('images/hero/hero.png') }}"
            class="w-full h-full object-cover"
        >
    </div>


    {{-- CONTENT --}}
    <div class="relative z-20 container-main flex items-center min-h-screen">

        <div class="max-w-xl reveal-scale">

            <p class="text-gray-400 -mb-4 text-lg reveal delay-100">
                Rumah Makan
            </p>

            <h1 class="title-main text-white reveal delay-200">
                SATE <span class="text-[var(--color-primary)]">SIMPANG TIGA</span>
            </h1>

            <p class="text-gray-400 mt-2 text-sm leading-relaxed reveal delay-300">
                Sate Simpang Tiga menghadirkan sate khas Indonesia dengan bahan segar dan bumbu autentik.
                Dibakar dengan arang untuk aroma khas, kami menyajikan rasa terbaik untuk pengalaman
                makan yang hangat dan berkesan.
            </p>


            {{-- BUTTON --}}
            <div class="mt-6 flex gap-4 reveal delay-500">

                {{-- MENU --}}
                <a href="{{ route('frontend.menu') }}"
                   class="btn-primary inline-flex items-center justify-center">
                    Pesan Sekarang
                </a>


                {{-- RESERVASI --}}
                <a href="{{ route('frontend.reservasi') }}"
                   class="btn-outline inline-flex items-center justify-center">
                    Reservasi Sekarang
                </a>

            </div>

        </div>

    </div>


    {{-- GAMBAR UTAMA --}}
    <div class="absolute right-[15%] top-1/2 -translate-y-1/2 z-30 w-[380px] md:w-[500px]">

        <img
            src="{{ asset('images/hero/sate.png') }}"
            class="w-full drop-shadow-[0_30px_60px_rgba(0,0,0,0.6)] reveal-scale"
        >

    </div>


    {{-- GRADIENT BOTTOM --}}
    <div class="absolute bottom-0 left-0 w-full h-40 bg-gradient-to-b from-transparent to-black z-40">
    </div>

</section>
