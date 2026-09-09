<div class="bg-white rounded-3xl shadow-xl border p-8 text-center">
    <div class="mx-auto w-32 h-32 overflow-hidden rounded-2xl ring-2" style="ring-color: #4fcd98;">
        <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover">
    </div>
    <span class="inline-block mt-4 px-4 py-1 text-white rounded-full text-xs" style="background-color: #4fcd98;">{{ $company }}</span>
    <h3 class="text-2xl font-bold mt-4">{{ $name }}</h3>
    <p class="text-gray-500">{{ $title }}</p>
    <div class="flex justify-center items-center gap-10 mt-6 text-sm text-gray-600">
        <div><span class="font-bold" style="color: #4fcd98;">{{ $rating }}</span>
            <div>Rating</div>
        </div>
        <div><span class="font-bold" style="color: #4fcd98;">{{ $students }}</span>
            <div>Students</div>
        </div>
        <div><span class="font-bold" style="color: #4fcd98;">{{ $courses }}</span>
            <div>Courses</div>
        </div>
    </div>
    <div class="flex flex-wrap justify-center gap-2 mt-5">
        @foreach ($skills as $skill)
            <span class="px-3 py-1 rounded-full text-sm" style="background-color: #4fcd9820; color: #4fcd98;">{{ $skill }}</span>
        @endforeach
    </div>
    <button class="mt-6 px-8 py-3 text-white rounded-xl font-medium transition-all" style="background-color: #4fcd98;" onmouseover="this.style.backgroundColor='#3ab876'" onmouseout="this.style.backgroundColor='#4fcd98'">
        View Profile
    </button>
</div>
