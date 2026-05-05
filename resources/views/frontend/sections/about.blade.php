<section class="relative bg-black py-24 overflow-hidden">

    <div class="text-center mb-12 reveal">
        <h2 class="text-4xl font-bold">
            <span class="text-white">Tentang</span>
            <span class="text-[var(--color-primary)]">Kami</span>
        </h2>
    </div>

    <div class="container-main grid grid-cols-1 md:grid-cols-2 items-center gap-12">

        {{-- KIRI: IMAGE --}}
        <div class="relative reveal-left">

            <img src="{{ asset('images/about/depan.jpg') }}"
                 class="w-full h-[500px] object-cover">

        </div>

        {{-- KANAN: TEXT --}}
        <div class="relative z-10 reveal-right delay-200">

            <h2 class="title-main text-[var(--color-primary)] reveal delay-300">
                Rumah Makan <br> Sate Simpang Tiga
            </h2>

            <p class="text-gray-400 mt-4 text-sm leading-relaxed max-w-md reveal delay-500">
                Sate Simpang Tiga adalah tempat kuliner yang menghadirkan cita rasa sate khas Indonesia dengan kualitas terbaik, menggunakan bahan segar dan bumbu autentik yang diolah dengan resep pilihan. Setiap tusuk sate dibakar menggunakan arang untuk menghasilkan aroma khas yang menggugah selera, lalu disajikan dengan bumbu yang kaya rasa dan nikmat. Kami berkomitmen untuk memberikan pengalaman makan yang lezat, hangat, dan berkesan bagi setiap pelanggan, baik dinikmati sendiri maupun bersama keluarga dan orang terdekat.
            </p>
        </div>
    </div>
</section>
