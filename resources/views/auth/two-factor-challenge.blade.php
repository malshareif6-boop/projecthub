<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Please confirm access to your account by entering the authentication code
        provided by your authenticator application.
    </div>

    @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ url('/two-factor-challenge') }}">
        @csrf

        <div>
            <x-input-label for="code" value="Authentication code" />
            <x-text-input id="code" class="block mt-1 w-full" type="text" inputmode="numeric" name="code"
                autofocus autocomplete="one-time-code" />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="recovery_code" value="Or use a recovery code" />
            <x-text-input id="recovery_code" class="block mt-1 w-full" type="text" name="recovery_code"
                autocomplete="one-time-code" />
            <x-input-error :messages="$errors->get('recovery_code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
