<aside id="sidebar" class="fixed inset-y-0 left-0 z-50 my-4 ml-4 w-64 rounded-2xl bg-linear-to-b from-orange-500 via-orange-600 to-orange-700 shadow-soft-2xl overflow-y-auto custom-scrollbar transition-all duration-500 ease-in-out transform opacity-100 scale-100 translate-x-0">
 
  <!-- LOGO -->
  <div class="px-6 py-6">
    <a href="" class="flex items-center text-white">
      <img src="{{ asset('images/logo/logo.png') }}" class="h-10 w-10 rounded-full mr-3 shadow-md">
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
  <ul class="mt-4 space-y-1 px-3">
 
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
 
    @if(Auth::user()->role === 'manager')
    <!-- MANAJEMEN MENU -->
    <li>
      <button onclick="toggleSection(this)"
              class="w-full group flex items-center px-4 py-3 rounded-lg text-white font-semibold bg-linear-to-r from-orange-400 to-orange-600 hover:from-orange-500 hover:to-orange-700 transition">
        <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-white text-orange-600 mr-3">
          <i class="fas fa-utensils text-sm"></i>
        </div>
        <span class="flex-1 text-left">Manajemen Menu</span>
        <i class="fas fa-chevron-down text-xs transition-transform duration-300 mr-1"></i>
      </button>
      <div class="ml-4 mt-1 space-y-1 hidden">
        <a href="{{ route('admin.kategori.index') }}"
           class="flex items-center pl-12 pr-4 py-2.5 rounded-lg text-white font-semibold hover:bg-white/10 transition {{ request()->routeIs('admin.kategori.*') ? 'bg-white/20' : '' }}">
          <i class="fas fa-tags mr-3 text-sm"></i> Kategori Menu
        </a>
        <a href="{{ route('admin.menu.index') }}"
           class="flex items-center pl-12 pr-4 py-2.5 rounded-lg text-white font-semibold hover:bg-white/10 transition {{ request()->routeIs('admin.menu.*') && !request()->routeIs('admin.menu-specials.*') ? 'bg-white/20' : '' }}">
          <i class="fas fa-book mr-3 text-sm"></i> Menu Regular
        </a>
        <a href="{{ route('admin.menu-specials.index') }}"
           class="flex items-center pl-12 pr-4 py-2.5 rounded-lg text-white font-semibold hover:bg-white/10 transition {{ request()->routeIs('admin.menu-specials.*') ? 'bg-white/20' : '' }}">
          <i class="fas fa-fire mr-3 text-sm"></i> Menu Spesial
        </a>
      </div>
    </li>
 
    <!-- INVENTORI -->
    <li>
      <button onclick="toggleSection(this)"
              class="w-full group flex items-center px-4 py-3 rounded-lg text-white font-semibold bg-linear-to-r from-orange-400 to-orange-600 hover:from-orange-500 hover:to-orange-700 transition">
        <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-white text-orange-600 mr-3">
          <i class="fas fa-boxes text-sm"></i>
        </div>
        <span class="flex-1 text-left">Inventori</span>
        <i class="fas fa-chevron-down text-xs transition-transform duration-300 mr-1"></i>
      </button>
      <div class="ml-4 mt-1 space-y-1 hidden">
        <a href="{{ route('admin.stok.index') }}"
           class="flex items-center pl-12 pr-4 py-2.5 rounded-lg text-white font-semibold hover:bg-white/10 transition {{ request()->routeIs('admin.stok.index') ? 'bg-white/20' : '' }}">
          <i class="fas fa-boxes-stacked mr-3 text-sm"></i> Stok Bahan
        </a>
        <a href="{{ route('admin.stok-log.index') }}"
           class="flex items-center pl-12 pr-4 py-2.5 rounded-lg text-white font-semibold hover:bg-white/10 transition {{ request()->routeIs('admin.stok-log.*') ? 'bg-white/20' : '' }}">
          <i class="fas fa-clock-rotate-left mr-3 text-sm"></i> Riwayat Stok
        </a>
      </div>
    </li>
    @endif
 
    <!-- TRANSAKSI -->
    <li>
      <button onclick="toggleSection(this)"
              class="w-full group flex items-center px-4 py-3 rounded-lg text-white font-semibold bg-linear-to-r from-orange-400 to-orange-600 hover:from-orange-500 hover:to-orange-700 transition">
        <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-white text-orange-600 mr-3">
          <i class="fas fa-shopping-cart text-sm"></i>
        </div>
        <span class="flex-1 text-left">Transaksi</span>
        <i class="fas fa-chevron-down text-xs transition-transform duration-300 mr-1"></i>
      </button>
      <div class="ml-4 mt-1 space-y-1 hidden">
        <a href="{{ route('admin.orders.index') }}"
           class="flex items-center pl-12 pr-4 py-2.5 rounded-lg text-white font-semibold hover:bg-white/10 transition {{ request()->routeIs('admin.orders.*') ? 'bg-white/20' : '' }}">
          <i class="fas fa-shopping-bag mr-3 text-sm"></i> Pesanan
        </a>
        <a href="{{ route('admin.reservasi.index') }}"
           class="flex items-center pl-12 pr-4 py-2.5 rounded-lg text-white font-semibold hover:bg-white/10 transition {{ request()->routeIs('admin.reservasi.*') ? 'bg-white/20' : '' }}">
          <i class="fas fa-calendar-alt mr-3 text-sm"></i> Reservasi
        </a>
        <a href="{{ route('admin.meja.index') }}"
           class="flex items-center pl-12 pr-4 py-2.5 rounded-lg text-white font-semibold hover:bg-white/10 transition {{ request()->routeIs('admin.meja.*') ? 'bg-white/20' : '' }}">
          <i class="fas fa-chair mr-3 text-sm"></i> Meja
        </a>
      </div>
    </li>
 
    @if(Auth::user()->role === 'manager')
    <!-- KONTEN WEBSITE -->
    <li>
      <button onclick="toggleSection(this)"
              class="w-full group flex items-center px-4 py-3 rounded-lg text-white font-semibold bg-linear-to-r from-orange-400 to-orange-600 hover:from-orange-500 hover:to-orange-700 transition">
        <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-white text-orange-600 mr-3">
          <i class="fas fa-palette text-sm"></i>
        </div>
        <span class="flex-1 text-left">Konten Website</span>
        <i class="fas fa-chevron-down text-xs transition-transform duration-300 mr-1"></i>
      </button>
      <div class="ml-4 mt-1 space-y-1 hidden">
        <a href="{{ route('admin.galeri.index') }}"
           class="flex items-center pl-12 pr-4 py-2.5 rounded-lg text-white font-semibold hover:bg-white/10 transition {{ request()->routeIs('admin.galeri.*') ? 'bg-white/20' : '' }}">
          <i class="fas fa-images mr-3 text-sm"></i> Galeri
        </a>
        <a href="{{ route('admin.video.index') }}"
           class="flex items-center pl-12 pr-4 py-2.5 rounded-lg text-white font-semibold hover:bg-white/10 transition {{ request()->routeIs('admin.video.*') ? 'bg-white/20' : '' }}">
          <i class="fas fa-video mr-3 text-sm"></i> Video
        </a>
        <a href="{{ route('admin.information.index') }}"
           class="flex items-center pl-12 pr-4 py-2.5 rounded-lg text-white font-semibold hover:bg-white/10 transition {{ request()->routeIs('admin.information.*') ? 'bg-white/20' : '' }}">
          <i class="fas fa-info-circle mr-3 text-sm"></i> Informasi
        </a>
        <a href="{{ route('admin.testimoni.index') }}"
           class="flex items-center pl-12 pr-4 py-2.5 rounded-lg text-white font-semibold hover:bg-white/10 transition {{ request()->routeIs('admin.testimoni.*') ? 'bg-white/20' : '' }}">
          <i class="fas fa-comments mr-3 text-sm"></i> Testimoni
        </a>
      </div>
    </li>
 
    <!-- PENGGUNA -->
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
 
<script>
function toggleSection(btn) {
  const submenu = btn.nextElementSibling;
  const chevron = btn.querySelector('.fa-chevron-down');
  
  if (submenu.classList.contains('hidden')) {
    submenu.classList.remove('hidden');
    chevron.style.transform = 'rotate(180deg)';
  } else {
    submenu.classList.add('hidden');
    chevron.style.transform = 'rotate(0deg)';
  }
}
 
// Auto open sections that have active children
document.addEventListener('DOMContentLoaded', () => {
  const sections = document.querySelectorAll('#sidebar .mt-1.mb-1');
  sections.forEach(section => {
    const submenu = section.querySelector('.ml-11');
    if (!submenu) return;
    
    const hasActive = submenu.querySelector('.bg-white\\/20');
    if (hasActive) {
      submenu.classList.remove('hidden');
      const chevron = section.querySelector('.fa-chevron-down');
      if (chevron) chevron.style.transform = 'rotate(180deg)';
    }
  });
});
</script>
 
<style>
.custom-scrollbar::-webkit-scrollbar {
  width: 5px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: rgba(255,255,255,0.3);
  border-radius: 20px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background-color: rgba(255,255,255,0.5);
}
</style>
