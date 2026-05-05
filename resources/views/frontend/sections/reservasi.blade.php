<section id="reservasi" class="bg-black py-16">

    <div class="container-main">

        {{-- TITLE --}}
        <div class="text-center mb-12 reveal">
            <h2 class="text-4xl font-bold">
                <span class="text-white">Reservasi</span>
                <span class="text-[var(--color-primary)]">Sekarang</span>
            </h2>
        </div>

        {{-- WRAPPER --}}
        <div class="grid md:grid-cols-2 rounded-3xl overflow-hidden border border-white/20">

            {{-- IMAGE --}}
            <div class="h-[300px] md:h-[450px] reveal-scale">
                <img src="{{ asset('images/reservasi/sate.jpg') }}"
                class="w-full object-cover object-center">
            </div>

            {{-- FORM --}}
            <div class="bg-black p-4 md:p-8 reveal delay-200">

                <form action="{{ route('reservasi.store') }}" method="POST" class="space-y-2">
                    @csrf

                    {{-- NAME --}}
                    <div>
                        <label class="text-white text-sm">Nama <span class="text-red-500">*</span></label>
                        <input type="text"
                               name="nama"
                               value="{{ old('nama') }}"
                               placeholder="Masukkan nama Anda"
                               class="input-style @error('nama') border-red-500 @enderror" required>
                        @error('nama')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NO. WHATSAPP --}}
                    <div>
                        <label class="text-white text-sm">No. WhatsApp <span class="text-red-500">*</span></label>
                        <input type="tel"
                               name="nomor_wa"
                               value="{{ old('nomor_wa') }}"
                               placeholder="Contoh: 081234567890"
                               class="input-style @error('nomor_wa') border-red-500 @enderror" required>
                        @error('nomor_wa')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- DATE --}}
                    <div>
                        <label class="text-white text-sm">Tanggal Reservasi <span class="text-red-500">*</span></label>
                        <input type="date"
                               name="tanggal_reservasi"
                               value="{{ old('tanggal_reservasi') }}"
                               class="input-style @error('tanggal_reservasi') border-red-500 @enderror" required>
                        @error('tanggal_reservasi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- TIME --}}
                    <div>
                        <label class="text-white text-sm">Waktu <span class="text-red-500">*</span></label>
                        <input type="time"
                               name="waktu_reservasi"
                               value="{{ old('waktu_reservasi') }}"
                               class="input-style @error('waktu_reservasi') border-red-500 @enderror" required>
                        @error('waktu_reservasi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- PEOPLE --}}
                    <div>
                        <label class="text-white text-sm">Jumlah Orang <span class="text-red-500">*</span></label>
                        <input type="number"
                               name="jumlah_orang"
                               value="{{ old('jumlah_orang') }}"
                               min="1"
                               placeholder="Masukkan jumlah orang"
                               class="input-style @error('jumlah_orang') border-red-500 @enderror" required>
                        @error('jumlah_orang')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- BUTTON --}}
                    <button type="submit"
                            class="w-full bg-[var(--color-primary)] text-black py-3 rounded-lg font-semibold reveal delay-700 hover:scale-[1.02] transition">
                        Reservasi Sekarang
                    </button>

                </form>

            </div>

        </div>

    </div>

</section>
