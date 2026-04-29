<section class="relative bg-black py-24 overflow-hidden">

    <div class="container-main grid grid-cols-1 md:grid-cols-2 items-center gap-12">

        {{-- KIRI: IMAGE --}}
        <div class="relative">

            <img src="{{ asset('images/about/depan.jpg') }}"
                 class="w-full h-[500px] object-cover">

            {{-- TEXT OVER IMAGE --}}
            <div class="absolute top-10 left-10">
                <h2 class="text-[var(--color-primary)] text-3xl font-bold">
                    About us
                </h2>

                <p class="text-white text-sm mt-2 max-w-xs">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                </p>
            </div>

        </div>

        {{-- KANAN: TEXT --}}
        <div class="relative z-10">

            <h2 class="title-main text-[var(--color-primary)]">
                Rumah Makan <br> Sate Simpangtiga
            </h2>

            <p class="text-gray-400 mt-4 text-sm leading-relaxed max-w-md">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            </p>

        </div>

    </div>

    {{-- LOGO OVERLAY (TENGAH) --}}
    {{-- <div class="absolute left-[40%] top-1/2 -translate-y-1/2 z-20 w-[250px] md:w-[300px]">

        <div class="bg-[#1a1a1a] p-6 shadow-2xl">
            <img src="{{ asset('images/logo/logo.png') }}" class="w-full">
        </div>

    </div> --}}

    {{-- ORANGE BAR BAWAH --}}
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 w-[300px] h-[20px] bg-[var(--color-primary)]"></div>

</section>