<div>
    <div class="bg-gray-80 rounded-lg relative">
        <form wire:submit="subscribe">
            <div class="flex items-center gap-10 flex-col justify-center mx-auto p-5 sm:p-10">
                <div class="flex flex-col mt-2 w-full xl:w-fit">
                    <p class="header-7 font-bold text-first-brand mb-1">{{ __('Newsletter') }}</p>
                    <p
                        class="text-first-brand font-extrabold text-[25px] leading-[35px] sm:text-lg md:text-xl lg:text-header-2 mb-[18px]">
                        {{ __('Subcribe our newsletter') }}
                    </p>
                    <p class="text-base font-medium text-gray-500 mb-7">
                        {{ __('By clicking the button, you are agreeing with our Term &amp; Conditions') }}
                    </p>
                    <div class="rounded-lg flex items-center py-3 pr-3 justify-between bg-gray-0 pl-4 sm:pl-9">
                        <input class="border-none outline-none text-base text-gray-200 font-medium flex-1"
                            wire:model.lazy="email" type="email" name="email"
                            placeholder="{{ __('Enter you mail...') }}">
                        <button class="bg-first-brand rounded-lg w-14 h-14 flex items-center justify-center"
                            type="submit">
                            <svg class="text-second-brand w-4 h-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('email')" for="email" class="mt-2 text-center" />
                </div>
            </div>
        </form>
    </div>
</div>
