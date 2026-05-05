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
                <h5 class="font-bold">Edit Kategori Menu</h5>
                <a href="{{ route('admin.kategori.index') }}" class="btn-admin-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
            <div class="p-4">
                <form action="{{ route('admin.kategori.update', $kategori) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="nama_kategori">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="Contoh: Sate Kambing, Minuman, dll" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="deskripsi">
                            Deskripsi
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="Deskripsi kategori...">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="ikon">
                            Ikon (Font Awesome class)
                        </label>
                        <input type="text" name="ikon" id="ikon" value="{{ old('ikon', $kategori->ikon) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="Contoh: fa-utensils, fa-burger, fa-coffee">
                        <p class="mt-1 text-xs text-gray-500">Gunakan class Font Awesome (tanpa prefix fa-)</p>
                    </div>

                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $kategori->is_active) ? 'checked' : '' }}
                                class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <span class="ml-2 text-sm text-gray-700">Kategori Aktif</span>
                        </label>
                    </div>

                    <div class="flex justify-end gap-2 mt-6">
                        <a href="{{ route('admin.kategori.index') }}" class="btn-admin-secondary">Batal</a>
                        <button type="submit" class="btn-admin">Update Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
