<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-6">
        <h2 class="text-xl font-extrabold uppercase tracking-wider text-zinc-900">Sign In</h2>
        <p class="text-xs text-slate-500 mt-1">Access your wholesale buyer dashboard</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4 text-sm">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 mb-1">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-950 text-zinc-800" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-baseline mb-1">
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-zinc-700">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-zinc-400 hover:text-zinc-950 transition" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password" 
                class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-950 text-zinc-800" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Remember Me -->
        <div class="block">
            <label for="remember_me" class="inline-flex items-center text-xs font-bold text-zinc-500 hover:text-zinc-950 cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-zinc-900 focus:ring-zinc-900" />
                <span class="ms-2">Keep me signed in</span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-zinc-950 text-white font-extrabold py-3 rounded text-xs uppercase tracking-widest hover:bg-zinc-800 transition duration-150 shadow-md">
            Sign In
        </button>
    </form>

    <!-- Divider -->
    <div class="relative flex items-center gap-3 my-1">
        <div class="flex-grow border-t border-gray-200"></div>
        <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">or</span>
        <div class="flex-grow border-t border-gray-200"></div>
    </div>

    <!-- Google Sign-In Button -->
    <a href="{{ route('auth.google.redirect') }}"
       id="google-signin-btn"
       class="flex items-center justify-center gap-3 w-full border border-gray-300 bg-white hover:bg-gray-50 text-zinc-800 font-bold text-xs uppercase tracking-widest py-3 rounded transition duration-150 shadow-sm hover:shadow">
        <!-- Google SVG Logo -->
        <svg class="h-4 w-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
        </svg>
        Continue with Google
    </a>

    @if (Route::has('register'))
        <div class="text-center pt-1">
            <span class="text-xs text-slate-500">Don't have an account?</span>
            <a href="{{ route('register') }}" class="text-xs font-bold text-zinc-900 hover:underline">Create Account</a>
        </div>
    @endif
</x-guest-layout>
