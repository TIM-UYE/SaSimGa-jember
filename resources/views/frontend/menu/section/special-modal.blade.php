<!-- SPECIAL MENU MODAL -->
    <div id="specialMenuModal" onclick="closeSpecialModal(event)"
        class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">

        <div
            class="bg-gradient-to-b from-gray-900 to-black rounded-3xl w-full max-w-5xl border border-gray-800 overflow-hidden">

            <!-- HEADER -->
            <div
                class="sticky top-0 z-20 bg-gray-900/95 backdrop-blur-sm border-b border-gray-800 px-6 py-4 flex items-center justify-between">

                <div>
                    <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                        <i class="fas fa-star text-orange-500"></i>
                        Detail Menu
                    </h2>

                    <p class="text-sm text-gray-400 mt-1">
                        Pilih varian menu spesial yang tersedia
                    </p>
                </div>

                <!-- CLOSE BUTTON -->
                <button onclick="closeSpecialModal()"
                    class="w-11 h-11 rounded-full bg-gray-800 hover:bg-red-500/80 text-white flex items-center justify-center transition-all hover:rotate-90">

                    <i class="fas fa-times text-lg"></i>

                </button>

            </div>

            <!-- BODY -->
            <div class="grid md:grid-cols-2">

                <!-- LEFT -->
                <div class="border-r border-gray-800 p-6">

                    <h2 class="text-2xl font-bold text-white mb-6">
                        Pilih Jenis Tumpeng
                    </h2>

                    <div class="space-y-4">

                        <button onclick="selectSpecialItem('Mini')"
                            class="special-item-btn w-full text-left bg-gray-800 hover:bg-orange-500 p-5 rounded-2xl transition-all text-white">
                            Tumpeng Mini
                        </button>

                        <button onclick="selectSpecialItem('Medium')"
                            class="special-item-btn w-full text-left bg-gray-800 hover:bg-orange-500 p-5 rounded-2xl transition-all text-white">
                            Tumpeng Medium
                        </button>

                        <button onclick="selectSpecialItem('Premium')"
                            class="special-item-btn w-full text-left bg-gray-800 hover:bg-orange-500 p-5 rounded-2xl transition-all text-white">
                            Tumpeng Premium
                        </button>

                    </div>

                </div>

                <!-- RIGHT -->
                <div class="p-8 text-white">

                    <img src="{{ asset('images/menu-special/tumpeng.jpg') }}"
                        class="w-full h-64 object-cover rounded-2xl mb-6">

                    <h3 id="specialTitle" class="text-3xl font-bold mb-3">
                        Tumpeng Mini
                    </h3>

                    <p class="text-orange-400 text-2xl font-bold mb-5">
                        Rp 350.000
                    </p>

                    <p class="text-gray-400 leading-relaxed mb-8">
                        Paket tumpeng lengkap dengan lauk dan garnish premium.
                    </p>

                    <button
                        class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 py-4 rounded-2xl font-bold transition-all hover:scale-[1.02]">
                        Pesan Sekarang
                    </button>

                </div>

            </div>

        </div>

    </div>