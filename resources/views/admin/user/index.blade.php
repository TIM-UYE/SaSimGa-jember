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
                <h5 class="font-bold">Manajemen User</h5>
                <a href="{{ route('admin.user.create') }}" class="btn-admin">Tambah User</a>
            </div>
            <div class="p-4 overflow-x-auto">
                <table class="items-center w-full mb-0 align-top border-gray-200 text-gray-700">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">No</th>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Nama</th>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Email</th>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Role</th>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Tanggal Dibuat</th>
                            <th class="px-6 py-3 text-left uppercase font-semibold text-xs">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                {{ $index + 1 }}
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <h6 class="mb-0 text-sm leading-normal">{{ $user->nama }}</h6>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <p class="mb-0 text-sm">{{ $user->email }}</p>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                @if($user->role == 'admin')
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                        Admin
                                    </span>
                                @elseif($user->role == 'kasir')
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                        kasir
                                    </span>
                                @elseif($user->role == 'manajer')
                                    <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">
                                        Manajer
                                    </span>
                                @endif
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <p class="mb-0 text-sm">{{ $user->created_at->format('d M Y') }}</p>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <a href="{{ route('admin.user.show', $user->user_id) }}" class="btn-admin-secondary">Detail</a>
                                <a href="{{ route('admin.user.edit', $user->user_id) }}" class="btn-admin-secondary ml-2">Edit</a>
                                <form action="{{ route('admin.user.destroy', $user->user_id) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-admin-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500">
                                Tidak ada user yang tersedia. Silakan tambah user baru.
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
