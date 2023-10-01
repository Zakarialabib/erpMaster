<div>
    @section('title', __('Reset password'))

    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <h2 class="mt-6 text-3xl font-extrabold text-gray-900 leading-9">
            {{ __('Reset password') }}
        </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <form wire:submit="resetPassword">
            <div>
                <x-label for="password" :value="__('Password')" />

                <x-input wire:model="email" id="email" type="email" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-label for="password" :value="__('Password')" />
                <x-input wire:model="password" id="password" type="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />
                <div class="mt-1 rounded-md shadow-sm">
                    <input wire:model="passwordConfirmation" id="password_confirmation" type="password" required
                        class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 appearance-none rounded-md focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button type="submit" primary>
                    {{ __('Reset Password') }}
                </x-button>
            </div>
        </form>
    </div>
</div>
