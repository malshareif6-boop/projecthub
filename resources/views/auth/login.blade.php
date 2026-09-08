<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-900 tracking-tight">Welcome back</h1>
        <p class="text-sm text-gray-500 mt-1">Log in to your ProjectHub account</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="login" class="block text-sm font-medium text-gray-700 mb-1.5">
                Email or Username
            </label>
            <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus
                autocomplete="username"
                class="w-full border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="you@university.edu or username">
            <x-input-error :messages="$errors->get('login')" class="mt-1.5" />
        </div>

        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-xs font-medium text-indigo-600 hover:text-indigo-800 transition">
                        Forgot password?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
            <label for="remember_me" class="ms-2 text-sm text-gray-600">Remember me</label>
        </div>

        <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-sm font-semibold
                       py-2.5 rounded-xl shadow-sm shadow-indigo-600/25 transition">
            Log in
        </button>
    </form>
    <div class="mt-6">
    <div class="relative">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-200"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="bg-white px-3 text-gray-500">Or continue with</span>
        </div>
    </div>

    <div class="mt-4 grid grid-cols-2 gap-3">
        <a href="{{ route('social.redirect', 'google') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
            <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
                <path fill="#EA4335" d="M12 10.2v3.6h5.1c-.2 1.2-.9 2.2-1.9 2.9l3.1 2.4c1.8-1.7 2.9-4.1 2.9-7 0-.7-.1-1.3-.2-1.9H12z"/>
                <path fill="#34A853" d="M5.3 14.3l-.8.6-2.5 1.9C3.6 19.7 7.5 22 12 22c2.9 0 5.3-.9 7.1-2.5l-3.1-2.4c-.9.6-2 .9-3.9.9-3 0-5.6-2-6.5-4.7z"/>
                <path fill="#4A90E2" d="M2 7.1C1.4 8.3 1 9.6 1 11s.4 2.7 1 3.9l3.3-2.6C5.1 11.6 5 11.3 5 11s.1-.6.2-1L2 7.1z"/>
                <path fill="#FBBC05" d="M12 4.9c1.6 0 3 .5 4.1 1.6l3.1-3.1C17.3 1.5 14.9.5 12 .5 7.5.5 3.6 2.8 2 7.1l3.3 2.6C6.4 6.9 9 4.9 12 4.9z"/>
            </svg>
            Google
        </a>

        <a href="{{ route('social.redirect', 'github') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/>
            </svg>
            GitHub
        </a>
    </div>
</div>

    @if (Route::has('register'))
        <p class="mt-6 text-center text-sm text-gray-500">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-800 transition">
                Register
            </a>
        </p>
    @endif
</x-guest-layout>
