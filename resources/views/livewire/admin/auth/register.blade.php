<div>
    @section('title', __('Register'))

    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">

        <h2 class="mt-6 text-3xl font-extrabold text-gray-900 leading-9">
            {{ __('Register') }}
        </h2>
        <p class="text-base font-medium text-gray-500 mb-6">
            {{ __('Create an account today') }}.
        </p>
    </div>


    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <x-validation-errors class="mb-4" :errors="$errors" />

        <form wire:submit="register">

            <div class="w-full">
                <!-- Name -->
                <div class="px-2">
                    <x-label for="name" :value="__('Name')" required />

                    <x-text-input id="name" wire:model="name" class="block mt-1 w-full" type="text"
                        autocomplete="name" name="name" :value="old('name')" required autofocus />

                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="px-2">
                    <x-label for="email" :value="__('Email')" required />

                    <x-text-input id="email" wire:model="email" class="block mt-1 w-full" type="email"
                        autocomplete="email" name="email" :value="old('email')" required />

                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Phone -->
                <div class="px-2">
                    <x-label for="phone" :value="__('Phone')" required />

                    <x-text-input id="phone" wire:model="phone" class="block mt-1 w-full" type="text"
                        autocomplete="mobile" name="phone" :value="old('phone')" required />

                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Country -->
                <div class="px-2">
                    <x-label for="country" :value="__('Country')" required />

                    <x-input id="country" class="block mt-1 w-full" wire:model="country" type="text" name="country"
                        :value="old('country')" disabled />
                </div>

                <!-- City -->
                <div class="px-2">
                    <x-label for="city" :value="__('City')" required />

                    <x-input id="city" class="block mt-1 w-full" wire:model="city" type="text" name="city"
                        :value="old('city')" required />
                </div>

                <!-- Password -->
                <div class="px-2 relative" x-data="{ show: true }">
                    <x-label for="password" :value="__('Password')" />
                    <div class="relative">
                        <input placeholder="" :type="show ? 'password' : 'text'" name="password" required
                            wire:model="password"
                            class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">

                            <svg class="h-6 text-gray-700" fill="none" @click="show = !show"
                                :class="{ 'block': !show, 'hidden': show }" xmlns="http://www.w3.org/2000/svg"
                                viewbox="0 0 576 512">
                                <path fill="currentColor"
                                    d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                                </path>
                            </svg>

                            <svg class="h-6 text-gray-700" fill="none" @click="show = !show"
                                :class="{ 'hidden': !show, 'block': show }" xmlns="http://www.w3.org/2000/svg"
                                viewbox="0 0 640 512">
                                <path fill="currentColor"
                                    d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                                </path>
                            </svg>
                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="px-2">
                    <x-label for="password_confirmation" :value="__('Confirm Password')" required />

                    <x-text-input id="password_confirmation" wire:model="passwordConfirmation" class="block mt-1 w-full"
                        type="password" name="password_confirmation" required />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <div class="flex px-4 items-center justify-between mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="/admin/login" wire:navigate>
                    {{ __('Already registered?') }}
                </a>

                <x-button type="submit" primary class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </div>

</div>
