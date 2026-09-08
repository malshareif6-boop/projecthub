<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-900 tracking-tight">Create your account</h1>
        <p class="text-sm text-gray-500 mt-1">Students can self-register · Supervisors are added by admin</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Full name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                autocomplete="name"
                class="w-full border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Mohammed Al-Shareif">
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                autocomplete="username"
                class="w-full border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="you@university.edu">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700 mb-1.5">Username</label>
            <input id="username" type="text" name="username" value="{{ old('username') }}" required
                class="w-full border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="mohammed_shareif">
            <p class="text-xs text-gray-400 mt-1">Letters, numbers, dashes and underscores only</p>
            <x-input-error :messages="$errors->get('username')" class="mt-1.5" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Confirm
                password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                autocomplete="new-password"
                class="w-full border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-sm font-semibold
                       py-2.5 rounded-xl shadow-sm shadow-indigo-600/25 transition">
            Create account
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        Already registered?
        <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-800 transition">
            Log in
        </a>
    </p>
</x-guest-layout>
