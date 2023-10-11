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


        @if ($page->is_about)
            <section class="mx-auto px-10 py-20 h-auto bg-gray-100" id="about">
                <div class="flex flex-wrap items-center">
                    <div class="md:w-1/2 sm:w-full text-center sm:text-left">
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

                    <div class="md:w-1/2 sm:w-full">
                        <img class="pin bg-no-repeat md:bg-left w-full bg-center bg-cover h-screen"
                            src="{{ asset('uploads/sections/' . $this->aboutSection->image) }}">
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
    </section>
</div>
