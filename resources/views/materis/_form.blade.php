@php
    $materi ??= null;
@endphp

<div class="space-y-4">
    <div>
        <label for="course_id" class="block text-sm font-medium text-gray-700">Course</label>
        <select id="course_id" name="course_id" class="mt-1 w-full rounded-md border-gray-300" required>
            <option value="">Pilih Course</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}" @selected(old('course_id', $materi?->course_id) == $course->id)>
                    {{ $course->title }}
                </option>
            @endforeach
        </select>
        @error('course_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
        <input id="title" name="title" type="text" value="{{ old('title', $materi?->title) }}" class="mt-1 w-full rounded-md border-gray-300" required>
        @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
        <textarea id="content" name="content" rows="5" class="mt-1 w-full rounded-md border-gray-300" required>{{ old('content', $materi?->content) }}</textarea>
        @error('content')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="video_url" class="block text-sm font-medium text-gray-700">Video URL (opsional)</label>
        <input id="video_url" name="video_url" type="url" value="{{ old('video_url', $materi?->video_url) }}" class="mt-1 w-full rounded-md border-gray-300">
        @error('video_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div>
            <label for="duration" class="block text-sm font-medium text-gray-700">Durasi (menit)</label>
            <input id="duration" name="duration" type="number" min="0" value="{{ old('duration', $materi?->duration ?? 0) }}" class="mt-1 w-full rounded-md border-gray-300" required>
            @error('duration')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="order" class="block text-sm font-medium text-gray-700">Order</label>
            <input id="order" name="order" type="number" min="1" value="{{ old('order', $materi?->order ?? 1) }}" class="mt-1 w-full rounded-md border-gray-300" required>
            @error('order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="flex gap-2">
        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-white">Simpan</button>
        <a href="{{ route('materis.index') }}" class="rounded-md border px-4 py-2">Batal</a>
    </div>
</div>
