<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        

         <!-- Telephone Number -->
         <div class="mt-4">
            <x-input-label for="N_telephone" :value="__('Telephone Number')" />
            <x-text-input id="N_telephone" class="block mt-1 w-full" type="text" name="N_telephone" :value="old('N_telephone')" required />
            <x-input-error :messages="$errors->get('N_telephone')" class="mt-2" />
        </div>

        <!-- Select Regions -->
       <div class="mt-4">
            <x-input-label for="region_number" :value="__('Select Regions')" />
            <div class="block mt-1 w-full">
                @foreach($regions as $region)
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="form-checkbox" name="region_number[]" value="{{ $region->id }}">
                        <span class="ml-2">{{ $region->region_name }}</span>
                    </label>
                @endforeach
            </div>
            <x-input-error :messages="$errors->get('region_number')" class="mt-2" />
        </div>

        <!-- Poste -->
        <div class="mt-4">
            <x-input-label for="poste" :value="__('Poste')" />
            <x-text-input id="poste" class="block mt-1 w-full" type="text" name="poste" :value="old('poste')" required />
            <x-input-error :messages="$errors->get('poste')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>