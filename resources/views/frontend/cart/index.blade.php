@extends('frontend.layout.app')

@section('content')

<section class="min-h-screen bg-black text-white py-32">

    <div class="max-w-5xl mx-auto px-6">

        <h1 class="text-4xl font-bold mb-10">
            Keranjang Saya
        </h1>

        @if(count($cart) > 0)

            <div class="space-y-6">

                @php $total = 0; @endphp

                @foreach($cart as $item)

                    @php
                        $subtotal = $item['harga'] * $item['qty'];
                        $total += $subtotal;
                    @endphp

                    <div class="bg-zinc-900 rounded-3xl p-6 flex justify-between items-center">

                        <div>

                            <h2 class="text-xl font-semibold">
                                {{ $item['nama'] }}
                            </h2>

                            <p class="text-orange-400 mt-1">
                                Rp {{ number_format($item['harga'], 0, ',', '.') }}
                            </p>

                            <p class="text-white/60 text-sm mt-1">
                                Qty: {{ $item['qty'] }}
                            </p>

                        </div>

                        <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button
                                class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-xl text-sm"
                            >
                                Hapus
                            </button>

                        </form>

                    </div>

                @endforeach

            </div>

            <div class="mt-10 bg-zinc-900 rounded-3xl p-6">

                <div class="flex justify-between items-center">

                    <h2 class="text-2xl font-bold">
                        Total
                    </h2>

                    <p class="text-3xl font-bold text-orange-400">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </p>

                </div>

                <button
                    class="mt-6 w-full bg-orange-500 hover:bg-orange-600 py-4 rounded-2xl font-semibold"
                >
                    Checkout Sekarang
                </button>

            </div>

        @else

            <div class="text-center py-20">

                <i class="fa-solid fa-cart-shopping text-6xl text-white/20"></i>

                <p class="mt-6 text-white/60">
                    Keranjang masih kosong
                </p>

            </div>

        @endif

    </div>

</section>

@endsection
