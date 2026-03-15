<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<div x-data="{ open: false }">
    <nav class="flex items-center justify-between px-10 py-5 bg-white shadow-sm">
        <div class="flex items-center gap-2 font-bold text-lg">📘 EduLearn</div>

        <ul class="flex gap-8 text-gray-600 cursor-pointer">
            <li class="hover:text-indigo-500">Browse Courses</li>
            <li class="hover:text-indigo-500">Career Paths</li>
            <li class="hover:text-indigo-500">Mentors</li>
        </ul>

        <div class="flex items-center gap-5">
            <input type="text" placeholder="Search courses..."
                class="border rounded-full px-4 py-2 text-sm focus:outline-indigo-300">

            <button @click="open = true" class="text-gray-700 hover:text-indigo-600 font-medium cursor-pointer">
                Log In
            </button>

            <button class="bg-indigo-500 hover:bg-indigo-600 text-white px-5 py-2 rounded-full transition">
                Sign Up
            </button>
        </div>
    </nav>

    <div x-show="open" x-transition x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">

        <div @click.outside="open=false" class="relative z-10 bg-white w-[400px] rounded-2xl p-8 shadow-xl">

            <!-- Header -->
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-xl font-bold">Welcome Back</h2>

                <button @click="open=false" class="text-gray-400 text-xl">
                    ✕
                </button>
            </div>

            <p class="text-gray-500 text-sm mb-6">
                Enter your credentials to access your account
            </p>

            <!-- Social login -->
            <div class="flex gap-3 mb-5">
                <button class="border w-1/2 py-2 rounded-lg">
                    Google
                </button>

                <button class="border w-1/2 py-2 rounded-lg">
                    GitHub
                </button>
            </div>

            <div class="text-center text-gray-400 text-sm mb-5">
                Or continue with
            </div>

            <!-- Email -->
            <input type="email" placeholder="you@example.com" class="w-full border rounded-lg px-4 py-2 mb-3">

            <!-- Password -->
            <input type="password" placeholder="Password" class="w-full border rounded-lg px-4 py-2 mb-3">

            <div class="flex justify-between items-center text-sm mb-5">
                <label class="flex items-center gap-2">
                    <input type="checkbox">
                    Remember me
                </label>

                <a href="#" class="text-indigo-500">
                    Forgot password?
                </a>
            </div>

            <!-- Button -->
            <button class="w-full bg-indigo-500 text-white py-2 rounded-full">
                Sign In
            </button>

            <p class="text-center text-sm text-gray-500 mt-4">
                Don't have an account?
                <a href="#" class="text-indigo-500">Sign Up</a>
            </p>

        </div>
    </div>
</div>
