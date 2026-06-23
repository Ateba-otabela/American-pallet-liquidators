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

        <a href="{{ route('auth.google.redirect') }}" class="w-full inline-flex items-center justify-center gap-2 border border-gray-300 text-zinc-900 bg-white font-extrabold py-3 rounded text-xs uppercase tracking-widest hover:bg-zinc-50 transition duration-150 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 533.5 544.3" class="h-4 w-4">
                <path fill="#4285F4" d="M533.5 278.4c0-18-1.6-35.2-4.6-52H272.1v98.6h146.9c-6.4 34.3-25.4 63.4-54.4 82.9v68.8h87.9c51.4-47.4 81-117 81-198.3z"/>
                <path fill="#34A853" d="M272.1 544.3c73.5 0 135.1-24.3 180.1-66.2l-87.9-68.8c-24.4 16.5-55.5 26.3-92.2 26.3-70.8 0-130.8-47.8-152.3-112.2H29.5v70.7c45.1 89.4 137.5 150.2 242.6 150.2z"/>
                <path fill="#FBBC05" d="M119.8 323.6c-10.7-32.1-10.7-66.4 0-98.5V154.4H29.5c-38.7 76.9-38.7 168.3 0 245.1l90.3-75.9z"/>
                <path fill="#EA4335" d="M272.1 107.5c39 0 74.2 13.4 101.9 39.7l76.4-76.4C407.2 24.8 344.5 0 272.1 0 166.9 0 74.5 60.8 29.5 150.2l90.3 70.9C141.3 155.3 201.3 107.5 272.1 107.5z"/>
            </svg>
            Continue with Google
        </a>

        <div class="text-center pt-2">
            <span class="text-xs text-slate-500">Already registered?</span>
            <a href="{{ route('login') }}" class="text-xs font-bold text-zinc-900 hover:underline">Sign In</a>
        </div>
    </form>
</x-guest-layout>
