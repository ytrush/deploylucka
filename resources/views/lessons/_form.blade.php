@php
    $lesson ??= null;
@endphp

<div class="space-y-4">
    <div>
        <label for="section_id" class="block text-sm font-medium text-gray-700">Section</label>
        <select id="section_id" name="section_id" class="mt-1 w-full rounded-md border-gray-300" required>
            <option value="">Pilih Section</option>
            @foreach ($sections as $section)
                <option value="{{ $section->id }}" @selected(old('section_id', $lesson?->section_id) == $section->id)>
                    {{ $section->title }} - {{ $section->course?->title }}
                </option>
            @endforeach
        </select>
        @error('section_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
        <input id="title" name="title" type="text" value="{{ old('title', $lesson?->title) }}" class="mt-1 w-full rounded-md border-gray-300" required>
        @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
        <textarea id="content" name="content" rows="5" class="mt-1 w-full rounded-md border-gray-300" required>{{ old('content', $lesson?->content) }}</textarea>
        @error('content')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="video_url" class="block text-sm font-medium text-gray-700">Video URL (opsional)</label>
        <input id="video_url" name="video_url" type="url" value="{{ old('video_url', $lesson?->video_url) }}" class="mt-1 w-full rounded-md border-gray-300">
        @error('video_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div>
            <label for="duration" class="block text-sm font-medium text-gray-700">Durasi (menit)</label>
            <input id="duration" name="duration" type="number" min="0" value="{{ old('duration', $lesson?->duration ?? 0) }}" class="mt-1 w-full rounded-md border-gray-300" required>
            @error('duration')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="order" class="block text-sm font-medium text-gray-700">Order</label>
            <input id="order" name="order" type="number" min="1" value="{{ old('order', $lesson?->order ?? 1) }}" class="mt-1 w-full rounded-md border-gray-300" required>
            @error('order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="flex gap-2">
        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-white">Simpan</button>
        <a href="{{ route('lessons.index') }}" class="rounded-md border px-4 py-2">Batal</a>
    </div>
</div>
