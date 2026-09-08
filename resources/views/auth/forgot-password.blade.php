<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-900 tracking-tight">Forgot password?</h1>
        <p class="text-sm text-gray-500 mt-1">
            Enter your email and we'll send you a reset link.
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="you@university.edu">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold
                       py-2.5 rounded-xl shadow-sm shadow-indigo-600/25 transition">
            Email Password Reset Link
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-800 transition">
            ← Back to login
        </a>
    </p>
</x-guest-layout>
