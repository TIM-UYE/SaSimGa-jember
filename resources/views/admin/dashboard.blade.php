@extends('admin.layout.main')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">Dashboard</h1>
            <p class="text-slate-500 text-sm mt-1">Selamat datang kembali, <span class="font-semibold text-slate-700">{{ Auth::user()->nama }}</span>!</p>
        </div>
        <div class="flex items-center gap-2 text-xs text-slate-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <span>{{ now()->isoFormat('dddd, D MMMM YYYY') }}</span>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">

        {{-- Total Users --}}
        <div class="group relative bg-white rounded-2xl p-5 shadow-sm ring-1 ring-slate-200/80 hover:shadow-lg hover:shadow-purple-500/10 hover:ring-purple-200 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="h-11 w-11 rounded-2xl bg-linear-to-br from-purple-400 to-purple-600 flex items-center justify-center shadow-lg shadow-purple-200/50 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                </div>
                <span class="text-[10px] font-medium text-purple-500 bg-purple-50 px-2 py-1 rounded-lg">+ Aktif</span>
            </div>
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider mb-0.5">Total Users</p>
            <p class="text-2xl font-bold text-slate-800">{{ \App\Models\User::where('role', 'user')->count() }}</p>
            <div class="mt-3 h-1 w-full rounded-full bg-purple-100 overflow-hidden">
                <div class="h-full w-3/4 rounded-full bg-linear-to-r from-purple-400 to-purple-600"></div>
            </div>
        </div>

        {{-- Total Menu --}}
        <div class="group relative bg-white rounded-2xl p-5 shadow-sm ring-1 ring-slate-200/80 hover:shadow-lg hover:shadow-blue-500/10 hover:ring-blue-200 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="h-11 w-11 rounded-2xl bg-linear-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-200/50 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <span class="text-[10px] font-medium text-blue-500 bg-blue-50 px-2 py-1 rounded-lg">{{ \App\Models\KategoriMenu::count() }} Kat</span>
            </div>
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider mb-0.5">Total Menu</p>
            <p class="text-2xl font-bold text-slate-800">{{ \App\Models\Menu::count() }}</p>
            <div class="mt-3 h-1 w-full rounded-full bg-blue-100 overflow-hidden">
                <div class="h-full w-full rounded-full bg-linear-to-r from-blue-400 to-blue-600"></div>
            </div>
        </div>

        {{-- Transaksi Hari Ini --}}
        <div class="group relative bg-white rounded-2xl p-5 shadow-sm ring-1 ring-slate-200/80 hover:shadow-lg hover:shadow-emerald-500/10 hover:ring-emerald-200 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="h-11 w-11 rounded-2xl bg-linear-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-200/50 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                </div>
                <span class="text-[10px] font-medium text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">Hari Ini</span>
            </div>
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider mb-0.5">Transaksi</p>
            <p class="text-2xl font-bold text-slate-800">{{ \App\Models\Transaksi::whereDate('created_at', today())->count() }}</p>
            <div class="mt-3 h-1 w-full rounded-full bg-emerald-100 overflow-hidden">
                <div class="h-full w-2/3 rounded-full bg-linear-to-r from-emerald-400 to-emerald-600"></div>
            </div>
        </div>

        {{-- Total Pendapatan --}}
        <div class="group relative bg-white rounded-2xl p-5 shadow-sm ring-1 ring-slate-200/80 hover:shadow-lg hover:shadow-orange-500/10 hover:ring-orange-200 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="h-11 w-11 rounded-2xl bg-linear-to-br from-orange-400 to-amber-600 flex items-center justify-center shadow-lg shadow-orange-200/50 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-[10px] font-medium text-orange-500 bg-orange-50 px-2 py-1 rounded-lg">Total</span>
            </div>
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider mb-0.5">Pendapatan</p>
            <p class="text-xl font-bold text-slate-800">Rp {{ number_format(\App\Models\Transaksi::sum('total_harga'), 0, ',', '.') }}</p>
            <div class="mt-3 h-1 w-full rounded-full bg-orange-100 overflow-hidden">
                <div class="h-full w-4/5 rounded-full bg-linear-to-r from-orange-400 to-amber-600"></div>
            </div>
        </div>

        {{-- Reservasi Pending --}}
        <div class="group relative bg-white rounded-2xl p-5 shadow-sm ring-1 ring-slate-200/80 hover:shadow-lg hover:shadow-rose-500/10 hover:ring-rose-200 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="h-11 w-11 rounded-2xl bg-linear-to-br from-rose-400 to-rose-600 flex items-center justify-center shadow-lg shadow-rose-200/50 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <span class="text-[10px] font-medium text-rose-500 bg-rose-50 px-2 py-1 rounded-lg animate-pulse">Menunggu</span>
            </div>
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider mb-0.5">Reservasi Pending</p>
            <p class="text-2xl font-bold text-slate-800">{{ \App\Models\Reservasi::where('status', 'pending')->count() }}</p>
            <div class="mt-3 h-1 w-full rounded-full bg-rose-100 overflow-hidden">
                <div class="h-full w-1/2 rounded-full bg-linear-to-r from-rose-400 to-rose-600"></div>
            </div>
        </div>

    </div>

    {{-- BOTTOM ROW: Recent Activity & Quick Actions --}}
    <div class="grid lg:grid-cols-2 gap-6">

        {{-- Recent Activity --}}
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/80 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span class="text-sm font-semibold text-slate-700">Aktivitas Terbaru</span>
                </div>
                <a href="{{ route('admin.reservasi.index') }}" class="text-xs text-orange-500 hover:text-orange-600 font-medium hover:underline">Lihat Semua</a>
            </div>
            <div class="divide-y divide-slate-100">
                @php
                    $recentReservasis = \App\Models\Reservasi::latest()->take(5)->get();
                @endphp
                @forelse($recentReservasis as $reservasi)
                    @php
                        $statusColor = [
                            'pending' => 'bg-amber-400',
                            'confirmed' => 'bg-emerald-400',
                            'cancelled' => 'bg-red-400',
                            'completed' => 'bg-blue-400',
                        ][$reservasi->status] ?? 'bg-slate-400';
                    @endphp
                    <div class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50/60 transition-all duration-200">
                        <div class="h-9 w-9 rounded-xl bg-linear-to-br from-orange-400 to-amber-600 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                            {{ strtoupper(substr($reservasi->nama, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $reservasi->nama }}</p>
                            <p class="text-xs text-slate-400 truncate">
                                {{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi)->isoFormat('D MMM YYYY') }} •
                                {{ $reservasi->jumlah_orang }} orang
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full {{ $statusColor }}"></span>
                            <span class="text-xs text-slate-400">{{ $reservasi->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center">
                        <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-sm text-slate-500">Belum ada aktivitas reservasi</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Quick Actions Menu --}}
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/80 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span class="text-sm font-semibold text-slate-700">Aksi Cepat</span>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('admin.menu.index') }}"
                       class="group flex flex-col items-center gap-3 p-5 rounded-2xl bg-linear-to-br from-orange-50 to-amber-50 ring-1 ring-orange-200/50 hover:ring-orange-300/60 hover:shadow-lg hover:shadow-orange-200/30 transition-all duration-300">
                        <div class="h-12 w-12 rounded-2xl bg-linear-to-br from-orange-400 to-amber-500 flex items-center justify-center shadow-md shadow-orange-200/50 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-semibold text-slate-700">Kelola Menu</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ \App\Models\Menu::count() }} item</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.reservasi.index') }}"
                       class="group flex flex-col items-center gap-3 p-5 rounded-2xl bg-linear-to-br from-sky-50 to-blue-50 ring-1 ring-sky-200/50 hover:ring-sky-300/60 hover:shadow-lg hover:shadow-sky-200/30 transition-all duration-300">
                        <div class="h-12 w-12 rounded-2xl bg-linear-to-br from-sky-400 to-blue-500 flex items-center justify-center shadow-md shadow-sky-200/50 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-semibold text-slate-700">Reservasi</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ \App\Models\Reservasi::where('status', 'pending')->count() }} pending</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.user.index') }}"
                       class="group flex flex-col items-center gap-3 p-5 rounded-2xl bg-linear-to-br from-emerald-50 to-green-50 ring-1 ring-emerald-200/50 hover:ring-emerald-300/60 hover:shadow-lg hover:shadow-emerald-200/30 transition-all duration-300">
                        <div class="h-12 w-12 rounded-2xl bg-linear-to-br from-emerald-400 to-green-500 flex items-center justify-center shadow-md shadow-emerald-200/50 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-semibold text-slate-700">Users</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ \App\Models\User::where('role', 'user')->count() }} terdaftar</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.kategori.index') }}"
                       class="group flex flex-col items-center gap-3 p-5 rounded-2xl bg-linear-to-br from-violet-50 to-purple-50 ring-1 ring-violet-200/50 hover:ring-violet-300/60 hover:shadow-lg hover:shadow-violet-200/30 transition-all duration-300">
                        <div class="h-12 w-12 rounded-2xl bg-linear-to-br from-violet-400 to-purple-500 flex items-center justify-center shadow-md shadow-violet-200/50 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-semibold text-slate-700">Kategori</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ \App\Models\KategoriMenu::count() }} kategori</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- Welcome Card --}}
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/80 overflow-hidden">
        <div class="px-6 py-5 flex items-start gap-4">
            <div class="h-14 w-14 rounded-2xl bg-linear-to-br from-orange-400 to-amber-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-orange-200/50">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-slate-800">Selamat Datang di Dashboard SaSimGa!</h2>
                <p class="text-sm text-slate-500 mt-1 leading-relaxed">
                    Anda memiliki akses penuh untuk mengelola sistem. Gunakan menu navigasi di samping untuk mengelola menu, reservasi, pengguna, dan konten lainnya.
                </p>
            </div>
        </div>
    </div>

</div>
@endsection
