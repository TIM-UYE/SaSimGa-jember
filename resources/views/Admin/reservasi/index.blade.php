@extends('admin.layout.main')

@section('content')
<div class="bg-white rounded-xl shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Kelola Reservasi</h2>
            <p class="text-gray-500 text-sm mt-1">Daftar reservasi pelanggan yang masuk</p>
        </div>
        <div class="flex gap-2">
            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium flex items-center gap-1">
                <i class="fas fa-clock"></i> {{ $reservasis->where('status', 'pending')->count() }} Pending
            </span>
            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium flex items-center gap-1">
                <i class="fas fa-check-circle"></i> {{ $reservasis->where('status', 'confirmed')->count() }} Dikonfirmasi
            </span>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Pending</p>
                    <p class="text-2xl font-bold">{{ $reservasis->where('status', 'pending')->count() }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Dikonfirmasi</p>
                    <p class="text-2xl font-bold">{{ $reservasis->where('status', 'confirmed')->count() }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-red-400 to-red-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Dibatalkan</p>
                    <p class="text-2xl font-bold">{{ $reservasis->where('status', 'cancelled')->count() }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <i class="fas fa-times-circle text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Selesai</p>
                    <p class="text-2xl font-bold">{{ $reservasis->where('status', 'completed')->count() }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <i class="fas fa-flag-checkered text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">No. WhatsApp</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Waktu</th>
                    <th class="px-6 py-3">Jumlah Orang</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Dibuat</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservasis as $index => $reservasi)
                <tr class="bg-white border-b hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white text-sm font-bold">
                                {{ strtoupper(substr($reservasi->nama, 0, 1)) }}
                            </div>
                            <span class="font-medium text-gray-900">{{ $reservasi->nama }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if(!empty($reservasi->nomor_wa))
                            <a href="https://wa.me/{{ $reservasi->formatted_wa }}?text=Halo%20{{ urlencode($reservasi->nama) }}%2C%20kami%20dari%20Sate%20Simpang%20Tiga"
                               target="_blank"
                               class="flex items-center gap-1 text-green-600 hover:text-green-700 hover:underline">
                                <i class="fab fa-whatsapp text-lg"></i>
                                <span>{{ $reservasi->nomor_wa }}</span>
                            </a>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi)->isoFormat('D MMMM YYYY') }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($reservasi->waktu_reservasi)->format('H:i') }} WIB</td>
                    <td class="px-6 py-4">
                        <span class="flex items-center gap-1">
                            <i class="fas fa-user text-gray-400 text-xs"></i>
                            {{ $reservasi->jumlah_orang }} orang
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $statusClass = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'confirmed' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                                'completed' => 'bg-blue-100 text-blue-800',
                            ][$reservasi->status] ?? 'bg-gray-100 text-gray-800';

                            $statusLabel = [
                                'pending' => 'Pending',
                                'confirmed' => 'Dikonfirmasi',
                                'cancelled' => 'Dibatalkan',
                                'completed' => 'Selesai',
                            ][$reservasi->status] ?? $reservasi->status;

                            $statusIcon = [
                                'pending' => 'fa-clock',
                                'confirmed' => 'fa-check-circle',
                                'cancelled' => 'fa-times-circle',
                                'completed' => 'fa-flag-checkered',
                            ][$reservasi->status] ?? 'fa-circle';
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusClass }} inline-flex items-center gap-1">
                            <i class="fas {{ $statusIcon }}"></i>
                            {{ $statusLabel }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs">{{ $reservasi->created_at->diffForHumans() }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            {{-- Change Status Dropdown --}}
                            <form action="{{ route('admin.reservasi.updateStatus', $reservasi->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                        class="text-xs border border-gray-300 rounded-lg px-2 py-1 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                    <option value="pending" {{ $reservasi->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                    <option value="confirmed" {{ $reservasi->status == 'confirmed' ? 'selected' : '' }}>✅ Konfirmasi</option>
                                    <option value="cancelled" {{ $reservasi->status == 'cancelled' ? 'selected' : '' }}>❌ Batalkan</option>
                                    <option value="completed" {{ $reservasi->status == 'completed' ? 'selected' : '' }}>🏁 Selesai</option>
                                </select>
                            </form>

                            {{-- Delete Button --}}
                            <form action="{{ route('admin.reservasi.destroy', $reservasi->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus reservasi ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <i class="fas fa-calendar-alt text-5xl mb-4"></i>
                            <p class="text-lg font-medium">Belum ada reservasi</p>
                            <p class="text-sm">Tidak ada data reservasi yang masuk.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('script')
<script>
    // Auto-hide alert after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.querySelector('[x-data]');
        if (alert) {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        }
    });
</script>
@endpush
