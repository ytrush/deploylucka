@php
    $course ??= null;
@endphp

<div class="space-y-4">
    <div>
        <label for="instructor_id" class="block text-sm font-medium text-gray-700">Instructor</label>
        <select id="instructor_id" name="instructor_id" class="mt-1 w-full rounded-md border-gray-300" required>
            <option value="">Pilih Instructor</option>
            @foreach ($instructors as $instructor)
                <option value="{{ $instructor->id }}" @selected(old('instructor_id', $course?->instructor_id) == $instructor->id)>
                    {{ $instructor->name }}
                </option>
            @endforeach
        </select>
        @error('instructor_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
        <select id="category_id" name="category_id" class="mt-1 w-full rounded-md border-gray-300" required>
            <option value="">Pilih Kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $course?->category_id) == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
        <input id="title" name="title" type="text" value="{{ old('title', $course?->title) }}" class="mt-1 w-full rounded-md border-gray-300" required>
        @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="level" class="block text-sm font-medium text-gray-700">Level</label>
        <input id="level" name="level" type="text" value="{{ old('level', $course?->level) }}" class="mt-1 w-full rounded-md border-gray-300" required>
        @error('level')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea id="description" name="description" rows="5" class="mt-1 w-full rounded-md border-gray-300" required>{{ old('description', $course?->description) }}</textarea>
        @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="flex gap-2">
        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-white">Simpan</button>
        <a href="{{ route('courses.index') }}" class="rounded-md border px-4 py-2">Batal</a>
    </div>
</div>
