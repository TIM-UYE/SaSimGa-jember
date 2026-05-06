<footer class="bg-[var(--color-primary)] text-black py-16">

    <div class="container-main grid md:grid-cols-4 gap-10">

        {{-- BRAND --}}
        <div>

            {{-- DOT --}}
            <div class="flex gap-3 mb-4">

                <div class="w-3 h-3 bg-black rounded-full"></div>
                <div class="w-3 h-3 bg-black rounded-full"></div>
                <div class="w-3 h-3 bg-black rounded-full"></div>

            </div>

            <p class="text-sm text-gray-900">
                Rumah Makan
            </p>

            <h2 class="text-2xl font-bold mt-1">
                Sate Simpangtiga
            </h2>

            <p class="text-sm mt-4 leading-relaxed max-w-xs text-gray-900">
                Menawarkan beragam masakan yang mewakili cita rasa dan budaya kuliner Blitar,
                restoran ini merupakan destinasi kuliner yang menarik bagi pecinta masakan tradisional Indonesia.
            </p>

        </div>


        {{-- QUICK LINK --}}
        <div>

            <h3 class="font-semibold mb-4 text-lg">
                Quick Link
            </h3>

            <ul class="space-y-3 text-sm">

                <li>

                    <a
                        href="{{ route('frontend.home') }}"
                        class="hover:text-white transition duration-300"
                    >
                        Home
                    </a>

                </li>

                <li>

                    <a
                        href="{{ route('frontend.menu') }}"
                        class="hover:text-white transition duration-300"
                    >
                        Menu
                    </a>

                </li>

                <li>

                    <a
                        href="{{ route('frontend.about') }}"
                        class="hover:text-white transition duration-300"
                    >
                        About
                    </a>

                </li>

                <li>

                    <a
                        href="{{ route('frontend.reservasi') }}"
                        class="hover:text-white transition duration-300"
                    >
                        Reservasi
                    </a>

                </li>

            </ul>

        </div>


        {{-- INFORMATION --}}
        <div>

            <h3 class="font-semibold mb-4 text-lg">
                Information
            </h3>

            <ul class="space-y-3 text-sm">

                {{-- FAQ --}}
                <li>

                    <a
                        href="{{ route('frontend.faq') }}"
                        class="hover:text-white transition duration-300"
                    >
                        FAQ'S
                    </a>

                </li>


                {{-- ABOUT --}}
                <li>

                    <a
                        href="{{ route('frontend.about') }}"
                        class="hover:text-white transition duration-300"
                    >
                        About
                    </a>

                </li>


                {{-- PRIVACY --}}
                <li>

                    <a
                        href="{{ route('frontend.privacy') }}"
                        class="hover:text-white transition duration-300"
                    >
                        Privacy Policy
                    </a>

                </li>


                {{-- TERMS --}}
                <li>

                    <a
                        href="{{ route('frontend.terms') }}"
                        class="hover:text-white transition duration-300"
                    >
                        Terms & Conditions
                    </a>

                </li>


                {{-- SUPPORT --}}
                <li>

                    <a
                        href="{{ route('frontend.support') }}"
                        class="hover:text-white transition duration-300"
                    >
                        Support
                    </a>

                </li>

            </ul>

        </div>


        {{-- CONTACT --}}
        <div>

            <h3 class="font-semibold mb-4 text-lg">
                Contact Us
            </h3>

            <div class="space-y-4 text-sm text-gray-900">

                <p class="leading-relaxed">
                    Jln. Jendral Sudirman Nomor 12 Plumpungrejo
                </p>

                <p>
                    📞 +62 812-3456-7890
                </p>

                <p>
                    ✉️ satesimpangtiga@gmail.com
                </p>

            </div>

        </div>

    </div>

</footer>
