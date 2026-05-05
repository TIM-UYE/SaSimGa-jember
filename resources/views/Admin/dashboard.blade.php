@extends('admin.layout.main')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
    <div class="bg-gradient-to-r from-purple-600 to-purple-400 rounded-xl p-6 text-white shadow-lg">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm opacity-80">Total Users</p>
                <p class="text-3xl font-bold">{{ \App\Models\User::where('role', 'user')->count() }}</p>
            </div>
            <div class="bg-white/20 p-3 rounded-lg">
                <i class="fas fa-users text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-blue-600 to-blue-400 rounded-xl p-6 text-white shadow-lg">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm opacity-80">Total Menu</p>
                <p class="text-3xl font-bold">{{ \App\Models\Menu::count() }}</p>
            </div>
            <div class="bg-white/20 p-3 rounded-lg">
                <i class="fas fa-utensils text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-green-600 to-green-400 rounded-xl p-6 text-white shadow-lg">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm opacity-80">Transaksi Hari Ini</p>
                <p class="text-3xl font-bold">{{ \App\Models\Transaksi::whereDate('created_at', today())->count() }}</p>
            </div>
            <div class="bg-white/20 p-3 rounded-lg">
                <i class="fas fa-shopping-cart text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-orange-600 to-orange-400 rounded-xl p-6 text-white shadow-lg">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm opacity-80">Total Pendapatan</p>
                <p class="text-3xl font-bold">Rp {{ number_format(\App\Models\Transaksi::sum('total_harga'), 0, ',', '.') }}</p>
            </div>
            <div class="bg-white/20 p-3 rounded-lg">
                <i class="fas fa-wallet text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-yellow-600 to-yellow-400 rounded-xl p-6 text-white shadow-lg">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm opacity-80">Reservasi Pending</p>
                <p class="text-3xl font-bold">{{ \App\Models\Reservasi::where('status', 'pending')->count() }}</p>
            </div>
            <div class="bg-white/20 p-3 rounded-lg">
                <i class="fas fa-calendar-alt text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-md p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Selamat Datang, {{ Auth::user()->nama }}!</h2>
    <p class="text-gray-600">Ini adalah halaman dashboard admin. Anda memiliki akses penuh untuk mengelola sistem.</p>
</div>
@endsection
