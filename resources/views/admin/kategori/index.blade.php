@extends('admin.layout.main')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
@endif

<div class="flex flex-wrap -mx-3 mb-4">
    <div class="w-full px-3">
        <div class="relative flex flex-col min-w-0 mb-4 wrap-break-words bg-white shadow-soft-xl rounded-2xl">
            <div class="p-4 flex justify-between items-center">
                <h5 class="font-bold">Kategori Menu</h5>
                <a href="{{ route('admin.kategori.create') }}" class="btn-admin">Tambah Kategori</a>
            </div>
            <div class="p-4 overflow-x-auto">
                <table class="items-center w-full mb-0 align-top border-gray-200 text-gray-700">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">No</th>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Nama Kategori</th>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Deskripsi</th>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Status</th>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $index => $kategori)
                        <tr>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                {{ $index + 1 }}
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <h6 class="mb-0 text-sm leading-normal">{{ $kategori->nama_kategori }}</h6>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <p class="mb-0 text-sm">{{ Str::limit($kategori->deskripsi, 50) }}</p>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <span class="px-2 py-1 text-xs rounded-full {{ $kategori->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $kategori->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <a href="{{ route('admin.kategori.edit', $kategori) }}" class="btn-admin-secondary">Edit</a>
                                <form action="{{ route('admin.kategori.destroy', $kategori) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-admin-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">
                                Tidak ada kategori. Silakan tambah kategori baru.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
