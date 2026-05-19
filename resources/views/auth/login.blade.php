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

        @if (Route::has('register'))
            <div class="text-center pt-2">
                <span class="text-xs text-slate-500">Don't have an account?</span>
                <a href="{{ route('register') }}" class="text-xs font-bold text-zinc-900 hover:underline">Create Account</a>
            </div>
        @endif
    </form>
</x-guest-layout>
