@extends('admin.layout.main')

@section('content')

<div class="flex flex-wrap mt-6">
    <div class="w-full mb-12 px-6">
        <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-soft-xl rounded-2xl bg-white bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-2 rounded-tl-2xl rounded-tr-2xl border-gray-200">
                <div class="flex justify-between items-center">
                    <h6 class="mb-0 font-bold text-lg">
                        <i class="fas fa-shopping-bag mr-2 text-orange-500"></i>
                        Daftar Pesanan
                    </h6>
                    <a href="{{ route('admin.orders.index') }}" class="inline-block px-6 py-2 font-bold text-center text-white align-middle transition-all bg-orange-500 rounded-lg cursor-pointer text-sm leading-tight ease-soft-in tracking-tight-soft">
                        <i class="fas fa-sync-alt mr-1"></i> Refresh
                    </a>
                </div>
            </div>

            <div class="flex-none px-6 pt-4">
                {{-- FILTERS --}}
                <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-6">
                    <div class="flex flex-wrap gap-4">
                        <div class="w-full md:w-1/4">
                            <label class="text-sm font-semibold text-gray-600">Cari</label>
                            <input type="text" name="search" value="{{ $search }}" placeholder="Order ID / Nama / No HP" class="form-control rounded-lg border-gray-300">
                        </div>
                        <div class="w-full md:w-1/4">
                            <label class="text-sm font-semibold text-gray-600">Status</label>
                            <select name="status" class="form-control rounded-lg border-gray-300">
                                <option value="all">Semua Status</option>
                                @foreach($statusLabels as $value => $label)
                                    <option value="{{ $value }}" {{ $status == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full md:w-1/4">
                            <label class="text-sm font-semibold text-gray-600">Status Pembayaran</label>
                            <select name="payment_status" class="form-control rounded-lg border-gray-300">
                                <option value="all">Semua Pembayaran</option>
                                @foreach($paymentStatusLabels as $value => $label)
                                    <option value="{{ $value }}" {{ $paymentStatus == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full md:w-auto flex items-end">
                            <button type="submit" class="inline-block px-6 py-2 font-bold text-center text-white align-middle transition-all bg-blue-500 rounded-lg cursor-pointer text-sm leading-tight ease-soft-in tracking-tight-soft">
                                <i class="fas fa-search mr-1"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>

                {{-- STATS CARDS --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl p-4 text-white">
                        <p class="text-sm opacity-80">Pending</p>
                        <p class="text-2xl font-bold">{{ $orders->where('status', 'pending')->count() }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl p-4 text-white">
                        <p class="text-sm opacity-80">Diproses</p>
                        <p class="text-2xl font-bold">{{ $orders->where('status', 'diproses')->count() }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-xl p-4 text-white">
                        <p class="text-sm opacity-80">Siap Diambil</p>
                        <p class="text-2xl font-bold">{{ $orders->where('status', 'siap_diambil')->count() }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl p-4 text-white">
                        <p class="text-sm opacity-80">Selesai</p>
                        <p class="text-2xl font-bold">{{ $orders->where('status', 'selesai')->count() }}</p>
                    </div>
                </div>

                {{-- TABLE --}}
                <div class="overflow-x-auto">
                    <table class="items-center w-full mb-0 align-top border-gray-300 text-slate-500">
                        <thead class="align-bottom">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Order ID</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pengiriman</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pembayaran</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-gray-900">{{ $order->kode_order }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $order->nama_pelanggan }}</p>
                                            <p class="text-sm text-gray-500">{{ $order->nomor_hp }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->metode_pengiriman === 'delivery' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                            @if($order->metode_pengiriman === 'delivery')
                                                <i class="fas fa-motorcycle mr-1"></i> Delivery
                                            @else
                                                <i class="fas fa-store mr-1"></i> Pickup
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->metode_pembayaran === 'cash' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800' }}">
                                            @if($order->metode_pembayaran === 'cash')
                                                <i class="fas fa-money-bill mr-1"></i> CASH
                                            @else
                                                <i class="fas fa-qrcode mr-1"></i> QRIS
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-gray-900">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-1">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($order->status === 'diproses') bg-blue-100 text-blue-800
                                                @elseif($order->status === 'siap_diambil') bg-green-100 text-green-800
                                                @elseif($order->status === 'diantar') bg-indigo-100 text-indigo-800
                                                @elseif($order->status === 'selesai') bg-emerald-100 text-emerald-800
                                                @elseif($order->status === 'dibatalkan') bg-red-100 text-red-800
                                                @endif">
                                                {{ $statusLabels[$order->status] ?? $order->status }}
                                            </span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($order->payment_status === 'paid') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ $paymentStatusLabels[$order->payment_status] ?? $order->payment_status }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $order->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-block px-3 py-1 font-bold text-center text-white align-middle transition-all bg-blue-500 rounded-lg cursor-pointer text-xs leading-tight ease-soft-in tracking-tight-soft">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                        <p>Belum ada pesanan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
