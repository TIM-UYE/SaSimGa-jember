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
                <h5 class="font-bold">Edit Menu</h5>
                <a href="{{ route('admin.menu.index') }}" class="btn-admin-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
            <div class="p-4">
                <form action="{{ route('admin.menu.update', $menu) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nama Menu -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="nama_menu">
                                Nama Menu <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_menu" id="nama_menu" value="{{ old('nama_menu', $menu->nama_menu) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="Contoh: Sate Kambing Special" required>
                        </div>

                        <!-- Kategori -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="kategori_id">
                                Kategori
                            </label>
                            <select name="kategori_id" id="kategori_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id', $menu->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Harga -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="harga">
                                Harga (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="harga" id="harga" value="{{ old('harga', $menu->harga) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="25000" min="0" step="100" required>
                        </div>

                        <!-- Stok -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="stok">
                                Stok
                            </label>
                            <input type="number" name="stok" id="stok" value="{{ old('stok', $menu->stok) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="0" min="0">
                        </div>

                        <!-- Ukuran -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="ukuran">
                                Ukuran
                            </label>
                            <input type="text" name="ukuran" id="ukuran" value="{{ old('ukuran', $menu->ukuran) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="Contoh: Kecil, Sedang, Besar">
                        </div>

                        <!-- Durasi Persiapan -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="durasi_persiapan">
                                Durasi Persiapan (menit)
                            </label>
                            <input type="number" name="durasi_persiapan" id="durasi_persiapan" value="{{ old('durasi_persiapan', $menu->durasi_persiapan) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="15" min="1">
                        </div>

                        <!-- Status Tersedia -->
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_available" id="is_available" value="1" {{ old('is_available', $menu->is_available) == 1 ? 'checked' : '' }}
                                    class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                <span class="ml-2 text-sm text-gray-700">Menu Tersedia</span>
                            </label>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="deskripsi">
                            Deskripsi
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="Deskripsi menu...">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
                    </div>

                    <!-- Bahan -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="bahan">
                            Bahan Utama
                        </label>
                        <textarea name="bahan" id="bahan" rows="2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="Contoh: Daging kambing, Bumbu kacang, Bawang merah...">{{ old('bahan', $menu->bahan) }}</textarea>
                    </div>

                    <!-- Gambar -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="gambar">
                            Gambar Menu
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-purple-500 transition">
                            <input type="file" name="gambar" id="gambar" accept="image/*" class="hidden" onchange="previewImage(event)">
                            <label for="gambar" class="cursor-pointer">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-500">Klik untuk upload gambar</p>
                                <p class="text-xs text-gray-400">Format: jpeg, png, jpg, gif, webp (max 2MB)</p>
                            </label>
                        </div>
                        <div id="image-preview" class="mt-2 {{ $menu->gambar ? '' : 'hidden' }}">
                            @if($menu->gambar)
                                <img id="preview-img" src="{{ asset('storage/menu/' . $menu->gambar) }}" alt="Preview" class="w-48 h-48 object-cover rounded-lg">
                            @else
                                <img id="preview-img" src="" alt="Preview" class="w-48 h-48 object-cover rounded-lg">
                            @endif
                        </div>
                        @if($menu->gambar)
                        <p class="mt-2 text-sm text-gray-500">Gambar saat ini: {{ $menu->gambar }}</p>
                        @endif
                    </div>

                    <div class="flex justify-end gap-2 mt-6">
                        <a href="{{ route('admin.menu.index') }}" class="btn-admin-secondary">Batal</a>
                        <button type="submit" class="btn-admin">Update Menu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
