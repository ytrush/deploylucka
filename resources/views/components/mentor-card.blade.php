<div class="bg-white rounded-3xl shadow-xl border p-8 text-center">
    <div class="mx-auto w-32 h-32 overflow-hidden rounded-2xl ring-2 ring-indigo-300">
        <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover">
    </div>
    <span class="inline-block mt-4 px-4 py-1 bg-indigo-500 text-white rounded-full text-xs">{{ $company }}</span>
    <h3 class="text-2xl font-bold mt-4">{{ $name }}</h3>
    <p class="text-gray-500">{{ $title }}</p>
    <div class="flex justify-center items-center gap-10 mt-6 text-sm text-gray-600">
        <div><span class="font-bold text-indigo-600">{{ $rating }}</span>
            <div>Rating</div>
        </div>
        <div><span class="font-bold text-indigo-600">{{ $students }}</span>
            <div>Students</div>
        </div>
        <div><span class="font-bold text-indigo-600">{{ $courses }}</span>
            <div>Courses</div>
        </div>
    </div>
    <div class="flex flex-wrap justify-center gap-2 mt-5">
        @foreach ($skills as $skill)
            <span class="px-3 py-1 bg-blue-50 rounded-full text-sm">{{ $skill }}</span>
        @endforeach
    </div>
    <button class="mt-6 px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium">
        View Profile
    </button>
</div>
