@extends('frontend.layout.app')

@section('title', 'Testimoni')

@section('content')
<section class="bg-black py-24">
    <div class="container-main">

        {{-- SECTION HEADER --}}
        <div class="max-w-2xl mx-auto text-center mb-16 reveal">

            <span
                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-orange-500/10 text-orange-400 text-xs font-medium tracking-wider uppercase mb-5 ring-1 ring-orange-500/20">
                <span class="w-1.5 h-1.5 rounded-full bg-orange-400 animate-pulse"></span>
                Testimoni
            </span>

            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 tracking-tight">
                <span class="text-white">
                    Semua
                </span>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500">
                    Testimoni
                </span>
            </h2>

            <p class="text-zinc-400 text-base leading-relaxed">
                Pengalaman para PEcinta Rajanya Sate yang telah menikmati cita rasa autentik dari Sate Simpangtiga.
            </p>
        </div>

        {{-- FILTER --}}
        <div class="flex justify-center mb-10">
            <div class="inline-flex items-center gap-2 bg-zinc-900/70 backdrop-blur-sm border border-white/10 rounded-2xl p-1.5">
                <a href="{{ route('frontend.testimoni.index', ['sort' => 'terbaru']) }}"
                    class="px-6 py-2 rounded-xl text-sm font-medium transition-all {{ ($sort ?? 'terbaru') === 'terbaru' ? 'bg-orange-500 text-white' : 'text-zinc-400 hover:text-white hover:bg-white/10' }}">
                    <i class="fas fa-clock mr-2"></i>Terbaru
                </a>
                <a href="{{ route('frontend.testimoni.index', ['sort' => 'tertinggi']) }}"
                    class="px-6 py-2 rounded-xl text-sm font-medium transition-all {{ ($sort ?? '') === 'tertinggi' ? 'bg-orange-500 text-white' : 'text-zinc-400 hover:text-white hover:bg-white/10' }}">
                    <i class="fas fa-arrow-up mr-2"></i>Tertinggi
                </a>
                <a href="{{ route('frontend.testimoni.index', ['sort' => 'terendah']) }}"
                    class="px-6 py-2 rounded-xl text-sm font-medium transition-all {{ ($sort ?? '') === 'terendah' ? 'bg-orange-500 text-white' : 'text-zinc-400 hover:text-white hover:bg-white/10' }}">
                    <i class="fas fa-arrow-down mr-2"></i>Terendah
                </a>
            </div>
        </div>

        {{-- CARD GRID --}}
        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-8">

            @forelse ($testimonis as $index => $testimoni)
                <div class="group relative bg-zinc-900/70 backdrop-blur-sm border border-white/5 rounded-3xl overflow-hidden hover:border-orange-500/30 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-orange-500/10 reveal"
                    style="animation-delay: {{ $index * 0.1 }}s">

                    {{-- IMAGE --}}
                    <div class="relative h-52 overflow-hidden">

                        <img src="{{ data_get($testimoni, 'profile_photo_url', asset('images/menu/sate.jpg')) }}"
                            class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110">

                        {{-- OVERLAY --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent">
                        </div>

                        {{-- SOURCE --}}
                        <div class="absolute top-4 right-4">

                            <span
                                class="px-3 py-1 rounded-full bg-orange-500/90 backdrop-blur-sm text-white text-xs font-semibold">

                                {{ data_get($testimoni, 'source', 'Manual') }}

                            </span>

                        </div>

                    </div>

                    {{-- CONTENT --}}
                    <div class="p-6">

                        {{-- STARS --}}
                        <div class="flex items-center gap-1 mb-4">

                            @for ($i = 0; $i < data_get($testimoni, 'rating', 5); $i++)
                                <i class="fas fa-star text-amber-400 text-sm"></i>
                            @endfor

                            <span class="text-zinc-500 text-xs ml-2">
                                {{ data_get($testimoni, 'rating', 5) }}/5
                            </span>

                        </div>

                        {{-- TESTI --}}
                        <p class="text-zinc-300 leading-relaxed mb-6 line-clamp-4">

                            “{{ data_get($testimoni, 'text', 'Belum ada testimoni.') }}”

                        </p>

                        {{-- USER --}}
                        <div class="flex items-center justify-between">

                            <div>

                                <h3 class="text-white font-semibold text-lg">
                                    {{ data_get($testimoni, 'author_name', 'Anonymous') }}
                                </h3>

                                <p class="text-zinc-500 text-sm">
                                    {{ data_get($testimoni, 'relative_time_description', 'Baru saja') }}
                                </p>

                            </div>

                            {{-- QUOTE ICON --}}
                            <div class="w-12 h-12 rounded-2xl bg-orange-500/10 flex items-center justify-center">

                                <i class="fas fa-quote-right text-orange-400"></i>

                            </div>

                        </div>

                    </div>

                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-zinc-400">Belum ada testimoni yang tersedia.</p>
                </div>
            @endforelse

        </div>

        {{-- PAGINATION --}}
        @if ($testimonis->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $testimonis->links() }}
            </div>
        @endif

        {{-- BACK BUTTON --}}
        <div class="flex justify-center mt-8">
            <a href="{{ route('frontend.home') }}"
                class="inline-flex items-center gap-3 px-6 py-3 border border-white/20 text-white rounded-2xl font-semibold text-sm tracking-wider hover:bg-white hover:text-black transition-all duration-300">
                <i class="fas fa-arrow-left"></i>
                <span>KEMBALI KE HOME</span>
            </a>
        </div>

    </div>
</section>
@endsection
