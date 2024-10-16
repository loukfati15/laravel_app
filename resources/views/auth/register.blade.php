<x-guest-layout>
    <style>
        /* Background and container styling */
        body {
            background-image: url('{{ asset('images/register-background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Nunito', sans-serif;
        }

        .register-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
            margin-top: 100px;
        }

        h2 {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2rem;
            color: #4A5568;
        }

        .form-input {
            border: 1px solid #CBD5E0;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
            margin-bottom: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-input:focus {
            border-color: #3182CE;
            outline: none;
            box-shadow: 0 0 0 2px rgba(66, 153, 225, 0.5);
        }

        .checkbox-label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .checkbox-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .checkbox-container input {
            width: 18px;
            height: 18px;
            margin-right: 8px;
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

        .text-link {
            color: #4A5568;
            text-decoration: none;
            transition: color 0.3s;
        }

        .text-link:hover {
            color: #2B6CB0;
        }

        /* Multi-column layout for regions */
        .checkbox-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
        }

        .checkbox-container label {
            display: flex;
            align-items: center;
        }

    </style>

    <div class="register-container">
        <h2>{{ __('Register') }}</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <input id="name" class="form-input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <input id="email" class="form-input" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Telephone Number -->
            <div class="mt-4">
                <x-input-label for="N_telephone" :value="__('Telephone Number')" />
                <input id="N_telephone" class="form-input" type="text" name="N_telephone" :value="old('N_telephone')" required />
                <x-input-error :messages="$errors->get('N_telephone')" class="mt-2" />
            </div>

            <!-- Select Regions -->
            <div class="mt-4">
                <x-input-label for="region_number" :value="__('Select Regions')" />
                <div class="checkbox-container">
                    @foreach($regions as $region)
                        <label class="checkbox-label">
                            <input type="checkbox" class="form-checkbox" name="region_number[]" value="{{ $region->id }}">
                            <span>{{ $region->region_name }}</span>
                        </label>
                    @endforeach
                </div>
                <x-input-error :messages="$errors->get('region_number')" class="mt-2" />
            </div>

            <!-- Poste -->
            <div class="mt-4">
                <x-input-label for="poste" :value="__('Poste')" />
                <input id="poste" class="form-input" type="text" name="poste" :value="old('poste')" required />
                <x-input-error :messages="$errors->get('poste')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-4">
                <a class="text-link" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <button type="submit" class="btn-primary">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
