<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-xl font-extrabold uppercase tracking-wider text-zinc-900">Create Account</h2>
        <p class="text-xs text-slate-500 mt-1">Register for a verified wholesale merchant account</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4 text-sm">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 mb-1">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-950 text-zinc-800" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 mb-1">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-950 text-zinc-800" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 mb-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" 
                class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-950 text-zinc-800" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 mb-1">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2.5 text-sm focus:outline-none focus:border-zinc-950 text-zinc-800" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full bg-zinc-950 text-white font-extrabold py-3 rounded text-xs uppercase tracking-widest hover:bg-zinc-800 transition duration-150 shadow-md">
            Create Account
        </button>

        <div class="text-center pt-2">
            <span class="text-xs text-slate-500">Already registered?</span>
            <a href="{{ route('login') }}" class="text-xs font-bold text-zinc-900 hover:underline">Sign In</a>
        </div>
    </form>
</x-guest-layout>
