<section style="background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1); font-family: 'Poppins', sans-serif;">
    <header>
        <h2 style="color: #333; font-size: 18px; font-weight: 600;">
            {{ __('Profile Settings') }}
        </h2>

        <p style="margin-top: 4px; font-size: 14px; color: #666;">
            {{ __("Update your account's profile information and password.") }}
        </p>
    </header>

    <form wire:submit="updateProfileSettings" style="margin-top: 24px;">
        <!-- Profile Information Section -->
        <div style="margin-bottom: 32px;">
            <div style="margin-bottom: 24px;">
                <label for="name" style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">{{ __('Name') }}</label>
                <input wire:model="name" id="name" name="name" type="text" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif;" required autofocus autocomplete="name" />
                <div style="margin-top: 8px; color: #e74c3c; font-size: 12px;">
                    @error('name') {{ $message }} @enderror
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <label for="email" style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">{{ __('Email') }}</label>
                <input wire:model="email" id="email" name="email" type="email" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif;" required autocomplete="username" />
                <div style="margin-top: 8px; color: #e74c3c; font-size: 12px;">
                    @error('email') {{ $message }} @enderror
                </div>

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                    <div style="margin-top: 12px;">
                        <p style="font-size: 14px; color: #333;">
                            {{ __('Your email address is unverified.') }}

                            <button wire:click.prevent="sendVerification" style="text-decoration: underline; color: #666; background: none; border: none; cursor: pointer; font-size: 14px;">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p style="margin-top: 8px; font-weight: 500; font-size: 14px; color: #27ae60;">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Password Section -->
        <div style="margin-bottom: 32px;">
            <div style="margin-bottom: 24px;">
                <label for="current_password" style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">{{ __('Current Password') }}</label>
                <input wire:model="current_password" id="current_password" name="current_password" type="password" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif;" autocomplete="current-password" />
                <div style="margin-top: 8px; color: #e74c3c; font-size: 12px;">
                    @error('current_password') {{ $message }} @enderror
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <label for="password" style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">{{ __('New Password') }}</label>
                <input wire:model="password" id="password" name="password" type="password" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif;" autocomplete="new-password" />
                <div style="margin-top: 8px; color: #e74c3c; font-size: 12px;">
                    @error('password') {{ $message }} @enderror
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <label for="password_confirmation" style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">{{ __('Confirm Password') }}</label>
                <input wire:model="password_confirmation" id="password_confirmation" name="password_confirmation" type="password" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif;" autocomplete="new-password" />
                <div style="margin-top: 8px; color: #e74c3c; font-size: 12px;">
                    @error('password_confirmation') {{ $message }} @enderror
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div style="display: flex; align-items: center; gap: 16px;">
            <button type="submit" style="background: #3498db; color: #fff; padding: 10px 20px; border: none; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; font-family: 'Poppins', sans-serif;">{{ __('Save Changes') }}</button>

            <div wire:loading.delay style="color: #27ae60; font-size: 14px;">{{ __('Saving...') }}</div>
        </div>
    </form>

    @if (session()->has('status'))
        <div style="margin-top: 16px; padding: 12px; background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 8px; color: #155724;">
            {{ session('status') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div style="margin-top: 16px; padding: 12px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; color: #721c24;">
            {{ session('error') }}
        </div>
    @endif
</section>
