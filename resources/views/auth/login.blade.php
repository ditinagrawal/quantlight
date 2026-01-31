<x-guest-layout>
    <div class="login-container">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" style="font-size: 0.875rem; color: #706f6c;" :status="session('status')" />

        <h1 style="font-weight: 500; font-size: 2rem; color: #1b1b18; margin-bottom: 1.5rem;">Log in</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div style="margin-bottom: 1rem;">
                <x-input-label for="email" :value="__('Email')" class="login-label" />
                <x-text-input id="email" 
                    class="login-input"
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    autocomplete="username"
                    placeholder="Enter your email" />
                <x-input-error :messages="$errors->get('email')" style="margin-top: 0.5rem; font-size: 0.875rem; color: #f53003;" />
            </div>

            <!-- Password -->
            <div style="margin-bottom: 1rem;">
                <x-input-label for="password" :value="__('Password')" class="login-label" />

                <x-text-input id="password" 
                    class="login-input"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password"
                    placeholder="Enter your password" />

                <x-input-error :messages="$errors->get('password')" style="margin-top: 0.5rem; font-size: 0.875rem; color: #f53003;" />
            </div>

            <!-- Remember Me -->
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
                <label for="remember_me" style="display: inline-flex; align-items: center; cursor: pointer;">
                    <input id="remember_me" 
                        type="checkbox" 
                        class="login-checkbox"
                        name="remember">
                    <span style="margin-left: 0.5rem; font-size: 0.875rem; color: #706f6c;">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="login-link" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <div style="display: flex; align-items: center; justify-content: flex-end;">
                <x-primary-button class="login-button">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
