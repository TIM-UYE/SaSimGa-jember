<section class="relative min-h-screen overflow-hidden bg-black">

    {{-- Background kanan --}}
    <div class="absolute top-0 right-0 w-1/2 h-full">
        <img src="{{ asset('images/hero/backgroundsate.png') }}"
             class="w-full h-full object-cover">
    </div>

    {{-- Shape hitam besar --}}
     <div class="absolute top-0 left-0 w-[75%] h-full bg-black z-10"
         style="clip-path: ellipse(85% 100% at 0% 50%);">
    </div>
    
    {{-- Content --}}
    <div class="relative z-20 container-main flex items-center min-h-screen">

        <div class="max-w-xl">

            <p class="text-gray-400 -mb-4 text-lg">
                Rumah Makan
            </p>

            <h1 class="title-main text-white">
                SATE <span class="text-[var(--color-primary)]">SIMPANGTIGA</span>
            </h1>

            <p class="text-gray-400 -mt-2 text-sm leading-relaxed">
                Lorem ipsum has been the industry’s standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            </p>

            <div class="mt-6 flex gap-4">
                <button class="btn-primary">
                    Pesan Sekarang
                </button>

                <button class="btn-outline">
                    Reservasi Sekarang
                </button>
            </div>

        </div>

    </div>

    {{-- Gambar utama (piring sate) --}}
    <div class="absolute right-[15%] top-1/2 -translate-y-1/2 z-30 w-[380px] md:w-[500px]">
        <img src="{{ asset('images/hero/sate.png') }}"
             class="w-full drop-shadow-[0_30px_60px_rgba(0,0,0,0.6)]">
    </div>

    {{-- Lingkaran kecil kanan atas --}}
    
</section>