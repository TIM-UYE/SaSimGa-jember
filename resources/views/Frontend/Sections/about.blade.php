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

                </p>
            </div>

        </div>

        {{-- KANAN: TEXT --}}
        <div class="relative z-10">

            <h2 class="title-main text-[var(--color-primary)]">
                Rumah Makan <br> Sate Simpang Tiga
            </h2>

            <p class="text-gray-400 mt-4 text-sm leading-relaxed max-w-md">
                Sate Simpang Tiga adalah tempat kuliner yang menghadirkan cita rasa sate khas Indonesia dengan kualitas terbaik, menggunakan bahan segar dan bumbu autentik yang diolah dengan resep pilihan. Setiap tusuk sate dibakar menggunakan arang untuk menghasilkan aroma khas yang menggugah selera, lalu disajikan dengan bumbu yang kaya rasa dan nikmat. Kami berkomitmen untuk memberikan pengalaman makan yang lezat, hangat, dan berkesan bagi setiap pelanggan, baik dinikmati sendiri maupun bersama keluarga dan orang terdekat.
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
    {{-- <div class="absolute bottom-10 left-1/2 -translate-x-1/2 w-[300px] h-[20px] bg-[var(--color-primary)]"></div> --}}

</section>
