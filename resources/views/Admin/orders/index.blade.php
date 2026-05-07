@extends('admin.layout.main')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 md:text-3xl">Kelola Pesanan</h1>
            <p class="mt-1 text-sm text-slate-500">Pantau transaksi pelanggan dan status proses pesanan.</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn-admin"><i class="fas fa-sync-alt mr-1"></i>Refresh</a>
    </div>

    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200/80">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="grid grid-cols-1 gap-4 md:grid-cols-4">
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-600">Cari</label>
                <input type="text" name="search" value="{{ $search }}" placeholder="Order ID / Nama / No HP" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
            </div>
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-600">Status</label>
                <select name="status" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    <option value="all">Semua Status</option>
                    @foreach($statusLabels as $value => $label)
                        <option value="{{ $value }}" {{ $status == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-600">Status Pembayaran</label>
                <select name="payment_status" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    <option value="all">Semua Pembayaran</option>
                    @foreach($paymentStatusLabels as $value => $label)
                        <option value="{{ $value }}" {{ $paymentStatus == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="btn-admin w-full"><i class="fas fa-search mr-1"></i>Filter</button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
        <div class="group rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200/80 transition-all hover:shadow-lg hover:shadow-amber-500/10 hover:ring-amber-200">
            <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Pending</p>
            <p class="mt-1 text-3xl font-bold text-slate-800">{{ $orders->where('status', 'pending')->count() }}</p>
        </div>
        <div class="group rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200/80 transition-all hover:shadow-lg hover:shadow-blue-500/10 hover:ring-blue-200">
            <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Diproses</p>
            <p class="mt-1 text-3xl font-bold text-slate-800">{{ $orders->where('status', 'diproses')->count() }}</p>
        </div>
        <div class="group rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200/80 transition-all hover:shadow-lg hover:shadow-emerald-500/10 hover:ring-emerald-200">
            <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Siap Diambil</p>
            <p class="mt-1 text-3xl font-bold text-slate-800">{{ $orders->where('status', 'siap_diambil')->count() }}</p>
        </div>
        <div class="group rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200/80 transition-all hover:shadow-lg hover:shadow-purple-500/10 hover:ring-purple-200">
            <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Selesai</p>
            <p class="mt-1 text-3xl font-bold text-slate-800">{{ $orders->where('status', 'selesai')->count() }}</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200/80">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
            <div class="flex items-center gap-2">
                <i class="fas fa-list text-slate-400"></i>
                <span class="text-sm font-semibold text-slate-700">Daftar Pesanan</span>
                <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-medium text-slate-500"><i class="fas fa-database"></i>{{ $orders->count() }} Data</span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50/80">
                        <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Order ID</th>
                        <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Pelanggan</th>
                        <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Pengiriman</th>
                        <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Pembayaran</th>
                        <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Total</th>
                        <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Status</th>
                        <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">Tanggal</th>
                        <th class="px-6 py-4 text-right text-[11px] font-semibold uppercase tracking-wider text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                        <tr class="group transition-all duration-200 hover:bg-slate-50/60">
                            <td class="px-6 py-4 font-semibold text-slate-800">{{ $order->kode_order }}</td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-800">{{ $order->nama_pelanggan }}</p>
                                <p class="text-xs text-slate-500">{{ $order->nomor_hp }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 rounded-lg px-3 py-1.5 text-xs font-medium ring-1 {{ $order->metode_pengiriman === 'delivery' ? 'bg-blue-50 text-blue-700 ring-blue-200/50' : 'bg-slate-100 text-slate-700 ring-slate-200/70' }}">
                                    <i class="fas {{ $order->metode_pengiriman === 'delivery' ? 'fa-motorcycle' : 'fa-store' }}"></i>
                                    {{ $order->metode_pengiriman === 'delivery' ? 'Delivery' : 'Pickup' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 rounded-lg px-3 py-1.5 text-xs font-medium ring-1 {{ $order->metode_pembayaran === 'cash' ? 'bg-emerald-50 text-emerald-700 ring-emerald-200/50' : 'bg-purple-50 text-purple-700 ring-purple-200/50' }}">
                                    <i class="fas {{ $order->metode_pembayaran === 'cash' ? 'fa-money-bill' : 'fa-qrcode' }}"></i>
                                    {{ strtoupper($order->metode_pembayaran) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <span class="inline-flex items-center rounded-lg px-3 py-1.5 text-xs font-medium ring-1
                                        @if($order->status === 'pending') bg-amber-50 text-amber-700 ring-amber-200/50
                                        @elseif($order->status === 'diproses') bg-blue-50 text-blue-700 ring-blue-200/50
                                        @elseif($order->status === 'siap_diambil') bg-green-50 text-green-700 ring-green-200/50
                                        @elseif($order->status === 'diantar') bg-indigo-50 text-indigo-700 ring-indigo-200/50
                                        @elseif($order->status === 'selesai') bg-emerald-50 text-emerald-700 ring-emerald-200/50
                                        @else bg-red-50 text-red-700 ring-red-200/50
                                        @endif">
                                        {{ $statusLabels[$order->status] ?? $order->status }}
                                    </span>
                                    <span class="inline-flex items-center rounded-lg px-3 py-1.5 text-xs font-medium ring-1 {{ $order->payment_status === 'paid' ? 'bg-emerald-50 text-emerald-700 ring-emerald-200/50' : 'bg-red-50 text-red-700 ring-red-200/50' }}">
                                        {{ $paymentStatusLabels[$order->payment_status] ?? $order->payment_status }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500">{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-admin-secondary"><i class="fas fa-eye"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-16">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-2xl bg-slate-100">
                                        <i class="fas fa-inbox text-3xl text-slate-300"></i>
                                    </div>
                                    <p class="mb-1 text-lg font-semibold text-slate-700">Belum ada pesanan</p>
                                    <p class="text-sm text-slate-400">Tidak ada data pesanan untuk filter saat ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
