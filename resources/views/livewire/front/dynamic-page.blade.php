<div>
    @section('title', $page->title)

    <section class="w-full border-y-2 border-y-gray-400 border-opacity-70">
        @if ($settings['is_sliders'])
            <section class="w-full mx-auto bg-gray-900 h-auto relative">
                <x-theme.slider :sliders="$this->sliders" />
            </section>
        @endif

        <div class="flex flex-col justify-center bg-white">
            @if ($settings['is_title'])
                <h1 class="uppercase block pt-5 my-4">{{ $page->title }}</h1>
            @endif

            @if ($settings['is_description'])
                <article
                    class="prose-2xl sm:prose-lg md:prose-xl lg:prose-2xl xl:prose-3xl mx-auto px-4 sm:px-6 lg:px-8">
                    <livewire:utils.editor-js editor-id="myEditor" :value="$description" :read-only="true" />
                </article>
            @endif
        </div>

        @if ($this->subcategories)
            <div class="w-full pb-5 px-4 mx-auto">
                <div class="flex flex-wrap justify-center overflow-x-scroll gap-4 py-4">
                    @foreach ($this->subcategories as $subcategory)
                        <a href="{{ route('front.subcategoryPage', $subcategory->slug) }}" class="relative w-44 h-44"
                            x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                            <div
                                class="absolute top-0 left-0 right-0 bottom-0 rounded-md bg-white shadow-lg transform hover:scale-105 transition-all duration-300">
                                <img class="absolute inset-0 w-full h-full object-cover transform-gpu transition-all duration-1000 ease-in-out"
                                    :class="{ 'rotate-0': !hover, 'rotate-360': hover }"
                                    src="{{ asset('images/subcategories/' . $subcategory->image) }}"
                                    alt="{{ $subcategory->name }}">
                                <div class="absolute inset-0 flex items-center justify-center text-center">
                                    <p class="text-md text-white  w-full font-bold bg-black opacity-75 shadow ">
                                        {{ $subcategory->name }} {{ __('for') }}
                                        {{ $subcategory->category?->name }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif


        <div class="py-5 px-4 mx-auto bg-gray-100">
            <div class="flex flex-col w-full px-10">
                @foreach ($this->sections as $section)
                    <div class="text-{{ $layout_config['item_style']['font_size'] ?? 'sm' }} 
                bg-{{ $layout_config['item_style']['background_color'] ?? 'transparent' }} 
                text-{{ $layout_config['item_style']['text_color'] ?? 'black' }}"
                        style="width: {{ $layout_config['item_style']['width'] ?? '100%' }}%;
                height: {{ $layout_config['item_style']['height'] ?? 'auto' }}%;
                padding: {{ $layout_config['item_style']['padding'] ?? '' }}px;
                margin: {{ $layout_config['item_style']['margin'] ?? '' }}px;
                border: {{ $layout_config['item_style']['border']['width'] ?? '' }}px {{ $layout_config['item_style']['border']['style'] ?? '' }} {{ $layout_config['item_style']['border']['color'] ?? '' }};
                border-radius: {{ $layout_config['item_style']['border_radius'] ?? '' }}px;
                box-shadow: {{ $layout_config['item_style']['box_shadow'] ?? '' }};">
                        <div class="border-b text-center">
                            @isset($layout_config['item_config']['paralax'])
                                <div class="bg-quote py-10 flex items-center justify-center h-[300px] mx-auto"
                                    style="background: url({{ asset('images/sections/' . $section->image) }}) center center no-repeat; background-attachment: fixed;">
                                    <h2 class="text-2xl text-center mb-4 font-bold font-heading">
                                        {{ $section->title }}
                                    </h2>
                                </div>
                            @else
                                <h3
                                    class="mb-4 text-center text-{{ $layout_config['item_style']['font_size'] ?? '2xl' }}  font-bold font-heading">
                                    {{ $section->title }}
                                </h3>
                            @endisset
                            @if ($section->subtitle)
                                <p>{{ $section->subtitle }}</p>
                            @endif
                        </div>
                        <div class="py-5 px-4 text-center">
                            <p class="text-lg text-gray-500">
                                {!! $section->description !!}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="w-full mt-4 mb-10">
            <div class="grid md:grid-cols-5 sm:grid-cols-3 gap-10 mx-10 px-10 py-10 bg-white">
                <div class="flex flex-col gap-y-2">
                    <div
                        class="w-full flex items-center justify-center mb-2 relative transition duration-500 ease-in-out transform hover:translate-y-[-5px">
                        <div
                            class="w-16 h-16 overflow-hidden rounded-full transition duration-500 ease-in-out transform hover:scale-110">
                            <img class="w-full h-full object-cover transition duration-500 ease-in-out filter grayscale hover:filter-none"
                                src="{{ asset('assets/img/tahe-icon-1.png') }}">
                        </div>
                    </div>
                    <h4
                        class="text-xl text-black text-center font-bold transition duration-500 ease-in-out transform hover:scale-110 hover:text-red-600">
                        Convient pour les végétaliens
                    </h4>
                </div>
                <div class="flex flex-col gap-y-2">
                    <div
                        class="w-full flex items-center justify-center mb-2 relative transition duration-500 ease-in-out transform hover:translate-y-[-5px">
                        <div
                            class="w-16 h-16 overflow-hidden rounded-full transition duration-500 ease-in-out transform hover:scale-110">
                            <img class="w-full h-full object-cover transition duration-500 ease-in-out filter grayscale hover:filter-none"
                                src="{{ asset('assets/img/tahe-icon-2.png') }}">
                        </div>
                    </div>
                    <h4
                        class="text-xl text-black text-center font-bold transition duration-500 ease-in-out transform hover:scale-110 hover:text-red-600">
                        Ingrédients naturels
                    </h4>
                </div>
                <div class="flex flex-col gap-y-2">
                    <div
                        class="w-full flex items-center justify-center mb-2 relative transition duration-500 ease-in-out transform hover:translate-y-[-5px">
                        <div
                            class="w-16 h-16 overflow-hidden rounded-full transition duration-500 ease-in-out transform hover:scale-110">
                            <img class="w-full h-full object-cover transition duration-500 ease-in-out filter grayscale hover:filter-none"
                                src="{{ asset('assets/img/tahe-icon-3.png') }}">
                        </div>
                    </div>
                    <h4
                        class="text-xl text-black text-center font-bold transition duration-500 ease-in-out transform hover:scale-110 hover:text-red-600">
                        Huiles essentielles
                    </h4>
                </div>
                <div class="flex flex-col gap-y-2">
                    <div
                        class="w-full flex items-center justify-center mb-2 relative transition duration-500 ease-in-out transform hover:translate-y-[-5px">
                        <div
                            class="w-16 h-16 overflow-hidden rounded-full transition duration-500 ease-in-out transform hover:scale-110">
                            <img class="w-full h-full object-cover transition duration-500 ease-in-out filter grayscale hover:filter-none"
                                src="{{ asset('assets/img/tahe-icon-4.png') }}">
                        </div>
                    </div>
                    <h4
                        class="text-xl text-black text-center font-bold transition duration-500 ease-in-out transform hover:scale-110 hover:text-red-600">
                        Eco-Certification
                    </h4>
                </div>
                <div class="flex flex-col gap-y-2">
                    <div
                        class="w-full flex items-center justify-center mb-2 relative transition duration-500 ease-in-out transform hover:translate-y-[-5px">
                        <div
                            class="w-16 h-16 overflow-hidden rounded-full transition duration-500 ease-in-out transform hover:scale-110">
                            <img class="w-full h-full object-cover transition duration-500 ease-in-out filter grayscale hover:filter-none"
                                src="{{ asset('assets/img/tahe-icon-5.png') }}">
                        </div>
                    </div>
                    <h4
                        class="text-xl text-black text-center font-bold transition duration-500 ease-in-out transform hover:scale-110 hover:text-red-600">
                        Principes actifs Organiques
                    </h4>
                </div>
            </div>
        </div>

        @if ($this->featuredProducts)
            <div class="px-10 w-full mb-16">
                <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 ">
                    @foreach ($this->featuredProducts as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        @endif

        @if ($settings['is_about'])
            <section class="px-10 py-10 h-auto bg-white" id="about">
                <div class="flex flex-wrap items-center my-4">
                    <div class="md:w-1/2 sm:w-full text-center sm:text-left">
                        <div class="inline-block">
                            <div class="h-6 w-6 bg-red-600 rounded-full z-0 absolute mx-auto"></div>
                            <h3
                                class="pb-10 text-3xl md:text-4xl lg:text-5xl leading-tight font-bold lg:text-heading-1 tracking-tighter uppercase cursor-pointer z-10 relative">
                                <span class="hover:underline transition duration-200 ease-in-out">
                                    {{ $this->aboutSection?->title }}
                                </span>
                            </h3>
                        </div>

                        <div class="mb-8 max-w-3xl w-full">
                            <div class="text-base text-gray-800">
                                {!! $this->aboutSection?->description !!}
                            </div>
                        </div>
                    </div>
                    <div class="md:w-1/2 sm:w-full hidden md:flex pl-5 justify-center relative ">
                        <img class="pin bg-no-repeat md:bg-left w-full bg-center bg-cover rounded-3xl"
                            alt="{{ $this->aboutSection?->title }}"
                            src="{{ asset('images/sections/' . $this->aboutSection?->image) }}">
                        <div
                            class="to-bg-black-10 absolute inset-0 h-full w-full rounded-3xl bg-gradient-to-tr from-transparent via-transparent to-black/60">
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if ($settings['is_contact'])
            <div class="bg-gray-100 relative px-10 py-10 text-center sm:text-left" id="contact">
                <div class="mx-auto relative">
                    <p class="text-capitalized text-gray-500 uppercase tracking-[2px] mb-[15px]">
                        {{ $this->contactSection?->subtitle }}
                    </p>
                    <div class="inline-block text-center sm:text-left">
                        <div class="h-6 w-6 bg-green-500 mx-auto rounded-full z-0 absolute"></div>
                        <h3
                            class="pb-10 text-3xl md:text-4xl lg:text-5xl leading-tight font-bold lg:text-heading-1 tracking-tighter uppercase cursor-pointer z-10 relative">
                            <span class="hover:underline transition duration-200 ease-in-out">
                                {{ $this->contactSection?->title }}
                            </span>
                        </h3>
                    </div>
                    <div class="text-base text-gray-600 mb-10">
                        {!! $this->contactSection?->description !!}
                    </div>
                </div>

                <div class="w-full grid md:grid-cols-2 sm:grid-cols-1 gap-8 mb-[15px] md:mb-[25px] md:gap-[50px]">
                    <div class="flex flex-col gap-[13px] mb-[15px] md:mb-[25px]">
                        <p class="text-base text-gray-600">
                            <span class="text-heading-6 pr-4 text-green-600">
                                {{ __('Address') }}
                            </span>
                            {{ settings('company_address') }}
                        </p>
                        <p class="text-base text-gray-600">
                            <span class="text-heading-6 pr-4 text-green-600">
                                {{ __('Phone number') }}
                            </span>
                            {{ settings('company_phone') }}
                        </p>
                        <p class="text-base text-gray-600">
                            <span class="text-heading-6 pr-4 text-green-600">
                                {{ __('Email') }}
                            </span>
                            {{ settings('company_email') }}
                        </p>
                    </div>
                    <div class="flex-1">
                        <livewire:front.contact-form :type="$page->type" :page="$page->title" />
                    </div>
                </div>
            </div>
        @endif
    </section>
</div>
