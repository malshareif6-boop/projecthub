<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-900 tracking-tight">Reset password</h1>
        <p class="text-sm text-gray-500 mt-1">Choose a new password for your account</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required
                autofocus
                class="w-full border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">New password</label>
            <input id="password" type="password" name="password" required
                class="w-full border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Confirm
                password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                class="w-full border-gray-200 rounded-xl text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="••••••••">
        </div>

        <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold
                       py-2.5 rounded-xl shadow-sm shadow-indigo-600/25 transition">
            Reset Password
        </button>
    </form>
</x-guest-layout>
