<section id="reservasi" class="bg-black py-16">

    <div class="container-main">

        {{-- TITLE --}}
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold">
                <span class="text-white">Reservasi</span>
                <span class="text-[var(--color-primary)]">Sekarang</span>
            </h2>
        </div>

        {{-- WRAPPER --}}
        <div class="grid md:grid-cols-2 rounded-3xl overflow-hidden border border-white/20">

            {{-- IMAGE --}}
            <div class="h-[300px] md:h-[500px]">
                <img src="{{ asset('images/reservasi/sate.jpg') }}"
                     class="w-full h-full object-cover">
            </div>

            {{-- FORM --}}
            <div class="bg-black p-4 md:p-8">

                <form class="space-y-2">

                    {{-- NAME --}}
                    <div>
                        <label class="text-white text-sm">Name</label>
                        <input type="text"
                               placeholder="Enter your name"
                               class="input-style">
                    </div>

                    {{-- DATE --}}
                    <div>
                        <label class="text-white text-sm">Date</label>
                        <input type="date"
                               class="input-style">
                    </div>

                    {{-- TIME --}}
                    <div>
                        <label class="text-white text-sm">Time</label>
                        <input type="time"
                               class="input-style">
                    </div>

                    {{-- PEOPLE --}}
                    <div>
                        <label class="text-white text-sm">People</label>
                        <input type="number"
                               placeholder="Enter number of people"
                               class="input-style">
                    </div>

                    {{-- BUTTON --}}
                    <button type="submit"
                            class="w-full bg-[var(--color-primary)] text-black py-3 rounded-lg font-semibold hover:scale-[1.02] transition">
                        Reservasi Sekarang
                    </button>

                </form>

            </div>

        </div>

    </div>

</section>