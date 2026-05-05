@extends('frontend.layout.app')

@section('content')

<!-- HERO -->
<section class="bg-black text-white py-20 px-6 border-b border-gray-800">
    <div class="max-w-7xl mx-auto">

        <h1 class="text-4xl font-bold mb-2">
            Tentang <span class="text-orange-500">Kami</span>
        </h1>

        <p class="text-gray-400">
            Mengenal lebih dekat Sate Simpangtiga
        </p>

        <!-- Breadcrumb -->
        <div class="mt-4 text-sm text-gray-500">
            <a href="{{ route('frontend.home') }}" class="hover:text-orange-500">Home</a>
            <span class="mx-2">/</span>
            <span class="text-white">About</span>
        </div>

    </div>
</section>

<!-- CONTENT -->
<section class="bg-black text-white py-20 px-6">
    <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center">

        <!-- Image -->
        <div class="relative">
            <img src="{{ asset('images/about/depan.jpg') }}"
                 class="rounded-xl shadow-2xl w-full h-[450px] object-cover">

            <div class="absolute -bottom-6 -right-6 w-40 h-40 bg-orange-500 opacity-30 blur-2xl"></div>
        </div>

        <!-- Text -->
        <div>

            <!-- Logo -->
            <div class="mb-6">
                <img src="{{ asset('images/logo/logo.png') }}" class="w-32">
            </div>

            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Rumah Makan <br>
                <span class="text-orange-500">Sate Simpangtiga</span>
            </h2>

            <p class="text-gray-400 mb-6 leading-relaxed">
                Berdiri sejak tahun 1975, Sate Simpangtiga telah menjadi bagian dari perjalanan kuliner masyarakat.
                Dengan resep turun-temurun dan bahan berkualitas tinggi,
                kami menghadirkan rasa autentik yang tidak berubah dari generasi ke generasi.
            </p>

            <p class="text-gray-400 leading-relaxed">
                Kami percaya bahwa makanan bukan hanya soal rasa,
                tetapi juga pengalaman dan kenangan yang tercipta di setiap hidangan.
            </p>

        </div>

    </div>
</section>

@endsection
