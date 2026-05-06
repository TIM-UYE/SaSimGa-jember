@extends('admin.layout.main')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">Kelola Reservasi</h1>
            <p class="text-slate-500 text-sm mt-1">Daftar reservasi pelanggan yang masuk</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-amber-50 text-amber-700 rounded-xl text-xs font-semibold ring-1 ring-amber-200/50">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                {{ $reservasis->where('status', 'pending')->count() }} Pending
            </span>
            <span class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-50 text-emerald-700 rounded-xl text-xs font-semibold ring-1 ring-emerald-200/50">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                {{ $reservasis->where('status', 'confirmed')->count() }} Dikonfirmasi
            </span>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Pending --}}
        <div class="group relative bg-white rounded-2xl p-5 shadow-sm ring-1 ring-slate-200/80 hover:shadow-lg hover:shadow-amber-500/10 hover:ring-amber-200 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Pending</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ $reservasis->where('status', 'pending')->count() }}</p>
                </div>
                <div class="h-12 w-12 rounded-2xl bg-linear-to-br from-amber-400 to-amber-600 flex items-center justify-center shadow-lg shadow-amber-200/50 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="mt-4 h-1.5 w-full rounded-full bg-amber-100 overflow-hidden">
                <div class="h-full rounded-full bg-linear-to-r from-amber-400 to-amber-600 transition-all duration-500" style="width: {{ $reservasis->count() > 0 ? ($reservasis->where('status', 'pending')->count() / $reservasis->count()) * 100 : 0 }}%"></div>
            </div>
        </div>

        {{-- Dikonfirmasi --}}
        <div class="group relative bg-white rounded-2xl p-5 shadow-sm ring-1 ring-slate-200/80 hover:shadow-lg hover:shadow-emerald-500/10 hover:ring-emerald-200 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Dikonfirmasi</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ $reservasis->where('status', 'confirmed')->count() }}</p>
                </div>
                <div class="h-12 w-12 rounded-2xl bg-linear-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-200/50 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="mt-4 h-1.5 w-full rounded-full bg-emerald-100 overflow-hidden">
                <div class="h-full rounded-full bg-linear-to-r from-emerald-400 to-emerald-600 transition-all duration-500" style="width: {{ $reservasis->count() > 0 ? ($reservasis->where('status', 'confirmed')->count() / $reservasis->count()) * 100 : 0 }}%"></div>
            </div>
        </div>

        {{-- Dibatalkan --}}
        <div class="group relative bg-white rounded-2xl p-5 shadow-sm ring-1 ring-slate-200/80 hover:shadow-lg hover:shadow-red-500/10 hover:ring-red-200 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Dibatalkan</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ $reservasis->where('status', 'cancelled')->count() }}</p>
                </div>
                <div class="h-12 w-12 rounded-2xl bg-linear-to-br from-red-400 to-red-600 flex items-center justify-center shadow-lg shadow-red-200/50 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="mt-4 h-1.5 w-full rounded-full bg-red-100 overflow-hidden">
                <div class="h-full rounded-full bg-linear-to-r from-red-400 to-red-600 transition-all duration-500" style="width: {{ $reservasis->count() > 0 ? ($reservasis->where('status', 'cancelled')->count() / $reservasis->count()) * 100 : 0 }}%"></div>
            </div>
        </div>

        {{-- Selesai --}}
        <div class="group relative bg-white rounded-2xl p-5 shadow-sm ring-1 ring-slate-200/80 hover:shadow-lg hover:shadow-blue-500/10 hover:ring-blue-200 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Selesai</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ $reservasis->where('status', 'completed')->count() }}</p>
                </div>
                <div class="h-12 w-12 rounded-2xl bg-linear-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-200/50 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
            </div>
            <div class="mt-4 h-1.5 w-full rounded-full bg-blue-100 overflow-hidden">
                <div class="h-full rounded-full bg-linear-to-r from-blue-400 to-blue-600 transition-all duration-500" style="width: {{ $reservasis->count() > 0 ? ($reservasis->where('status', 'completed')->count() / $reservasis->count()) * 100 : 0 }}%"></div>
            </div>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/80 overflow-hidden">
        {{-- Table Header --}}
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span class="text-sm font-semibold text-slate-700">Daftar Reservasi</span>
                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-[10px] font-medium">{{ $reservasis->count() }} Total</span>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50/80">
                        <th class="px-6 py-4 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-4 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">No. WhatsApp</th>
                        <th class="px-6 py-4 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-4 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Orang</th>
                        <th class="px-6 py-4 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Dibuat</th>
                        <th class="px-6 py-4 text-right text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reservasis as $index => $reservasi)
                    <tr class="group hover:bg-slate-50/60 transition-all duration-200">
                        <td class="px-6 py-4">
                            <span class="text-slate-400 text-xs font-medium">{{ $index + 1 }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-xl bg-linear-to-br from-orange-400 to-amber-600 flex items-center justify-center text-white text-sm font-bold shadow-sm shadow-orange-200/50 flex-shrink-0">
                                    {{ strtoupper(substr($reservasi->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">{{ $reservasi->nama }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if(!empty($reservasi->nomor_wa))
                                <a href="https://wa.me/{{ $reservasi->formatted_wa }}?text=Halo%20{{ urlencode($reservasi->nama) }}%2C%20kami%20dari%20Sate%20Simpang%20Tiga"
                                   target="_blank"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-lg text-xs font-medium hover:bg-emerald-100 hover:text-emerald-800 transition-all duration-200 ring-1 ring-emerald-200/50">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    {{ $reservasi->nomor_wa }}
                                </a>
                            @else
                                <span class="text-slate-300 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1.5 text-slate-600 text-sm">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi)->isoFormat('D MMM YYYY') }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1.5 text-slate-600 text-sm">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ \Carbon\Carbon::parse($reservasi->waktu_reservasi)->format('H:i') }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-medium">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                {{ $reservasi->jumlah_orang }} org
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusConfig = [
                                    'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'ring' => 'ring-amber-200/50', 'dot' => 'bg-amber-400', 'label' => 'Pending'],
                                    'confirmed' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'ring' => 'ring-emerald-200/50', 'dot' => 'bg-emerald-400', 'label' => 'Dikonfirmasi'],
                                    'cancelled' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'ring' => 'ring-red-200/50', 'dot' => 'bg-red-400', 'label' => 'Dibatalkan'],
                                    'completed' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'ring' => 'ring-blue-200/50', 'dot' => 'bg-blue-400', 'label' => 'Selesai'],
                                ];
                                $cfg = $statusConfig[$reservasi->status] ?? $statusConfig['pending'];
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium ring-1 {{ $cfg['bg'] }} {{ $cfg['text'] }} {{ $cfg['ring'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $cfg['dot'] }}"></span>
                                {{ $cfg['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-400">{{ $reservasi->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                {{-- Status Dropdown --}}
                                <form action="{{ route('admin.reservasi.updateStatus', $reservasi->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()"
                                            class="text-xs bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-2 text-slate-600 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-400 hover:border-slate-300 transition-all duration-200 cursor-pointer">
                                        <option value="pending" {{ $reservasi->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                        <option value="confirmed" {{ $reservasi->status == 'confirmed' ? 'selected' : '' }}>✅ Konfirmasi</option>
                                        <option value="cancelled" {{ $reservasi->status == 'cancelled' ? 'selected' : '' }}>❌ Batalkan</option>
                                        <option value="completed" {{ $reservasi->status == 'completed' ? 'selected' : '' }}>🏁 Selesai</option>
                                    </select>
                                </form>

                                {{-- Delete --}}
                                <form action="{{ route('admin.reservasi.destroy', $reservasi->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus reservasi {{ $reservasi->nama }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all duration-200 group/delete">
                                        <svg class="w-4 h-4 group-hover/delete:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-16">
                            <div class="flex flex-col items-center justify-center">
                                <div class="h-20 w-20 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <p class="text-lg font-semibold text-slate-700 mb-1">Belum ada reservasi</p>
                                <p class="text-sm text-slate-400">Tidak ada data reservasi yang masuk.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
