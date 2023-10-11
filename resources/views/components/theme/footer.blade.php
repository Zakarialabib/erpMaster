<footer class="w-full mt-auto bg-green-50 text-green-900">
    <div class="px-6 py-6">
        <div class="grid gap-y-10 gap-x-4 sm:grid-cols-2 lg:grid-cols-3 items-center text-center justify-center">
            <div class="relative items-center align-middle text-center justify-center">
                <ul class="flex flex-col gap-3 font-bold items-center justify-between text-center ">
                    <img loading="lazy" src="{{ asset('images/' . settings('site_logo')) }}"
                        alt="{{ settings('company_name') }}"
                        class="flex flex-col items-center justify-between text-center"
                        style="height:45%;width:45%; justify-items: center;">
                </ul>
                <ul class="my-6 flex items-center text-center  justify-center gap-8">
                    <li>
                        <a href="{{ settings('social_facebook') }}" target="__blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ settings('social_instagram') }}" target="__blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ settings('social_linkedin') }}" target="__blank">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ settings('social_tiktok') }}" target="__blank">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ settings('social_whatsapp') }}" target="__blank">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="relative items-center align-middle text-center justify-center">
                <p class="mb-5 text-lg font-extrabold text-grey-500 ">
                    {{ __('Footer Section 1') }}
                </p>
                <div class="flex flex-col gap-y-4">
                    @foreach (Helpers::getFooterSection1Menu() as $index => $item)
                        <a href="{{ $item['url'] }}" @if ($item['new_window']) target="__blank" @endif
                            class="text-base font-normal text-green-950 hover:text-green-300  dark:hover:text-green-900 hover:underline focus:underline uppercase">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="relative items-center align-middle text-center justify-center">
                <p class="mb-5 text-lg font-extrabold text-grey-500 ">
                    {{ __('Footer Section 2') }}
                </p>
                <div class="flex flex-col gap-y-4">

                    @foreach (Helpers::getFooterSection2Menu() as $index => $item)
                        <a href="{{ $item['url'] }}" @if ($item['new_window']) target="__blank" @endif
                            class="text-base font-normal text-green-950 hover:text-green-300  dark:hover:text-green-900 hover:underline focus:underline uppercase">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="bg-green-800 text-white py-5 border-t-2 border-transparent">
        <div class="px-6">
            <div class="flex flex-col items-center justify-between text-center font-bold  md:flex-row">
                <div>
                    Copyright© <span class="curr-year">
                        {{ date('Y') }}
                    </span>
                    <a href="javascript:" class="text-indigo-400 transition hover:text-indigo-800">
                        {{-- {{ settings('company_name') }} --}}
                    </a>
                </div>
                <div>
                    <span>Besoin d'aide ?</span>
                    <a href="/contact" class="text-indigo-200 underline hover:text-indigo-50">
                        Contactez-nous
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
