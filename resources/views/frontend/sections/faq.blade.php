@extends('frontend.layout.app')

@section('content')

<section class="bg-black text-white min-h-screen py-24 px-6">

    <div class="max-w-5xl mx-auto">

        <h1 class="text-5xl font-bold text-orange-500 mb-4">
            FAQ'S
        </h1>

        <p class="text-gray-400 mb-12">
            Pertanyaan yang sering ditanyakan pelanggan Rumah Makan Sate Simpangtiga.
        </p>

        <div class="space-y-6">

            <div class="bg-zinc-900 rounded-3xl p-6 border border-white/10">

                <h2 class="text-xl font-bold mb-3">
                    Apakah bisa reservasi online?
                </h2>

                <p class="text-gray-400 leading-relaxed">
                    Ya, pelanggan dapat melakukan reservasi langsung melalui halaman reservasi di website kami.
                </p>

            </div>

            <div class="bg-zinc-900 rounded-3xl p-6 border border-white/10">

                <h2 class="text-xl font-bold mb-3">
                    Apakah menerima pembayaran digital?
                </h2>

                <p class="text-gray-400 leading-relaxed">
                    Kami menerima pembayaran transfer bank dan e-wallet.
                </p>

            </div>

            <div class="bg-zinc-900 rounded-3xl p-6 border border-white/10">

                <h2 class="text-xl font-bold mb-3">
                    Apakah tersedia layanan takeaway?
                </h2>

                <p class="text-gray-400 leading-relaxed">
                    Ya, semua menu dapat dibawa pulang atau dipesan melalui layanan online.
                </p>

            </div>

        </div>

    </div>

</section>

@endsection
