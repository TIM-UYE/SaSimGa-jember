<nav class="absolute top-0 left-0 w-full z-50">
    <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">

        <div class="flex items-center gap-10">
            {{-- Logo --}}
            <div class=" w-1/20 h-full">
                <img src="{{ asset('images/logo/logo.png') }}">
            </div>

            {{-- Menu --}}
            <div class="space-x-8 hidden md:flex text-sm">
                <a href="{{ route('frontend.home') }}" class="hover:text-orange-400">Home</a>
                <a href="{{ route('frontend.home') }}#menu" class="hover:text-orange-400">Menu</a>
                <a href="#" class="hover:text-orange-400">Reservasi</a>
                <a href="#" class="hover:text-orange-400">About</a>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-400">Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="hover:text-orange-400">Login</a>
                @endauth
            </div>

        </div>

        <div class="absolute top-6 right-6 w-10 h-10 bg-primary rounded-full z-30 border border-b-black"></div>

    </div>
</nav>
