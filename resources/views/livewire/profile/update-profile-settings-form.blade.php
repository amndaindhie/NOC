<section style="background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1); font-family: 'Poppins', sans-serif;">

    <!-- Pesan sukses / info -->
    @if($message)
        <div style="background: #42c428; color: #fff; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 13px;">
            {{ $message }}
        </div>
    @endif

    <!-- Pesan error -->
    @if($errorMessage)
        <div style="background: #e74c3c; color: #fff; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 13px;">
            {{ $errorMessage }}
        </div>
    @endif

    <!-- Header -->
    <header>
        <h2 style="color: #333; font-size: 18px; font-weight: 600;">
            {{ __('Profile Settings') }}
        </h2>
        <p style="margin-top: 4px; font-size: 14px; color: #666;">
            {{ __("Update your account's profile information and password.") }}
        </p>
    </header>

    <!-- Form -->
    <form wire:submit.prevent="updateProfileSettings" style="margin-top: 24px;">

        <!-- Name -->
        <div style="margin-bottom: 24px;">
            <label for="name" style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">
                {{ __('Name') }}
            </label>
            <input wire:model="name" id="name" type="text"
                   style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif;"
                   required autofocus autocomplete="name" />
            <div style="margin-top: 4px; color: #e74c3c; font-size: 12px;">
                @error('name') {{ $message }} @enderror
            </div>
        </div>

        <!-- Email -->
        <div style="margin-bottom: 24px;">
            <label for="email" style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">
                {{ __('Email') }}
            </label>
            <input wire:model="email" id="email" type="email"
                   style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif;"
                   required autocomplete="username" />
            <div style="margin-top: 4px; color: #e74c3c; font-size: 12px;">
                @error('email') {{ $message }} @enderror
            </div>
        </div>

        <!-- Password -->
        <div style="margin-bottom: 24px;">
            <label for="current_password" style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">
                {{ __('Current Password') }}
            </label>
            <input wire:model="current_password" id="current_password" type="password"
                   style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif;"
                   autocomplete="current-password" />
            <div style="margin-top: 4px; color: #e74c3c; font-size: 12px;">
                @error('current_password') {{ $message }} @enderror
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <label for="password" style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">
                {{ __('New Password') }}
            </label>
            <input wire:model="password" id="password" type="password"
                   style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif;"
                   autocomplete="new-password" />
            <div style="margin-top: 4px; color: #e74c3c; font-size: 12px;">
                @error('password') {{ $message }} @enderror
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <label for="password_confirmation" style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">
                {{ __('Confirm Password') }}
            </label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password"
                   style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif;"
                   autocomplete="new-password" />
            <div style="margin-top: 4px; color: #e74c3c; font-size: 12px;">
                @error('password_confirmation') {{ $message }} @enderror
            </div>
        </div>

        <!-- Actions -->
            <div style="display: flex; align-items: center; gap: 16px;">
                <button type="submit" class="btn-primary">
                    {{ __('Save Changes') }}
                </button>

                <a href="{{ route('settings.profile') }}" class="btn-secondary">
                    {{ __('Cancel') }}
                </a>

               
            </div>

    </form>
</section>
