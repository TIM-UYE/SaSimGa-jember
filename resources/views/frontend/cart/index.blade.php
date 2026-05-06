@extends('frontend.layout.app')

@section('content')

<section class="min-h-screen bg-black text-white py-32">

    <div class="max-w-5xl mx-auto px-6">

        <h1 class="text-4xl font-bold mb-10">
            Keranjang Saya
        </h1>

        @if(session('success'))
            <div class="mb-6 bg-green-500/20 border border-green-500/30 text-green-400 px-6 py-4 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-500/20 border border-red-500/30 text-red-400 px-6 py-4 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        @if(count($cart) > 0)

            <div class="space-y-6">

                @php $total = 0; @endphp

                @foreach($cart as $item)

                    @php
                        $subtotal = $item['harga'] * $item['qty'];
                        $total += $subtotal;
                    @endphp

                    <div class="bg-zinc-900 rounded-3xl p-6">

                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

                            <div class="flex items-center gap-4 flex-1">

                                {{-- MENU IMAGE --}}
                                <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0 bg-gray-800">
                                    @if(isset($item['gambar']) && $item['gambar'])
                                        <img
                                            src="{{ asset('storage/menu/' . $item['gambar']) }}"
                                            alt="{{ $item['nama'] }}"
                                            class="w-full h-full object-cover"
                                        >
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-utensils text-gray-600 text-xl"></i>
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <h2 class="text-xl font-semibold">
                                        {{ $item['nama'] }}
                                    </h2>

                                    <p class="text-orange-400 mt-1">
                                        Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                    </p>
                                </div>

                            </div>

                            {{-- Quantity Controls --}}
                            <div class="flex items-center gap-4">

                                <div class="flex items-center gap-2">
                                    <form action="{{ route('cart.decrement', $item['id']) }}" method="POST" class="inline">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="w-8 h-8 rounded-full bg-gray-700 hover:bg-gray-600 flex items-center justify-center text-white font-bold"
                                        >
                                            -
                                        </button>
                                    </form>

                                    <span class="text-white font-semibold w-12 text-center">
                                        {{ $item['qty'] }}
                                    </span>

                                    <form action="{{ route('cart.increment', $item['id']) }}" method="POST" class="inline">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="w-8 h-8 rounded-full bg-gray-700 hover:bg-gray-600 flex items-center justify-center text-white font-bold"
                                        >
                                            +
                                        </button>
                                    </form>
                                </div>

                                <div class="text-right min-w-[100px]">
                                    <p class="text-sm text-gray-400">Subtotal</p>
                                    <p class="text-lg font-bold text-orange-400">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </p>
                                </div>

                                <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-xl text-sm"
                                        onclick="return confirm('Hapus item dari keranjang?')"
                                    >
                                        <i class="fas fa-trash mr-2"></i>
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

            <div class="mt-10 bg-zinc-900 rounded-3xl p-6">

                <div class="flex justify-between items-center mb-4">

                    <h2 class="text-2xl font-bold">
                        Total
                    </h2>

                    <p class="text-3xl font-bold text-orange-400">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </p>

                </div>

                <div class="flex gap-4">
                    <a
                        href="{{ route('checkout.index') }}"
                        class="flex-1 bg-orange-500 hover:bg-orange-600 py-4 rounded-2xl font-semibold text-center"
                    >
                        Checkout Sekarang
                    </a>

                    <a
                        href="{{ route('frontend.menu') }}"
                        class="px-6 py-4 border-2 border-gray-600 hover:border-orange-500 rounded-2xl font-semibold"
                    >
                        <i class="fas fa-arrow-left mr-2"></i>
                        Lanjut Belanja
                    </a>
                </div>

            </div>

        @else

            <div class="text-center py-20">

                <i class="fa-solid fa-cart-shopping text-6xl text-white/20"></i>

                <p class="mt-6 text-white/60">
                    Keranjang masih kosong
                </p>

                <a
                    href="{{ route('frontend.menu') }}"
                    class="inline-block mt-6 bg-orange-500 hover:bg-orange-600 px-6 py-3 rounded-xl font-semibold"
                >
                    <i class="fas fa-utensils mr-2"></i>
                    Lihat Menu
                </a>

            </div>

        @endif

    </div>

</section>

@endsection
