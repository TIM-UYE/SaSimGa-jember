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

                <form class="space-y-2">

                    {{-- NAME --}}
                    <div>
                        <label class="text-white text-sm">Name</label>
                        <input type="text"
                               placeholder="Enter your name"
                               class="input-style
                               reveal delay-300">
                    </div>

                    {{-- DATE --}}
                    <div>
                        <label class="text-white text-sm">Date</label>
                        <input type="date"
                               class="input-style
                               reveal delay-400">
                    </div>

                    {{-- TIME --}}
                    <div>
                        <label class="text-white text-sm">Time</label>
                        <input type="time"
                               class="input-style
                               reveal delay-500">
                    </div>

                    {{-- PEOPLE --}}
                    <div>
                        <label class="text-white text-sm">People</label>
                        <input type="number"
                               placeholder="Enter number of people"
                               class="input-style
                               reveal delay-600">
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