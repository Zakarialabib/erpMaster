<div>
    @section('title', __('Confirm your password'))

    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <h2 class="mt-6 text-3xl font-extrabold text-gray-900 leading-9">
            {{ __('Confirm your password') }}
        </h2>
        <p class="mt-2 text-sm text-center text-gray-600 leading-5 max-w">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <form wire:submit="confirmPassword">
            <div>
                <x-label for="password" :value="__('Password')" />

                <div class="mt-1 rounded-md shadow-sm">
                    <x-input wire:model="password" id="password" name="password" type="password" required autofocus />
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit"
                    class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                    {{ __('Confirm') }}
                </button>
            </div>
        </form>
    </div>
</div>
