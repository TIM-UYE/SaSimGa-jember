@extends('admin.layout.main')

@section('content')
@if(session('success'))
    <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
        <p class="mb-2 font-semibold"><i class="fas fa-exclamation-circle mr-2"></i>Periksa kembali data special:</p>
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-6">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 md:text-3xl">Edit Menu Special</h1>
            <p class="mt-1 text-sm text-slate-500">Perbarui banner, deskripsi, atau status special menu untuk tampilan premium.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.menu-specials.index') }}" class="btn-admin-secondary"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
            <button type="button" onclick="openItemModal()" class="btn-admin"><i class="fas fa-plus mr-1"></i>Tambah Varian Menu</button>
        </div>
    </div>

    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/80">
        <form action="{{ route('admin.menu-specials.update', $special) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid gap-4 md:grid-cols-2">
                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700" for="title">Judul Special <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $special->title) }}" required
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 focus:border-orange-400 focus:ring-orange-200 focus:ring-2" placeholder="Contoh: Special Tumpeng Premium">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700" for="short_description">Deskripsi Singkat</label>
                        <textarea name="short_description" id="short_description" rows="5" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 focus:border-orange-400 focus:ring-orange-200 focus:ring-2" placeholder="Deskripsi singkat mengenai menu special.">{{ old('short_description', $special->short_description) }}</textarea>
                    </div>

                    <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-5 text-center transition hover:border-orange-400">
                        <input type="file" name="banner_image" id="banner_image" accept="image/*" class="hidden" onchange="previewBanner(event)">
                        <label for="banner_image" class="cursor-pointer">
                            <i class="fas fa-cloud-upload-alt mb-3 text-4xl text-slate-400"></i>
                            <p class="font-semibold text-slate-700">Unggah banner baru</p>
                            <p class="text-xs text-slate-500">Format: jpeg, png, jpg, gif, webp. Maksimum 4MB.</p>
                        </label>
                    </div>

                    <div id="banner-preview" class="{{ $special->banner_image ? '' : 'hidden' }}">
                        <p class="mb-2 text-sm font-semibold text-slate-600">Preview Banner</p>
                        <img id="banner-preview-img" src="{{ $special->banner_image ? asset('storage/' . $special->banner_image) : '' }}" alt="Banner Preview" class="h-64 w-full rounded-3xl object-cover ring-1 ring-slate-200">
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                        <label class="flex items-center gap-3">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $special->is_active) ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-orange-500 focus:ring-orange-500">
                            <span class="text-sm font-semibold text-slate-700">Aktifkan menu special</span>
                        </label>
                        <p class="mt-3 text-sm text-slate-500">Jika diaktifkan, special akan muncul di halaman menu untuk pelanggan.</p>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-orange-50 p-5">
                        <h2 class="text-lg font-semibold text-slate-800">Info Banner</h2>
                        <p class="mt-3 text-sm text-slate-500">Gunakan gambar banner gelap atau kontras tinggi dengan aksen orange untuk tampilan premium.</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                <a href="{{ route('admin.menu-specials.index') }}" class="btn-admin-secondary">Batal</a>
                <button type="submit" class="btn-admin">Simpan Perubahan</button>
            </div>
        </form>
    </div>

    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/80">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-800">Daftar Varian Menu</h2>
                <p class="mt-1 text-sm text-slate-500">Kelola varian menu untuk special ini. Klik edit untuk mengubah detail varian.</p>
            </div>
            <button type="button" onclick="openItemModal()" class="btn-admin"><i class="fas fa-plus mr-1"></i>Tambah Varian</button>
        </div>

        <div class="overflow-x-auto mt-4">
            <table class="w-full min-w-[920px] text-left text-sm text-slate-600">
                <thead>
                    <tr class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-4">Gambar</th>
                        <th class="px-6 py-4">Nama Varian</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($special->items as $item)
                    <tr class="hover:bg-slate-50/80">
                        <td class="px-6 py-4 align-middle">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="h-16 w-24 rounded-2xl object-cover ring-1 ring-slate-200">
                            @else
                                <div class="flex h-16 w-24 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                    <i class="fas fa-utensils"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 align-middle">
                            <p class="font-semibold text-slate-800">{{ $item->name }}</p>
                        </td>
                        <td class="px-6 py-4 align-middle text-slate-700">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 align-middle">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $item->is_available ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">{{ $item->is_available ? 'Tersedia' : 'Tidak Tersedia' }}</span>
                        </td>
                        <td class="px-6 py-4 align-middle text-slate-600">{{ Str::limit($item->description, 80) }}</td>
                        <td class="px-6 py-4 align-middle text-right">
                            <div class="flex flex-wrap justify-end gap-2">
                                <button type="button" class="btn-admin-secondary" onclick="openItemModal(@json($item))">Edit</button>
                                <form action="{{ route('admin.menu-specials.items.destroy', [$special, $item]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus varian ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-admin-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-slate-500">
                            <div class="mx-auto max-w-sm">
                                <i class="fas fa-box-open mb-3 text-3xl text-orange-300"></i>
                                <p class="font-semibold text-slate-700">Belum ada varian</p>
                                <p class="text-sm">Tambahkan varian menu untuk special ini agar pelanggan dapat memilih paket yang tersedia.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="itemModal" class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto bg-black/70 p-4">
    <div class="w-full max-w-3xl rounded-3xl bg-slate-950 shadow-2xl ring-1 ring-slate-800">
        <div class="flex items-center justify-between border-b border-slate-800 px-6 py-4">
            <div>
                <h3 class="text-xl font-semibold text-white" id="itemModalTitle">Tambah Varian Menu</h3>
                <p class="text-sm text-slate-400">Isi detail varian spesial dengan harga dan gambar.</p>
            </div>
            <button type="button" onclick="closeItemModal()" class="text-slate-400 hover:text-white"><i class="fas fa-times"></i></button>
        </div>

        <form id="itemModalForm" action="{{ route('admin.menu-specials.items.store', $special) }}" method="POST" enctype="multipart/form-data" class="space-y-4 px-6 py-6">
            @csrf
            <input type="hidden" name="_method" id="itemFormMethod" value="POST">

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200" for="item_name">Nama Varian <span class="text-orange-400">*</span></label>
                    <input type="text" name="name" id="item_name" required style="color: #ffffff !important; caret-color: #f97316; background-color: #0f172a !important;" class="w-full rounded-2xl border-2 border-slate-600 px-4 py-3 text-sm placeholder-slate-400 focus:border-orange-500 focus:ring-orange-400 focus:ring-2" placeholder="Contoh: Tumpeng Mini">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200" for="item_price">Harga <span class="text-orange-400">*</span></label>
                    <input type="number" name="price" id="item_price" required min="0" style="color: #ffffff !important; caret-color: #f97316; background-color: #0f172a !important;" class="w-full rounded-2xl border-2 border-slate-600 px-4 py-3 text-sm placeholder-slate-400 focus:border-orange-500 focus:ring-orange-400 focus:ring-2" placeholder="350000">
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-200" for="item_description">Deskripsi</label>
                <textarea name="description" id="item_description" rows="4" style="color: #ffffff !important; caret-color: #f97316; background-color: #0f172a !important; resize: none;" class="w-full rounded-2xl border-2 border-slate-600 px-4 py-3 text-sm placeholder-slate-400 focus:border-orange-500 focus:ring-orange-400 focus:ring-2" placeholder="Detail paket dan keunggulan varian."></textarea>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200" for="item_image">Gambar Varian</label>
                    <input type="file" name="image" id="item_image" accept="image/*" class="block w-full text-sm text-slate-200" onchange="previewItemImage(event)">
                    <p class="mt-2 text-xs text-slate-500">Unggah gambar varian untuk tampilan lebih menarik.</p>
                </div>
                <div class="flex items-center rounded-2xl border border-slate-700 bg-slate-900 px-4 py-4">
                    <label class="flex items-center gap-3 text-sm text-slate-200">
                        <input type="checkbox" name="is_available" id="item_is_available" value="1" class="h-4 w-4 rounded border-slate-600 bg-slate-800 text-orange-500 focus:ring-orange-500">
                        <span>Status tersedia</span>
                    </label>
                </div>
            </div>

            <div id="item-image-preview" class="hidden">
                <p class="mb-2 text-sm font-semibold text-slate-200">Preview Gambar</p>
                <img id="item-preview-img" src="" alt="Preview" class="h-56 w-full rounded-3xl object-cover ring-1 ring-slate-700">
            </div>

            <div class="flex flex-col gap-3 pt-4 sm:flex-row sm:justify-end">
                <button type="button" onclick="closeItemModal()" class="btn-admin-secondary">Batal</button>
                <button type="submit" class="btn-admin">Simpan Varian</button>
            </div>
        </form>
    </div>
</div>

<script>
function openItemModal(item = null) {
    const modal = document.getElementById('itemModal');
    const title = document.getElementById('itemModalTitle');
    const form = document.getElementById('itemModalForm');
    const methodInput = document.getElementById('itemFormMethod');
    const preview = document.getElementById('item-image-preview');
    const previewImg = document.getElementById('item-preview-img');

    if (item) {
        title.textContent = 'Edit Varian Menu';
        form.action = `{{ route('admin.menu-specials.items.store', $special) }}`.replace('/items', `/items/${item.id}`);
        methodInput.value = 'PATCH';
        setFormValue('item_name', item.name ?? '');
        setFormValue('item_price', item.price ?? '');
        setFormValue('item_description', item.description ?? '');
        document.getElementById('item_is_available').checked = !!item.is_available;
        document.getElementById('item_image').value = '';
        if (item.image) {
            previewImg.src = `{{ asset('storage') }}/${item.image}`;
            preview.classList.remove('hidden');
        } else {
            previewImg.src = '';
            preview.classList.add('hidden');
        }
    } else {
        title.textContent = 'Tambah Varian Menu';
        form.action = '{{ route('admin.menu-specials.items.store', $special) }}';
        methodInput.value = 'POST';
        setFormValue('item_name', '');
        setFormValue('item_price', '');
        setFormValue('item_description', '');
        document.getElementById('item_is_available').checked = true;
        document.getElementById('item_image').value = '';
        previewImg.src = '';
        preview.classList.add('hidden');
    }

    modal.classList.remove('hidden');
    document.getElementById('item_name').focus();
}

function closeItemModal() {
    document.getElementById('itemModal').classList.add('hidden');
}

function setFormValue(id, value) {
    const element = document.getElementById(id);
    if (element) {
        element.value = value;
    }
}

function previewItemImage(event) {
    const file = event.target.files[0];
    if (!file) {
        return;
    }
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('item-image-preview');
        const image = document.getElementById('item-preview-img');
        image.src = e.target.result;
        preview.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}

function previewBanner(event) {
    const file = event.target.files[0];
    if (!file) {
        return;
    }
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('banner-preview');
        const image = document.getElementById('banner-preview-img');
        image.src = e.target.result;
        preview.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}
</script>
@endsection
