<div>
    @section('title', $page->title)

    <section class="w-full pb-6">
        @if ($is_sliders)
            <section class="w-full mx-auto bg-gray-900 h-auto relative">
                <x-theme.slider :sliders="$this->sliders" />
            </section>
        @endif

        @isset($section)
            <x-section :section="$section" />
        @endisset

        <div class="flex flex-col justify-center pt-4 bg-white">
            {{-- @if (is_title) --}}
            <h1 class="uppercase block my-4">{{ $page->title }}</h1>
            {{-- @endif --}}

            {{-- @if (is_description) --}}
            <article class="prose-2xl sm:prose-lg md:prose-xl lg:prose-2xl xl:prose-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <livewire:utils.editor-js editor-id="myEditor" :value="$description" :read-only="true" />
            </article>
            {{-- @endif --}}

        </div>

        <div class="px-10">
            @if ($page->is_outdoor_activity)
                <div class="px-10 md:px-[36px] xl:px-0 mt-[70px] lg:mt-[100px]">
                    <div class="lg:grid lg:grid-cols-2 lg:gap-[30px] xl:gap-[95px]">
                        <div class="relative">
                            <img class="rounded-2xl mb-[30px] lg:mb-0 lg:flex-1"
                                src="{{ asset('uploads/sections/' . $this->outdoorActivity?->image) }}"
                                alt="{{ $this->outdoorActivity?->name }}">
                        </div>
                        <div class="flex-1 order-1">
                            <span
                                class="font-chivo inline-block bg-bg-2 text-orange-900 py-[14px] px-[28px] rounded-[50px] text-[14px] leading-[14px] mb-[22px]">
                                {{ $this->outdoorActivity?->name }}
                            </span>
                            <h3
                                class="font-chivo font-bold lg:text-heading-1 md:text-[46px] md:leading-[52px] text-[35px] leading-[44px] mb-[22px]">
                                {{ $this->outdoorActivity?->subtitle }}
                            </h3>
                            <p class="text-quote md:text-lead-lg text-gray-600 mb-[50px]">
                                {!! $this->outdoorActivity?->description !!}
                            </p>
                            <div class="border border-green-900 border-dashed mb-[48px]"></div>
                            <div class="md:grid md:grid-cols-2 md:gap-y-[34px] lg:gap-x-[70px]">
                                @foreach (getActiveOutdoorActivities()-> asactivity)
                                    <div class="mb-[30px] lg:mb-0">
                                        <h4 class="text-heading-6 font-chivo font-bold">{{ $activity->name }}</h4>
                                        <p class="text-excerpt text-gray-600">
                                            {!! $activity->description !!}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- is_workshop_activity --}}
            @if ($page->is_workshop_activity)
                <div class="px-10 md:px-[36px] xl:px-0 mt-[70px] lg:mt-[150px]">
                    <div class="lg:grid lg:grid-cols-2 gap-[150px]"><img
                            class="h-full w-full object-cover order-2 rounded-2xl mb-[30px] lg:mb-0 lg:flex-1"
                            src="{{ asset('uploads/sections/' . $this->workshopActivity?->image) }}"
                            alt="{{ $this->workshopActivity?->name }}">
                        <div class="flex-1 lg:gap-[30px] xl:gap-[64px]"><span
                                class="font-chivo inline-block bg-bg-9 text-primary py-[14px] px-[28px] rounded-[50px] text-[14px] leading-[14px] mb-[22px]">
                                {{ $this->workshopActivity?->name }}
                            </span>
                            <h3
                                class="font-chivo font-bold lg:text-heading-1 md:text-[46px] md:leading-[52px] text-[35px] leading-[44px] mb-[22px]">
                                {{ $this->workshopActivity?->subtitle }}

                            </h3>
                            <p class="text-quote md:text-lead-lg text-gray-600 mb-[50px]">
                                {!! $this->workshopActivity?->description !!}
                            </p>
                            <div class="md:grid md:grid-cols-2 md:gap-y-[34px] lg:gap-x-[70px]">
                                @foreach (getActiveWorkshopActivities()-> asactivity)
                                    <div class="mb-[30px] lg:mb-0">
                                        <h4 class="text-heading-6 font-chivo font-bold">{{ $activity->name }}</h4>
                                        <p class="text-excerpt text-gray-600">
                                            {!! $activity->description !!}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if ($page->is_package)
                <div class="px-10 md:px-[36px] xl:px-0 mt-[70px] lg:mt-[139px]">
                    <div class="text-center">
                        <h2
                            class="font-bold font-chivo mx-auto text-[35px] leading-[44px] md:text-[46px] md:leading-[52px] lg:text-heading-1 text-gray-900 mb-5 md:mb-[30px] max-w-[725px]">
                            Choose The Best Plan That’s For You</h2>
                        <p class="text-quote md:text-lead-lg text-gray-600 mx-auto max-w-[976px]">
                        </p>
                    </div>

                    <div class="package">
                        <div class="grid package-list gap-[30px] md:grid-cols-2 xl:grid-cols-4">

                            @foreach (getActivePackages()-> aspackage)
                                <div
                                    class="rounded-2xl p-[35px] bg-white flex flex-col justify-between transition-all duration-300 package-card border border-gray-900 bill-monthly">
                                    <div>
                                        <div class="mb-[21px]"><span
                                                class="text-heading-3 font-bold font-chivo">{{ $package->price }}
                                                DH</span>
                                        </div>
                                        <h5 class="text-heading-5 font-chivo font-bold mb-[9px]">{{ $package->name }}
                                        </h5>

                                        <p class="text-sm font-bold text-gray-400 mb-[43px]">
                                            {!! $package->description !!}
                                        </p>
                                        <div class="w-full bg-gray-300 h-[1px] mb-[21px]"></div>
                                        <ul class="mb-[76px]">

                                            <li class="flex items-center gap-[10px] mb-[17px]">
                                                <span class="text-md text-gray-500">
                                                    <i class="fas fa-check text-green-500"></i>
                                                    {{ count(json_decode($package->activities)) }}
                                                    {{ __('Activities') }}
                                                </span>
                                            </li>

                                            @foreach (json_decode($package->activities) as $index => $activity)
                                                <li class="flex items-center gap-[10px] mb-[17px]">
                                                    <span class="text-md text-gray-500">
                                                        @php($name = \App\Models\Activity::find($activity)->name)
                                                        {{ $name }}
                                                    </span>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                    <button type="button">
                                        <a class="flex items-center z-10 relative transition-all duration-200 group py-[11px] px-[22px] rounded-md bg-gray-900 text-white hover:bg-gray-100 hover:text-gray-900 border-[2px] border-[#171B24]"
                                            href="#">
                                            <span
                                                class="block text-inherit w-full h-full rounded-md text-lg font-chivo font-semibold">
                                                Get Started
                                            </span><i
                                                class="fas fa-arrow-right ml-[7px] w-[12px] filter-white group-hover:filter-black"></i>
                                        </a>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                @if ($page->is_about)
                    <section class="mx-auto px-10 py-20 h-auto bg-gray-100" id="about">
                        <div class="flex flex-wrap items-center">
                            <div class="w-3/4">
                                <h3
                                    class="pb-10 text-3xl md:text-4xl lg:text-5xl text-left leading-tight text-green-600 font-bold tracking-tighter uppercase cursor-pointer">
                                    <span class="hover:underline transition duration-200 ease-in-out">
                                        {{ $this->aboutSection->title }}
                                    </span>
                                </h3>

                                <div class="mb-8 max-w-3xl w-full">
                                    <p class="text-base text-gray-800">
                                        {!! $this->aboutSection->description !!}
                                    </p>
                                </div>
                            </div>

                            <div class="w-1/4">
                                <div class="flex justify-center items-center pin bg-no-repeat md:bg-left w-full bg-center bg-cover h-screen"
                                    style="background-image: url({{ asset('uploads/sections/' . $this->aboutSection->image) }});">
                                </div>
                            </div>
                        </div>
                    </section>
                @endif

                @if ($page->is_contact)
                    <div
                        class="bg-gray-100 relative p-[40px] md:pt-[91px] md:pr-[98px] md:pb-[86px] md:pl-[92px] mt-[150px] rounded-[58px]">
                        <div class="mx-auto relative max-w-[1320px]">
                            <p class="text-capitalized text-gray-500 uppercase tracking-[2px] mb-[15px]">
                                {{ $this->contactSection?->subtitle }}
                            </p>
                            <h2 class="font-bold font-chivo text-[25px] leading-[30px] md:text-heading-3 mb-[22px]">
                                {{ $this->contactSection->title }}
                            </h2>
                            <p class="text-text text-gray-600 mb-[30px] md:mb-[60px]">
                                {!! $this->contactSection->description !!}
                            </p>
                        </div>
                        <div class="flex flex-col gap-8 mb-[15px] md:mb-[25px] lg:flex-row lg:gap-[50px] xl:gap-[98px]">
                            <div>
                                <div class="flex gap-[13px] mb-[15px] md:mb-[25px]"> <i
                                        class="fas fa-map-marker-alt text-heading-6 text-green-600"></i>
                                    {{ settings('company_name') }}
                                    </p>
                                </div>
                                <p class="text-text text-gray-600">
                                    {{ settings()->site_name }}
                                </p>
                                <p class="text-text text-gray-600 underline">
                                    {{ settings('company_address') }}

                                </p>
                                <p class="text-text text-gray-600 underline"> {{ settings('company_phone') }}

                                </p>
                            </div>

                            <livewire:front.contact-form lazy :type="$page->type" />
                        </div>
                    </div>
                @endif
        </div>
    </section>
</div>
