<section class="relative min-h-screen overflow-hidden bg-black">

    {{-- Background kanan --}}
    <div class="absolute top-0 right-0 w-1/2 h-full">
        <img src="{{ asset('images/hero/hero.png') }}"
             class="w-full h-full object-cover">
    </div>


    {{-- Content --}}
    <div class="relative z-20 container-main flex items-center min-h-screen">

        <div class="max-w-xl reveal-scale">

            <p class="text-gray-400 -mb-4 text-lg reveal delay-100">
                Rumah Makan
            </p>

            <h1 class="title-main text-white reveal delay-200">
                SATE <span class="text-[var(--color-primary)]">SIMPANG TIGA</span>
            </h1>

            <p class="text-gray-400 -mt-2 text-sm leading-relaxed reveal delay-300">
                Sate Simpang Tiga adalah tempat kuliner yang menghadirkan cita rasa sate khas Indonesia dengan kualitas terbaik, menggunakan bahan segar dan bumbu autentik yang diolah dengan resep pilihan. Setiap tusuk sate dibakar menggunakan arang untuk menghasilkan aroma khas yang menggugah selera, lalu disajikan dengan bumbu yang kaya rasa dan nikmat. Kami berkomitmen untuk memberikan pengalaman makan yang lezat, hangat, dan berkesan bagi setiap pelanggan, baik dinikmati sendiri maupun bersama keluarga dan orang terdekat.
            </p>

            <div class="mt-6 flex gap-4 reveal delay-500">
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
        class="w-full drop-shadow-[0_30px_60px_rgba(0,0,0,0.6)] reveal-scale ">
    </div>

    {{-- Lingkaran kecil kanan atas --}}

</section>
