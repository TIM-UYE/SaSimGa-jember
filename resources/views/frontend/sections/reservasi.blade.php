<section id="reservasi" class="relative bg-zinc-950 py-24 overflow-hidden">

    {{-- SUCCESS POPUP --}}
    @if(session('success'))
    <div id="successPopup" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        {{-- Overlay --}}
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeSuccessPopup()"></div>
        {{-- Modal --}}
        <div class="relative bg-zinc-900 border border-zinc-800 rounded-3xl shadow-2xl shadow-black/50 max-w-md w-full p-8 text-center animate-fade-in-up">
            {{-- Close button --}}
            <button onclick="closeSuccessPopup()" class="absolute top-4 right-4 text-zinc-500 hover:text-white transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            {{-- Success icon --}}
            <div class="mx-auto mb-6 h-20 w-20 rounded-full bg-linear-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>

            {{-- Text --}}
            <h3 class="text-2xl font-bold text-white mb-2">Reservasi Berhasil! 🎉</h3>
            <p class="text-zinc-400 text-sm leading-relaxed mb-2">
                {{ session('success') }}
            </p>
            <p class="text-zinc-500 text-xs">
                Silakan cek WhatsApp Anda untuk detail reservasi.
            </p>

            {{-- Button --}}
            <button onclick="closeSuccessPopup()"
                    class="mt-6 w-full rounded-xl bg-linear-to-r from-orange-500 to-amber-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-orange-500/25 hover:shadow-xl hover:shadow-orange-500/40 transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0">
                Tutup
            </button>

            {{-- Decorative dots --}}
            <div class="flex justify-center gap-1.5 mt-4">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500/50"></span>
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500/30"></span>
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500/10"></span>
            </div>
        </div>
    </div>
    <script>
        function closeSuccessPopup() {
            document.getElementById('successPopup').style.display = 'none';
        }
        // Auto close after 10 seconds
        setTimeout(() => {
            const popup = document.getElementById('successPopup');
            if (popup) {
                popup.style.transition = 'opacity 0.5s';
                popup.style.opacity = '0';
                setTimeout(() => popup.style.display = 'none', 500);
            }
        }, 10000);
    </script>
    @endif

    {{-- Background Effects --}}
    <div class="absolute inset-0">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-orange-500/10 rounded-full blur-[128px]"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-orange-600/5 rounded-full blur-[128px]"></div>
    </div>

    <div class="max-w-6xl mx-auto px-6 relative z-10">

        {{-- Header --}}
        <div class="max-w-2xl mx-auto text-center mb-16">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-orange-500/10 text-orange-400 text-xs font-medium tracking-wider uppercase mb-5 ring-1 ring-orange-500/20">
                <span class="w-1.5 h-1.5 rounded-full bg-orange-400 animate-pulse"></span>
                Booking Online
            </span>
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 tracking-tight">
                <span class="text-white">Reservasi</span>
                <span class="text-transparent bg-clip-text bg-linear-to-r from-orange-400 to-amber-500">Sekarang</span>
            </h2>
            <p class="text-zinc-400 text-base leading-relaxed">
                Pesan tempat duduk favorit Anda dan nikmati cita rasa autentik Sate Simpang Tiga bersama keluarga dan teman terdekat.
            </p>
        </div>

        {{-- Card Utama --}}
        <div class="grid md:grid-cols-5 bg-zinc-900/50 rounded-3xl overflow-hidden border border-zinc-800 shadow-2xl shadow-black/50">

            {{-- Image Panel (3 kolom) --}}
            <div class="md:col-span-2 relative h-72 md:h-auto overflow-hidden">
                <div class="absolute inset-0 bg-black/40 z-10"></div>
                <div class="absolute inset-0 bg-linear-to-t from-zinc-900 via-transparent to-transparent z-10"></div>

                <img src="{{ asset('images/reservasi/sate.jpg') }}"
                     alt="Sate Simpang Tiga"
                     class="w-full h-full object-cover object-center transition-all duration-700 hover:scale-110">

                {{-- Info Restoran --}}
                <div class="absolute bottom-0 left-0 right-0 p-6 z-20">
                    <div class="flex items-start gap-3">
                        <div class="w-1 h-12 rounded-full bg-linear-to-b from-orange-400 to-amber-500 mt-1"></div>
                        <div>
                            <h3 class="text-white font-bold text-lg">Sate Simpang Tiga</h3>
                            <p class="text-zinc-400 text-sm mb-2">Jember, Jawa Timur</p>
                            <div class="flex flex-wrap items-center gap-3 text-xs text-zinc-400">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    10:00 - 22:00
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Cozy
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Panel (2 kolom) --}}
            <div class="md:col-span-3 p-6 md:p-8 lg:p-10">

                <form action="{{ route('reservasi.store') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Nama --}}
                    <div>
                        <label class="flex items-center gap-2 text-zinc-300 text-sm font-medium mb-1.5">
                            <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Nama Lengkap <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama Anda"
                               class="w-full px-4 py-3 bg-zinc-800/80 border border-zinc-700 rounded-xl text-white text-sm placeholder-zinc-500 focus:outline-none focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 transition-all duration-300 @error('nama') border-red-500 @enderror" required>
                        @error('nama')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- WhatsApp --}}
                    <div>
                        <label class="flex items-center gap-2 text-zinc-300 text-sm font-medium mb-1.5">
                            <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            No. WhatsApp <span class="text-red-400">*</span>
                        </label>
                        <input type="tel" name="nomor_wa" value="{{ old('nomor_wa') }}" placeholder="Contoh: 081234567890"
                               class="w-full px-4 py-3 bg-zinc-800/80 border border-zinc-700 rounded-xl text-white text-sm placeholder-zinc-500 focus:outline-none focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 transition-all duration-300 @error('nomor_wa') border-red-500 @enderror" required>
                        @error('nomor_wa')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal & Waktu --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="flex items-center gap-2 text-zinc-300 text-sm font-medium mb-1.5">
                                <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Tanggal <span class="text-red-400">*</span>
                            </label>
                            <input type="date" name="tanggal_reservasi" value="{{ old('tanggal_reservasi') }}"
                                   class="w-full px-4 py-3 bg-zinc-800/80 border border-zinc-700 rounded-xl text-white text-sm focus:outline-none focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 transition-all duration-300 [color-scheme:dark] @error('tanggal_reservasi') border-red-500 @enderror" required>
                            @error('tanggal_reservasi')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="flex items-center gap-2 text-zinc-300 text-sm font-medium mb-1.5">
                                <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Waktu <span class="text-red-400">*</span>
                            </label>
                            <input type="time" name="waktu_reservasi" value="{{ old('waktu_reservasi') }}"
                                   class="w-full px-4 py-3 bg-zinc-800/80 border border-zinc-700 rounded-xl text-white text-sm focus:outline-none focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 transition-all duration-300 [color-scheme:dark] @error('waktu_reservasi') border-red-500 @enderror" required>
                            @error('waktu_reservasi')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Jumlah Orang --}}
                    <div>
                        <label class="flex items-center gap-2 text-zinc-300 text-sm font-medium mb-1.5">
                            <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Jumlah Orang <span class="text-red-400">*</span>
                        </label>
                        <input type="number" name="jumlah_orang" value="{{ old('jumlah_orang') }}" min="1" placeholder="Masukkan jumlah orang"
                               class="w-full px-4 py-3 bg-zinc-800/80 border border-zinc-700 rounded-xl text-white text-sm placeholder-zinc-500 focus:outline-none focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10 transition-all duration-300 @error('jumlah_orang') border-red-500 @enderror" required>
                        @error('jumlah_orang')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="pt-2">
                        <button type="submit"
                                class="group relative w-full overflow-hidden rounded-xl bg-linear-to-r from-orange-500 to-amber-600 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-orange-500/25 transition-all duration-300 hover:shadow-xl hover:shadow-orange-500/40 hover:-translate-y-0.5 active:translate-y-0">
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                Pesan Sekarang
                                <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </span>
                            <div class="absolute inset-0 -translate-x-full group-hover:translate-x-0 bg-linear-to-r from-orange-600 to-amber-700 transition-transform duration-500"></div>
                        </button>
                    </div>

                </form>

                <p class="text-zinc-600 text-xs text-center mt-5">
                    Dengan mengirimkan form, Anda menyetujui ketentuan reservasi yang berlaku.
                </p>

            </div>

        </div>

    </div>

</section>
