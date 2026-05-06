@extends('admin.layout.main')

@section('content')

<div class="flex flex-wrap mt-6">
    <div class="w-full mb-12 px-6">
        <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-soft-xl rounded-2xl bg-white bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-2 rounded-tl-2xl rounded-tr-2xl border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <a href="{{ route('admin.orders.index') }}" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <h6 class="mt-2 mb-0 font-bold text-lg">
                            <i class="fas fa-shopping-bag mr-2 text-orange-500"></i>
                            Detail Pesanan - {{ $order->kode_order }}
                        </h6>
                    </div>
                </div>
            </div>

            <div class="flex-none px-6 pt-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2">
                        {{-- CUSTOMER INFO --}}
                        <div class="bg-gray-50 rounded-xl p-6 mb-6">
                            <h6 class="font-bold text-gray-700 mb-4">
                                <i class="fas fa-user mr-2 text-blue-500"></i>Informasi Pelanggan
                            </h6>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Nama</p>
                                    <p class="font-semibold">{{ $order->nama_pelanggan }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Nomor HP</p>
                                    <p class="font-semibold">{{ $order->nomor_hp }}</p>
                                </div>
                                @if($order->alamat)
                                    <div class="col-span-2">
                                        <p class="text-sm text-gray-500">Alamat</p>
                                        <p class="font-semibold">{{ $order->alamat }}</p>
                                    </div>
                                @endif
                                @if($order->catatan)
                                    <div class="col-span-2">
                                        <p class="text-sm text-gray-500">Catatan</p>
                                        <p class="font-semibold">{{ $order->catatan }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- ORDER ITEMS --}}
                        <div class="bg-gray-50 rounded-xl p-6 mb-6">
                            <h6 class="font-bold text-gray-700 mb-4">
                                <i class="fas fa-list mr-2 text-green-500"></i>Detail Pesanan
                            </h6>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="border-b border-gray-200">
                                            <th class="text-left py-2 text-sm font-semibold text-gray-600">Menu</th>
                                            <th class="text-center py-2 text-sm font-semibold text-gray-600">Qty</th>
                                            <th class="text-right py-2 text-sm font-semibold text-gray-600">Harga</th>
                                            <th class="text-right py-2 text-sm font-semibold text-gray-600">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                            <tr class="border-b border-gray-100">
                                                <td class="py-3">{{ $item->nama_menu }}</td>
                                                <td class="py-3 text-center">{{ $item->qty }}</td>
                                                <td class="py-3 text-right">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                                <td class="py-3 text-right font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="pt-4 text-right font-bold text-gray-700">Subtotal</td>
                                            <td class="pt-4 text-right font-bold">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="pt-2 text-right font-bold text-gray-700">Total Bayar</td>
                                            <td class="pt-2 text-right font-bold text-xl text-orange-500">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        {{-- STATUS CARD --}}
                        <div class="bg-gray-50 rounded-xl p-6 mb-6">
                            <h6 class="font-bold text-gray-700 mb-4">
                                <i class="fas fa-info-circle mr-2 text-purple-500"></i>Status Pesanan
                            </h6>

                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500">Status</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'diproses') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'siap_diambil') bg-green-100 text-green-800
                                        @elseif($order->status === 'diantar') bg-indigo-100 text-indigo-800
                                        @elseif($order->status === 'selesai') bg-emerald-100 text-emerald-800
                                        @elseif($order->status === 'dibatalkan') bg-red-100 text-red-800
                                        @endif">
                                        {{ $statusLabels[$order->status] ?? $order->status }}
                                    </span>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">Status Pembayaran</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if($order->payment_status === 'paid') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ $paymentStatusLabels[$order->payment_status] ?? $order->payment_status }}
                                    </span>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">Metode Pengiriman</p>
                                    <p class="font-semibold">{{ $deliveryMethodLabels[$order->metode_pengiriman] ?? $order->metode_pengiriman }}</p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">Metode Pembayaran</p>
                                    <p class="font-semibold">{{ $paymentMethodLabels[$order->metode_pembayaran] ?? $order->metode_pembayaran }}</p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">Dibuat</p>
                                    <p class="font-semibold">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">Terakhir Diupdate</p>
                                    <p class="font-semibold">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- UPDATE STATUS --}}
                        @if($order->isActive())
                            <div class="bg-gray-50 rounded-xl p-6 mb-6">
                                <h6 class="font-bold text-gray-700 mb-4">
                                    <i class="fas fa-edit mr-2 text-orange-500"></i>Update Status
                                </h6>

                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-4">
                                        <label class="text-sm font-semibold text-gray-600 mb-2 block">Status Pesanan</label>
                                        <select name="status" class="form-control rounded-lg border-gray-300">
                                            @foreach($statusLabels as $value => $label)
                                                <option value="{{ $value }}" {{ $order->status == $value ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="submit" class="w-full inline-block px-6 py-2 font-bold text-center text-white align-middle transition-all bg-orange-500 rounded-lg cursor-pointer text-sm leading-tight ease-soft-in tracking-tight-soft">
                                        <i class="fas fa-save mr-1"></i> Update Status
                                    </button>
                                </form>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-6 mb-6">
                                <h6 class="font-bold text-gray-700 mb-4">
                                    <i class="fas fa-credit-card mr-2 text-green-500"></i>Update Pembayaran
                                </h6>

                                <form action="{{ route('admin.orders.updatePaymentStatus', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-4">
                                        <label class="text-sm font-semibold text-gray-600 mb-2 block">Status Pembayaran</label>
                                        <select name="payment_status" class="form-control rounded-lg border-gray-300">
                                            @foreach($paymentStatusLabels as $value => $label)
                                                <option value="{{ $value }}" {{ $order->payment_status == $value ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="submit" class="w-full inline-block px-6 py-2 font-bold text-center text-white align-middle transition-all bg-green-500 rounded-lg cursor-pointer text-sm leading-tight ease-soft-in tracking-tight-soft">
                                        <i class="fas fa-save mr-1"></i> Update Pembayaran
                                    </button>
                                </form>
                            </div>
                        @endif

                        {{-- ACTIONS --}}
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h6 class="font-bold text-gray-700 mb-4">
                                <i class="fas fa-cog mr-2 text-gray-500"></i>Aksi Lainnya
                            </h6>

                            <div class="space-y-3">
                                @if($order->isActive())
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full inline-block px-6 py-2 font-bold text-center text-white align-middle transition-all bg-red-500 rounded-lg cursor-pointer text-sm leading-tight ease-soft-in tracking-tight-soft">
                                            <i class="fas fa-times mr-1"></i> Batalkan Pesanan
                                        </button>
                                    </form>
                                @endif

                                <a href="https://wa.me/{{ $order->nomor_hp }}" target="_blank" class="w-full inline-block px-6 py-2 font-bold text-center text-white align-middle transition-all bg-green-500 rounded-lg cursor-pointer text-sm leading-tight ease-soft-in tracking-tight-soft">
                                    <i class="fab fa-whatsapp mr-1"></i> Hubungi Pelanggan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
