<x-guest-layout>
    <style>
        /* Background and layout styling */
        body {
            background-image: url('{{ asset('images/login-background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Nunito', sans-serif;
        }

        .auth-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            margin: auto;
            margin-top: 100px;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #4A5568;
            font-size: 1.5rem;
            font-weight: 700;
        }

        /* Styling for buttons and inputs */
        input[type=email], input[type=password] {
            border: 1px solid #CBD5E0;
            border-radius: 6px;
            padding: 10px;
            width: 100%;
            margin-bottom: 1rem;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        input[type=email]:focus, input[type=password]:focus {
            outline: none;
            border-color: #3182CE;
            box-shadow: 0 0 0 2px rgba(66, 153, 225, 0.5);
        }

        .btn-primary {
            background-color: #48BB78;
            color: white;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #38A169;
        }

        /* Styling for links */
        .forgot-password-link {
            color: #4A5568;
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.3s;
        }

        .forgot-password-link:hover {
            color: #2B6CB0;
        }

        /* Adding a subtle animation */
        .auth-container {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

    </style>

    <div class="auth-container">
        <div class="auth-header">
            {{ __('Superuser Login') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="forgot-password-link" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <button type="submit" class="btn-primary">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
