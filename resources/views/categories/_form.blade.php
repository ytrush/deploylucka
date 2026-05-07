@php
    $category ??= null;
@endphp

<div class="space-y-4">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
        <input id="name" name="name" type="text" value="{{ old('name', $category?->name) }}" class="mt-1 w-full rounded-md border-gray-300" placeholder="Contoh: Teknologi" required>
        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi (opsional)</label>
        <textarea id="description" name="description" rows="4" class="mt-1 w-full rounded-md border-gray-300">{{ old('description', $category?->description) }}</textarea>
        @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="flex gap-2">
        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-white">Simpan</button>
        <a href="{{ route('categories.index') }}" class="rounded-md border px-4 py-2">Batal</a>
    </div>
</div>
