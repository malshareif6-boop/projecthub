<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Two Factor Authentication</h2>
        <p class="mt-1 text-sm text-gray-600">
            Add extra security to your account using an authenticator app.
        </p>
    </header>

    @if (!auth()->user()->two_factor_secret)
        <form method="POST" action="{{ url('/user/two-factor-authentication') }}" class="mt-4">
            @csrf
            <x-primary-button type="submit">Enable 2FA</x-primary-button>
        </form>
    @else
        @if (!auth()->user()->two_factor_confirmed_at)
            <p class="mt-2 text-sm text-gray-600">Scan this QR code with Google Authenticator, then confirm:</p>

            <div class="mt-4 inline-block p-4 bg-white border rounded-lg">
                {!! auth()->user()->twoFactorQrCodeSvg() !!}
            </div>

            <form method="POST" action="{{ url('/user/confirmed-two-factor-authentication') }}" class="mt-4 space-y-3">
                @csrf
                <x-text-input name="code" placeholder="6-digit code" class="w-48" required />
                <x-primary-button type="submit">Confirm</x-primary-button>
            </form>
        @else
            <p class="mt-2 text-sm text-green-700 font-medium">2FA is enabled.</p>

            <form method="POST" action="{{ url('/user/two-factor-authentication') }}" class="mt-4">
                @csrf
                @method('DELETE')
                <x-danger-button type="submit">Disable 2FA</x-danger-button>
            </form>
        @endif
        @if (auth()->user()->two_factor_confirmed_at)
            <div class="mt-4">
                <p class="text-sm text-gray-600 mb-2">Recovery codes (store them somewhere safe):</p>

                <div class="bg-gray-50 border rounded-md p-3 font-mono text-sm space-y-1">
                    @foreach (auth()->user()->recoveryCodes() as $code)
                        <div>{{ $code }}</div>
                    @endforeach
                </div>

                <form method="POST" action="{{ url('/user/two-factor-recovery-codes') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="text-sm text-indigo-600 hover:underline">
                        Regenerate recovery codes
                    </button>
                </form>
            </div>
        @endif
    @endif
</section>
