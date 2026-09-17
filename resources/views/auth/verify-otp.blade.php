<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        We sent a 6-digit code to your email. Enter it below to verify your account.
    </div>

    @if (session('success'))
        <div class="mb-4 text-sm text-green-600">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('verification.otp.verify') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="otp" value="Verification Code" />
            <x-text-input id="otp" name="otp" type="text" inputmode="numeric" maxlength="6"
                class="block mt-1 w-full tracking-widest text-center text-lg" required autofocus
                autocomplete="one-time-code" />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center">
            Verify Email
        </x-primary-button>
    </form>

    <form method="POST" action="{{ route('verification.otp.resend') }}" class="mt-4 text-center">
        @csrf
        <button type="submit" class="text-sm text-gray-600 underline hover:text-gray-900">
            Resend code
        </button>
    </form>
</x-guest-layout>
