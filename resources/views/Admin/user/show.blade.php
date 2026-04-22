@extends('admin.layout.main')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="w-full px-3">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl">
            <div class="p-4 flex justify-between items-center border-b">
                <h5 class="font-bold">Detail User</h5>
                <a href="{{ route('admin.user.index') }}" class="btn-admin-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Lengkap
                        </label>
                        <p class="text-gray-800">{{ $user->nama }}</p>
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Email
                        </label>
                        <p class="text-gray-800">{{ $user->email }}</p>
                    </div>

                    <!-- Role -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Role
                        </label>
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
                    </div>

                    <!-- Tanggal Dibuat -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Dibuat
                        </label>
                        <p class="text-gray-800">{{ $user->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <!-- Terakhir Diupdate -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Terakhir Diupdate
                        </label>
                        <p class="text-gray-800">{{ $user->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <a href="{{ route('admin.user.edit', $user->user_id) }}" class="btn-admin">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    @if($user->user_id !== auth()->user()->user_id)
                        <form action="{{ route('admin.user.destroy', $user->user_id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn-admin-danger">Hapus</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
