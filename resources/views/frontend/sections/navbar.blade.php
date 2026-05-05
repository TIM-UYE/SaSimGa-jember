<nav class="fixed bg-black top-0 left-0 w-full z-50">
    <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">

        <div class="flex items-center gap-10">
            {{-- Logo --}}
            <div class=" w-1/20 h-full">
                <img src="{{ asset('images/logo/logo.png') }}">
            </div>

            {{-- Menu --}}
            <div class="space-x-16 hidden md:flex text-sm">
                <a href="{{ route('frontend.home') }}" class="hover:text-orange-400">Home</a>
                <a href="{{ route('frontend.menu') }}" class="hover:text-orange-400">Menu</a>
                <a href="#" class="hover:text-orange-400">Reservasi</a>
                <a href="{{ route('frontend.about') }}"
                class="hover:text-orange-400 {{ request()->routeIs('frontend.about') ? 'text-orange-500' : '' }}">
                About
                </a>

                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-400">Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="hover:text-orange-400">Login</a>
                @endauth
            </div>

        </div>

        <div class="absolute top-6 right-6 z-30">
            @auth
                <button type="button" onclick="openProfileMenu()" class="flex h-10 w-10 items-center justify-center rounded-full bg-primary text-white border border-b-black shadow-lg hover:bg-orange-400 transition">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/profile/' . auth()->user()->profile_photo) }}" alt="Profil" class="h-10 w-10 rounded-full object-cover">
                    @else
                        <span class="font-semibold">{{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}</span>
                    @endif
                </button>
            @else
                <a href="{{ route('login') }}" class="flex h-10 w-10 items-center justify-center rounded-full bg-primary text-white border border-b-black shadow-lg hover:bg-orange-400 transition">
                    <i class="fa fa-user"></i>
                </a>
            @endauth
        </div>

        @auth
            <div id="profileMenuOverlay" class="fixed inset-0 bg-black/30 hidden z-40" onclick="closeProfileMenu()"></div>
            <div id="profileMenuPopup" class="fixed top-20 right-6 z-50 hidden w-64 rounded-3xl border border-slate-200 bg-white shadow-2xl">
                <div class="p-4">
                    <div class="flex items-center gap-3 border-b border-slate-200 pb-4 mb-4">
                        <div class="h-12 w-12 rounded-full overflow-hidden bg-slate-200">
                            @if(auth()->user()->profile_photo)
                                <img src="{{ asset('storage/profile/' . auth()->user()->profile_photo) }}" alt="Profil" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full w-full items-center justify-center text-lg font-semibold text-slate-700">{{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}</div>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->nama }}</p>
                            <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <a href="{{ route('profile') }}" class="block rounded-2xl px-4 py-3 text-sm text-slate-700 hover:bg-slate-100">Pengaturan Profil</a>
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}" class="mt-2 block rounded-2xl px-4 py-3 text-sm text-slate-700 hover:bg-slate-100">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full rounded-2xl bg-red-500 px-4 py-3 text-sm font-semibold text-white hover:bg-red-600 transition">Logout</button>
                    </form>
                </div>
            </div>
            <script>
                function openProfileMenu() {
                    document.getElementById('profileMenuOverlay').classList.remove('hidden');
                    document.getElementById('profileMenuPopup').classList.remove('hidden');
                }

                function closeProfileMenu() {
                    document.getElementById('profileMenuOverlay').classList.add('hidden');
                    document.getElementById('profileMenuPopup').classList.add('hidden');
                }
            </script>
        @endauth

    </div>
</nav>
