<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<div x-data="{ openLogin: false }">
    <nav
        class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-8 md:px-12 py-4 bg-white/90 backdrop-blur border-b border-slate-200 shadow-sm">
        <div class="flex items-center gap-3 text-2xl font-bold">
            <img src="{{ asset('images/Primary-Edumora.png') }}" alt="Edumora Logo" class="h-9 w-auto" />
            <span style="color: #4fcd98;">Edumora</span>
        </div>

        <ul class="hidden md:flex gap-8 text-slate-700 font-medium">
            <li><a href="#browse-courses" class="transition" style="color: #4fcd98 !important;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">Browse Courses</a></li>
            <li><a href="#career-paths" class="transition" style="color: #4fcd98 !important;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">Career Paths</a></li>
            <li><a href="#mentors" class="transition" style="color: #4fcd98 !important;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">Mentors</a></li>
            <li><a href="#for-business" class="transition" style="color: #4fcd98 !important;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">For Business</a></li>
        </ul>

        <div class="flex items-center gap-4">
            
            <button @click="openLogin = true" class="text-slate-700 font-medium" style="transition: color 0.3s;" onmouseover="this.style.color='#4fcd98'" onmouseout="this.style.color='#374151'">
                Log In
            </button>

            <a href="{{ route('register') }}"
                class="text-white px-5 py-2 rounded-full transition inline-flex items-center" style="background-color: #4fcd98; hover:opacity: 0.9;">
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
