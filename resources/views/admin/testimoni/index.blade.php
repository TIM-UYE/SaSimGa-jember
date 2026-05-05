@extends('admin.layout.main')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
        {{ session('error') }}
    </div>
@endif

<div class="flex flex-wrap -mx-3 mb-4">
    <div class="w-full px-3">
        <div class="relative flex flex-col min-w-0 mb-4 wrap-break-words bg-white shadow-soft-xl rounded-2xl">
            <div class="p-4 flex justify-between items-center">
                <h5 class="font-bold">Testimoni</h5>
                <div class="flex flex-wrap gap-2">
                    <form action="{{ route('admin.testimoni.sync') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn-admin">
                            <i class="fas fa-sync-alt mr-1"></i> Sync Google Maps
                        </button>
                    </form>
                    <a href="{{ route('admin.testimoni.create') }}" class="btn-admin">
                        <i class="fas fa-plus mr-1"></i> Tambah Testimoni
                    </a>
                </div>
            </div>
            <div class="p-4 overflow-x-auto">
                <table class="items-center w-full mb-0 align-top border-gray-200 text-gray-700">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Reviewer</th>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Rating</th>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Sumber</th>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Tanggal</th>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Status</th>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonis as $testimoni)
                        <tr>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <div class="flex items-center gap-3">
                                    @if($testimoni->profile_photo_url)
                                        <img src="{{ $testimoni->profile_photo_url }}" alt="{{ $testimoni->author_name }}" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0 text-sm leading-normal">{{ $testimoni->author_name }}</h6>
                                        <p class="mb-0 text-xs text-gray-500">{{ Str::limit($testimoni->text, 60) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <span class="text-yellow-500 text-sm">{{ str_repeat('★', max(1, min(5, $testimoni->rating))) }}</span>
                                <span class="text-gray-500 text-xs">({{ $testimoni->rating }})</span>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <span class="px-2 py-1 text-xs rounded-full {{ $testimoni->source === 'google_maps' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $testimoni->source === 'google_maps' ? 'Google Maps' : 'Manual' }}
                                </span>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                {{ $testimoni->review_date ? $testimoni->review_date->format('d M Y') : '-' }}
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <span class="px-2 py-1 text-xs rounded-full {{ $testimoni->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $testimoni->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <a href="{{ route('admin.testimoni.edit', $testimoni->id) }}" class="btn-admin-secondary">Edit</a>
                                <form action="{{ route('admin.testimoni.destroy', $testimoni->id) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Yakin ingin menghapus testimoni ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-admin-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500">
                                Belum ada testimoni. Silakan tambahkan testimoni atau lakukan sinkronisasi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4">
                {{ $testimonis->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
