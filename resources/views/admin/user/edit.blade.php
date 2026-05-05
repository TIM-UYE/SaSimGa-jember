@extends('admin.layout.main')

@section('content')
@if($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="flex flex-wrap -mx-3">
    <div class="w-full px-3">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl">
            <div class="p-4 flex justify-between items-center border-b">
                <h5 class="font-bold">Edit User</h5>
                <a href="{{ route('admin.user.index') }}" class="btn-admin-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
            <div class="p-4">
                <form action="{{ route('admin.user.update', $user->user_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nama -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="nama">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="Contoh: John Doe" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="email">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="Contoh: john@example.com" required>
                        </div>

                        <!-- Password (Optional) -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="password">
                                Password Baru
                            </label>
                            <input type="password" name="password" id="password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="Kosongkan jika tidak ingin mengubah">
                            <p class="mt-1 text-xs text-gray-500">Minimal 6 karakter</p>
                        </div>

                        <!-- Password Confirmation -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="password_confirmation">
                                Konfirmasi Password Baru
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="Ulangi password baru">
                        </div>

                        <!-- Role -->
                        <div class="mb-4 md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="role">
                                Role <span class="text-red-500">*</span>
                            </label>
                            <select name="role" id="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="kasir" {{ old('role', $user->role) == 'kasir' ? 'selected' : '' }}>Kasir</option>
                                <option value="manajer" {{ old('role', $user->role) == 'manajer' ? 'selected' : '' }}>Manajer</option>
                            </select>
                            <p class="mt-1 text-xs text-gray-500">
                                <strong>Admin:</strong> Akses penuh ke sistem<br>
                                <strong>Kasir:</strong> Hanya dapat mengakses transaksi<br>
                                <strong>Manajer:</strong> Dapat melihat laporan dan statistik
                            </p>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 mt-6">
                        <a href="{{ route('admin.user.index') }}" class="btn-admin-secondary">Batal</a>
                        <button type="submit" class="btn-admin">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
