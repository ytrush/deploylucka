<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<div x-data="{ openLogin: false }">
    <nav
        class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-8 md:px-12 py-4 bg-white/90 backdrop-blur border-b border-slate-200 shadow-sm">
        <div class="flex items-center gap-3 text-2xl font-bold text-indigo-700">
            <span>📘</span>
            <span>EduLearn</span>
        </div>

        <ul class="hidden md:flex gap-8 text-slate-700 font-medium">
            <li><a href="#browse-courses" class="hover:text-indigo-500 transition">Browse Courses</a></li>
            <li><a href="#career-paths" class="hover:text-indigo-500 transition">Career Paths</a></li>
            <li><a href="#mentors" class="hover:text-indigo-500 transition">Mentors</a></li>
            <li><a href="#for-business" class="hover:text-indigo-500 transition">For Business</a></li>
        </ul>

        <div class="flex items-center gap-4">
            <div class="relative hidden sm:block">
                <input type="text" placeholder="Search courses..."
                    class="border rounded-full pl-10 pr-4 py-2 text-sm w-60 focus:outline-none focus:ring-2 focus:ring-indigo-300" />
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">🔍</span>
            </div>

            <button class="hidden sm:inline-flex items-center gap-2 text-slate-700 hover:text-indigo-600 font-medium">
                🔔
            </button>

            <button @click="openLogin = true" class="text-slate-700 hover:text-indigo-600 font-medium">
                Log In
            </button>

            <a href="{{ route('register') }}"
                class="bg-indigo-500 hover:bg-indigo-600 text-white px-5 py-2 rounded-full transition inline-flex items-center">
                Sign Up
            </a>

            <button @click="openLogin = true" class="md:hidden text-slate-700 border rounded-lg px-3 py-2">
                ☰
            </button>
        </div>
    </nav>

    <div x-show="openLogin" x-transition x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">

        <div @click.outside="openLogin=false" class="relative z-10 bg-white w-[400px] rounded-2xl p-8 shadow-xl">

            <!-- Header -->
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-xl font-bold">Welcome Back</h2>

                <button @click="openLogin=false" class="text-gray-400 text-xl">
                    ✕
                </button>
            </div>

            <p class="text-gray-500 text-sm mb-6">
                Enter your credentials to access your account
            </p>

            <!-- Social login -->
            <div class="flex gap-3 mb-5">
                <a href="{{ route('auth.google.redirect') }}"
                    class="border w-full py-2 rounded-lg text-center hover:bg-slate-50 transition">
                    Continue with Google
                </a>
            </div>

            <div class="text-center text-gray-400 text-sm mb-5">
                Or continue with
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <input type="email" name="email" placeholder="you@example.com"
                    class="w-full border rounded-lg px-4 py-2 mb-3" required autofocus autocomplete="username">

                <!-- Password -->
                <input type="password" name="password" placeholder="Password"
                    class="w-full border rounded-lg px-4 py-2 mb-3" required autocomplete="current-password">

                <div class="flex justify-between items-center text-sm mb-5">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>

                    <a href="{{ route('password.request') }}" class="text-indigo-500">
                        Forgot password?
                    </a>
                </div>

                <button type="submit" class="w-full bg-indigo-500 text-white py-2 rounded-full">
                    Sign In
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-4">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-indigo-500">Sign Up</a>
            </p>

        </div>
    </div>
</div>
