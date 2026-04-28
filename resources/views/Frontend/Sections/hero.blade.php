<section class="relative min-h-screen overflow-hidden bg-black">

    {{-- Background kanan --}}
    <div class="absolute top-0 right-0 w-1/2 h-full">
        <img src="{{ asset('images/hero/backgroundsate.png') }}"
             class="w-full h-full object-cover">
    </div>

    {{-- Shape hitam besar --}}
    <div class="absolute top-0 left-0 w-[70%] h-full bg-black rounded-r-[200px] z-10"></div>

    {{-- Content --}}
    <div class="relative z-20 container-main flex items-center min-h-screen">

        <div class="max-w-xl">

            <p class="text-gray-400 mb-2 text-lg">
                Rumah Makan
            </p>

            <h1 class="title-main text-white">
                Sate <span class="text-[var(--color-primary)]">Simpangtiga</span>
            </h1>

            <p class="text-gray-400 mt-4 text-sm leading-relaxed">
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
    <div class="absolute right-[20%] top-1/2 -translate-y-1/2 z-30 w-[350px] md:w-[450px]">
        <img src="{{ asset('images/hero/sate-main.png') }}"
             class="w-full drop-shadow-[0_20px_40px_rgba(0,0,0,0.5)]">
    </div>

    {{-- Lingkaran kecil kanan atas --}}
    <div class="absolute top-6 right-6 w-5 h-5 bg-black rounded-full z-30 border border-white"></div>

</section>