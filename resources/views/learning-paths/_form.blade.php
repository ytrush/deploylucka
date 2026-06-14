@php
    $selectedCourseIds = old('courses', $selectedCourses ?? []);
@endphp

<div class="space-y-6">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nama Learning Path</label>
        <input id="name" name="name" type="text" value="{{ old('name', $learningPath->name ?? '') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
        <textarea id="description" name="description" rows="4"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $learningPath->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="courses" class="block text-sm font-medium text-gray-700">Pilih Course untuk Learning Path</label>
        <p class="mt-1 text-sm text-gray-500">Urutkan sesuai alur yang diinginkan. Pilih lebih dari satu course jika perlu.</p>
        <select id="courses" name="courses[]" multiple size="8"
            class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            @foreach ($courses as $course)
                <option value="{{ $course->id }}" {{ in_array($course->id, $selectedCourseIds) ? 'selected' : '' }}>
                    {{ $course->title }} ({{ $course->category?->name ?? 'No category' }})
                </option>
            @endforeach
        </select>
        @error('courses')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end gap-3">
        <a href="{{ route('learning-paths.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Simpan</button>
    </div>
</div>
