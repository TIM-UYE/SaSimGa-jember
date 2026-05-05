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
                <h5 class="font-bold">Edit Testimoni</h5>
                <a href="{{ route('admin.testimoni.index') }}" class="btn-admin-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
            <div class="p-4">
                <form action="{{ route('admin.testimoni.update', $testimoni) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nama Reviewer -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="author_name">
                                Nama Reviewer <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="author_name" id="author_name" value="{{ old('author_name', $testimoni->author_name) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="Contoh: Ahmad Rahman" required>
                        </div>

                        <!-- Rating -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="rating">
                                Rating <span class="text-red-500">*</span>
                            </label>
                            <select name="rating" id="rating" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                                <option value="">Pilih Rating</option>
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" {{ old('rating', $testimoni->rating) == $i ? 'selected' : '' }}>
                                        {{ $i }} {{ str_repeat('★', $i) }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- Isi Testimoni -->
                        <div class="mb-4 md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="text">
                                Isi Testimoni <span class="text-red-500">*</span>
                            </label>
                            <textarea name="text" id="text" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="Masukkan isi testimoni..." required>{{ old('text', $testimoni->text) }}</textarea>
                        </div>

                        <!-- URL Foto Reviewer -->
                        <div class="mb-4 md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="profile_photo_url">
                                URL Foto Reviewer
                            </label>
                            <input type="url" name="profile_photo_url" id="profile_photo_url" value="{{ old('profile_photo_url', $testimoni->profile_photo_url) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="https://example.com/photo.jpg">
                        </div>

                        <!-- URL Profil Reviewer -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="author_url">
                                URL Profil Reviewer
                            </label>
                            <input type="url" name="author_url" id="author_url" value="{{ old('author_url', $testimoni->author_url) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="https://example.com/profile">
                        </div>

                        <!-- Tanggal Review -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="review_date">
                                Tanggal Review
                            </label>
                            <input type="date" name="review_date" id="review_date" value="{{ old('review_date', optional($testimoni->review_date)->format('Y-m-d')) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>

                        <!-- Bahasa -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="language">
                                Bahasa
                            </label>
                            <input type="text" name="language" id="language" value="{{ old('language', $testimoni->language) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="id">
                        </div>

                        <!-- Status Aktif -->
                        <div class="mb-4 md:col-span-2 flex items-center gap-3">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $testimoni->is_active) ? 'checked' : '' }}
                                class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500">
                            <label for="is_active" class="text-sm text-gray-700">Aktifkan testimoni ini</label>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('admin.testimoni.index') }}" class="btn-admin-secondary">Batal</a>
                        <button type="submit" class="btn-admin">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
