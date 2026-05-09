<aside id="sidebar" class="fixed inset-y-0 left-0 z-50 my-4 ml-4 w-64 rounded-2xl bg-linear-to-b from-orange-500 via-orange-600 to-orange-700 shadow-soft-2xl overflow-y-auto transition-all duration-500 ease-in-out transform opacity-100 scale-100 translate-x-0">

  <!-- LOGO -->
  <div class="px-6 py-6">
    <a href="" class="flex items-center text-white">
      <img src="{{ asset('admin_assets/img/logo.png') }}" class="h-10 w-10 rounded-full mr-3 shadow-md">
      <div>
        <div class="font-bold text-lg">SaSimGa</div>
        <div class="text-xs opacity-80">
          @if(Auth::user()->role === 'manager')
            Manager Panel
          @elseif(Auth::user()->role === 'admin')
            Admin Panel
          @else
            Backend Panel
          @endif
        </div>
      </div>
    </a>
  </div>

  <hr class="border-white/20 mx-4">

  <!-- MENU -->
  <ul class="mt-4 space-y-2 px-3">

    <!-- DASHBOARD -->
    <li>
      <a href="{{ route('admin.dashboard') }}"
         class="group flex items-center px-4 py-3 rounded-lg text-white font-semibold bg-linear-to-r from-orange-400 to-orange-600 hover:from-orange-500 hover:to-orange-700 transition">

        <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-white text-orange-600 mr-3">
          <i class="fas fa-tachometer-alt text-sm"></i>
        </div>

        Dashboard
      </a>
    </li>

    {{-- MANAGER ONLY: KATEGORI MENU --}}
    @if(Auth::user()->role === 'manager')
    <li>
      <a href="{{ route('admin.kategori.index') }}"
         class="group flex items-center px-4 py-3 rounded-lg text-white font-semibold bg-linear-to-r from-orange-400 to-orange-600 hover:from-orange-500 hover:to-orange-700 transition">

        <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-white text-orange-600 mr-3">
          <i class="fas fa-tags text-sm"></i>
        </div>

        Kategori Menu
      </a>
    </li>
    @endif

    {{-- MANAGER ONLY: MENU RESTAURANT --}}
    @if(Auth::user()->role === 'manager')
    <li>
      <a href="{{ route('admin.menu.index') }}"
         class="group flex items-center px-4 py-3 rounded-lg text-white font-semibold bg-linear-to-r from-orange-400 to-orange-600 hover:from-orange-500 hover:to-orange-700 transition">

        <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-white text-orange-600 mr-3">
          <i class="fas fa-utensils text-sm"></i>
        </div>

        Menu Restaurant
      </a>
    </li>
    @endif

    {{-- MANAGER ONLY: SPECIAL MENU --}}
    @if(Auth::user()->role === 'manager')
    <li>
        <a
            href="{{ route('admin.menu-specials.index') }}"
            class="group flex items-center px-4 py-3 rounded-lg text-white font-semibold bg-linear-to-r from-orange-400 to-orange-600 hover:from-orange-500 hover:to-orange-700 transition"
        >

            <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-white text-orange-600 mr-3">
                <i class="fas fa-fire text-sm"></i>
            </div>

            Menu Specials
        </a>
    </li>
    @endif

    {{-- MANAGER ONLY: TESTIMONI --}}
    @if(Auth::user()->role === 'manager')
    <li>
        <a
            href="{{ route('admin.testimoni.index') }}"
            class="group flex items-center px-4 py-3 rounded-lg text-white font-semibold bg-linear-to-r from-orange-400 to-orange-600 hover:from-orange-500 hover:to-orange-700 transition"
        >

            <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-white text-orange-600 mr-3">
                <i class="fas fa-comments text-sm"></i>
            </div>

            Testimoni
        </a>
    </li>
    @endif

    <!-- ORDERS (Admin & Manager) -->
    <li>
      <a href="{{ route('admin.orders.index') }}"
         class="group flex items-center px-4 py-3 rounded-lg text-white font-semibold bg-linear-to-r from-orange-400 to-orange-600 hover:from-orange-500 hover:to-orange-700 transition">

        <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-white text-orange-600 mr-3">
          <i class="fas fa-shopping-bag text-sm"></i>
        </div>

        Pesanan
      </a>
    </li>

    <!-- RESERVASI (Admin & Manager) -->
    <li>
      <a href="{{ route('admin.reservasi.index') }}"
         class="group flex items-center px-4 py-3 rounded-lg text-white font-semibold bg-linear-to-r from-orange-400 to-orange-600 hover:from-orange-500 hover:to-orange-700 transition">

        <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-white text-orange-600 mr-3">
          <i class="fas fa-calendar-alt text-sm"></i>
        </div>

        Reservasi
      </a>
    </li>

    {{-- MANAGER ONLY: KELOLA USER --}}
    @if(Auth::user()->role === 'manager')
    <li>
      <a href="{{ route('admin.user.index') }}"
         class="group flex items-center px-4 py-3 rounded-lg text-white font-semibold bg-linear-to-r from-orange-400 to-orange-600 hover:from-orange-500 hover:to-orange-700 transition">

        <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-white text-orange-600 mr-3">
          <i class="fas fa-users text-sm"></i>
        </div>

        Kelola User
      </a>
    </li>
    @endif

    <!-- KEMBALI KE WEBSITE -->
    <li class="pt-4">
      <a href="{{ url('/') }}"
         class="flex items-center px-4 py-3 rounded-lg text-white font-semibold bg-linear-to-r from-orange-700 to-orange-900 hover:from-orange-800 hover:to-orange-950 transition">

        <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-white text-orange-700 mr-3">
          <i class="fas fa-external-link-alt text-sm"></i>
        </div>

        Kembali ke Website
      </a>
    </li>

    <!-- LOGOUT -->
    <li>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit"
                class="w-full group flex items-center px-4 py-3 rounded-lg text-white font-semibold bg-linear-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 transition">

          <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-white text-red-600 mr-3">
            <i class="fas fa-sign-out-alt text-sm"></i>
          </div>

          Logout
        </button>
      </form>
    </li>

  </ul>

</aside>
