<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Please enter the 6-digit OTP code sent to your email address to verify your email.') }}
    </div>

    @if (session('status'))
        @if (session('success'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @elseif (session('error'))
            <div class="mb-4 font-medium text-sm text-red-600">
                {{ session('status') }}
            </div>
        @else
            <div class="mb-4 font-medium text-sm text-blue-600">
                {{ session('status') }}
            </div>
        @endif
    @endif

    @if (session('message'))
        <div class="mb-4 font-medium text-sm text-blue-600">
            {{ session('message') }}
        </div>
    @endif

    @if (!session('success') && !old('email'))
        <div class="mb-4 font-medium text-sm text-yellow-600">
            {{ __('OTP email mungkin tidak terkirim. Silakan klik "Resend OTP" untuk mengirim ulang.') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.otp.verify') }}">
        @csrf
        <input type="hidden" name="email" value="{{ session('email') }}">

        <div>
            <x-input-label for="otp" :value="__('OTP Code')" />
            <x-text-input id="otp" class="block mt-1 w-full" type="text" name="otp" required autofocus maxlength="6" pattern="\d{6}" />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Verify Email') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-4">
        <form method="POST" action="{{ route('verification.otp.resend') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') }}">
            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Resend OTP') }}
            </button>
        </form>
    </div>

    @if ($errors->any())
        <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-md">
            <h3 class="text-sm font-medium text-red-800">Error Details:</h3>
            <ul class="mt-2 text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</x-guest-layout>
