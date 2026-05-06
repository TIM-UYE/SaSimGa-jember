<section class="relative bg-black py-24 overflow-hidden">

    {{-- HEADER --}}
    <div class="max-w-2xl mx-auto text-center mb-16 reveal">
        <span
            class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-orange-500/10 text-orange-400 text-xs font-medium tracking-wider uppercase mb-5 ring-1 ring-orange-500/20">
            <span class="w-1.5 h-1.5 rounded-full bg-orange-400 animate-pulse"></span>
            Sate Simpang Tiga
        </span>
        <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 tracking-tight">
            <span class="text-white">Tentang</span>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-amber-500">
                Kami
            </span>
        </h2>
        <p class="text-zinc-400 text-base leading-relaxed">
            Mengenal lebih dekat cita rasa autentik khas Sate Simpang Tiga.
        </p>
    </div>

    <div class="container-main grid grid-cols-1 md:grid-cols-2 items-center gap-16">

        {{-- KIRI: IMAGE --}}
        <div class="relative reveal-left group">

            {{-- IMAGE --}}
            <img src="{{ asset('images/about/depan.jpg') }}"
                class="w-full h-[550px] object-cover rounded-3xl shadow-2xl shadow-orange-500/10">
            
                {{-- OVERLAY GLOW --}}
            <div class="absolute inset-0 rounded-3xl bg-gradient-to-t from-black/50 via-transparent to-transparent">
            </div>

            {{-- FLOATING CARD --}}
            <div
                class="absolute bottom-6 left-6 bg-black/70 backdrop-blur-md border border-white/10 rounded-2xl px-5 py-4">
                <p class="text-white text-lg font-semibold">
                    Sejak 1975
                </p>
                <p class="text-zinc-400 text-sm">
                    Menyajikan cita rasa terbaik
                </p>
            </div>
        </div>

        {{-- KANAN: CONTENT --}}
        <div class="relative z-10 reveal-right delay-200">
            
            {{-- SMALL LABEL --}}
            <span
                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-orange-500/10 text-orange-400 text-xs font-medium tracking-[0.2em] uppercase ring-1 ring-orange-500/20 mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-orange-400 animate-pulse"></span>
                Rajanya Sate
            </span>
            
            {{-- TITLE --}}
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight tracking-tight">
                <span class="text-white">
                    Cita Rasa Autentik
                </span>
                <br>
                <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500">
                    Sate Simpang Tiga
                </span>
            </h2>

            {{-- DESCRIPTION --}}
            <p class="text-zinc-400 mt-6 text-base leading-relaxed max-w-xl">
                Menghadirkan sate khas Indonesia dengan bahan segar, bumbu autentik,
                dan aroma bakaran arang yang khas untuk menciptakan pengalaman makan
                yang hangat, lezat, dan berkesan di setiap sajian.
            </p>

            {{-- FEATURES --}}
            <div class="grid grid-cols-2 gap-4 mt-10">
                
                <div
                    class="bg-zinc-900/70 border border-white/5 rounded-2xl p-5 hover:border-orange-500/30 transition-all">
                    <div class="w-12 h-12 rounded-xl bg-orange-500/10 flex items-center justify-center mb-4">
                        <i class="fas fa-fire text-orange-400"></i>
                    </div>
                    <h3 class="text-white font-medium mb-2">
                        Dibakar Arang
                    </h3>
                    <p class="text-zinc-400 text-sm">
                        Aroma khas bakaran tradisional yang menggugah selera.
                    </p>
                </div>

                <div
                    class="bg-zinc-900/70 border border-white/5 rounded-2xl p-5 hover:border-orange-500/30 transition-all">
                    <div class="w-12 h-12 rounded-xl bg-orange-500/10 flex items-center justify-center mb-4">
                        <i class="fas fa-utensils text-orange-400"></i>
                    </div>
                    <h3 class="text-white font-medium mb-2">
                        Bahan Premium
                    </h3>
                    <p class="text-zinc-400 text-sm">
                        Menggunakan bahan segar dan bumbu pilihan terbaik.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
