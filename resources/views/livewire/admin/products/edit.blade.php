<div>
    <!-- Edit Modal -->
    <x-modal wire:model="editModal">
        <x-slot name="title">
            {{ __('Edit Product') }} - {{ $product?->name }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit="update">
                <x-validation-errors class="mb-4" :errors="$errors" />
                <div>
                    <div class="md:w-1/2 sm:w-full px-3">
                        <x-label for="code" :value="__('Code')" required />
                        <x-input id="code" class="block mt-1 w-full" type="text" name="code"
                            wire:model="code" placeholder="{{ __('Enter Product Code') }}" required autofocus />
                        <x-input-error :messages="$errors->get('code')" for="code" class="mt-2" />
                    </div>
                    <div class="md:w-1/2 sm:w-full px-2">
                        <x-label for="name" :value="__('Product Name')" required />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                            wire:model="name" placeholder="{{ __('Enter Product Name') }}" required />
                        <x-input-error :messages="$errors->get('name')" for="name" class="mt-2" />
                    </div>
                    <div class="md:w-1/2 sm:w-full px-2">
                        <x-label for="category" :value="__('Category')" required />
                        <x-select-list :options="$this->categories" id="category_create" name="category_create"
                            wire:model.live="category_id" />
                        <x-input-error :messages="$errors->get('category_id')" for="category_id" class="mt-2" />
                    </div>
                    <div class="w-full lg:w-1/2 px-3 mb-6 lg:mb-0">
                        <x-label for="subcategories" :value="__('Subcategories')" />
                        <select multiple id="subcategories" name="subcategories"
                            class="block bg-white text-gray-700 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                            wire:model="subcategories">
                            <option value="" disabled>{{ __('Select SubCategory') }}</option>
                            @foreach ($this->subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}"
                                    @if ($subcategory->id == $product->subcategories) selected @endif>
                                    {{ $subcategory->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('subcategories')" for="subcategories" class="mt-2" />
                    </div>
                </div>
                <div class="flex flex-wrap mb-3">

                    <div class="flex flex-col justify-center px-2 mt-2 border border-gray-300 rounded-md w-full">
                        <h4 class="font-semibold text-left">{{ __('Initial Warehouse Stock') }}</h4>

                        @foreach ($productWarehouses as $warehouse)
                            <div class="flex items-center w-full gap-2 py-4">
                                <div class="w-1/4">
                                    <h4 class="font-semibold">{{ $warehouse->name }}</h4>
                                </div>
                                <div class="w-1/4">
                                    <x-label for="price_{{ $warehouse->id }}" :value="__('Price')" required />
                                    <input id="price_{{ $warehouse->id }}" required class="w-full" type="text"
                                        name="price_{{ $warehouse->id }}"
                                        wire:model="productWarehouse.{{ $warehouse->id }}.price" />
                                    <x-input-error :messages="$errors->get('prices.' . $warehouse->id)" for="price_{{ $warehouse->id }}"
                                        class="mt-2" />
                                </div>
                                <div class="w-1/4">
                                    <x-label for="cost_{{ $warehouse->id }}" :value="__('Cost')" required />
                                    <input type="text" required class="w-full"
                                        wire:model="productWarehouse.{{ $warehouse->id }}.cost"
                                        id="cost_{{ $warehouse->id }}" name="cost_{{ $warehouse->id }}" />
                                    <x-input-error :messages="$errors->get('costs.' . $warehouse->id)" for="cost_{{ $warehouse->id }}" class="mt-2" />
                                </div>
                                <div class="w-1/4">
                                    <x-label for="old_price_{{ $warehouse->id }}" :value="__('Old Price')" required />
                                    <input type="text" required class="w-full"
                                        wire:model="productWarehouse.{{ $warehouse->id }}.old_price"
                                        id="old_price_{{ $warehouse->id }}" name="old_price_{{ $warehouse->id }}" />
                                    <x-input-error :messages="$errors->get('old_price.' . $warehouse->id)" for="old_price_{{ $warehouse->id }}"
                                        class="mt-2" />
                                </div>
                                <div class="w-1/4">
                                    <x-label for="qty_{{ $warehouse->id }}" :value="__('Quantity')" />
                                    <input type="text" required class="w-full bg-gray-200 text-gray-600"
                                        wire:model="productWarehouse.{{ $warehouse->id }}.qty" disabled
                                        id="qty_{{ $warehouse->id }}" name="qty_{{ $warehouse->id }}" />
                                </div>
                                <div class="w-1/4">
                                    <x-label for="stock_alert" :value="__('Stock Alert')" required />
                                    <input type="text" required class="w-full bg-gray-200 text-gray-600"
                                        wire:model="productWarehouse.{{ $warehouse->id }}.stock_alert"
                                        id="stock_alert_{{ $warehouse->id }}"
                                        name="stock_alert_{{ $warehouse->id }}" />
                                    <x-input-error :messages="$errors->get('stock_alert')" for="stock_alert" class="mt-2" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <x-accordion title="{{ 'More Details' }}">
                    <div class="flex flex-wrap -mx-2 mb-3">
                        <div class="lg:w-1/3 sm:w-1/2 px-2"> <x-label for="brand_id" :value="__('Brand')" />
                            <x-select-list :options="$this->brands" id="brand_edit" name="brand_edit" wire:model="brand_id" />
                            <x-input-error :messages="$errors->get('brand_id')" for="brand_id" class="mt-2" />
                        </div>
                        <div class="lg:w-1/3 sm:w-1/2 px-2">
                            <x-label for="order_tax" :value="__('Tax')" />
                            <x-input id="order_tax" class="block mt-1 w-full" type="text" name="order_tax"
                                wire:model="order_tax" />
                            <x-input-error :messages="$errors->get('order_tax')" for="order_tax" class="mt-2" />
                        </div>
                        <div class="lg:w-1/3 sm:w-1/2 px-2">
                            <x-label for="tax_type" :value="__('Tax type')" />
                            <select wire:model="tax_type" name="tax_type"
                                class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded">
                                <option value="inclusive">{{ __('Inclusive') }}</option>
                                <option value="exclusive">{{ __('Exclusive') }}</option>
                            </select>
                        </div>

                        <div class="w-full">
                            <x-label for="video" :value="__('Embeded Video')" />
                            <x-input id="embeded_video" class="block mt-1 w-full" type="text"
                                name="embeded_video" wire:model="embeded_video" />
                            <x-input-error :messages="$errors->get('embeded_video')" for="embeded_video" class="mt-2" />
                        </div>

                        <div class="lg:w-1/3 sm:w-1/2 px-2">
                            <x-label for="condition" :value="__('Condition')" />
                            <x-input id="condition" class="block mt-1 w-full" type="text" name="condition"
                                wire:model="condition" required />
                        </div>
                        <div class="lg:w-1/3 sm:w-1/2 px-2">
                            <x-label for="meta_title" :value="__('Meta title')" />
                            <x-input id="meta_title" class="block mt-1 w-full" type="text" name="meta_title"
                                wire:model="meta_title" required />
                        </div>
                        <div class="lg:w-1/3 sm:w-1/2 px-2">
                            <x-label for="meta_description" :value="__('Meta description')" />
                            <x-input id="meta_description" class="block mt-1 w-full" type="text"
                                name="meta_description" wire:model="meta_description" required />
                        </div>
                        <div class="lg:w-1/3 sm:w-1/2 px-2">
                            <x-label for="barcode_symbology" :value="__('Barcode Symbology')" />
                            <select wire:model="barcode_symbology" name="barcode_symbology"
                                class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded"
                                required>
                                <option selected value="C128">Code 128</option>
                                <option value="C39">Code 39</option>
                                <option value="UPCA">UPC-A</option>
                                <option value="UPCE">UPC-E</option>
                                <option value="EAN13">EAN-13</option>
                                <option value="EAN8">EAN-8</option>
                            </select>
                        </div>
                        <div class="md:w-1/2 sm:w-full px-4 gap-2">
                            <x-label for="featured" :value="__('Favorite proudct')" />
                            <x-input.checkbox id="featured" type="checkbox" name="featured"
                                wire:model="featured" />
                            <x-label for="best" :value="__('Best proudct')" />
                            <x-input.checkbox id="best" type="checkbox" name="best" wire:model="best" />
                            <x-label for="hot" :value="__('Hot proudct')" />
                            <x-input.checkbox id="hot" type="checkbox" name="hot" wire:model="hot" />
                            <x-input-error :messages="$errors->get('featured')" for="featured" class="mt-2" />
                        </div>
                    </div>
                </x-accordion>

                <div class="w-full px-3 mb-6 lg:mb-0">
                    <x-label for="description" :value="__('Description')" />
                    <x-trix wire:model="description" name="description" />
                </div>

                <div class="w-full px-4 my-4">
                    <x-label for="image" :value="__('Product Image')" />
                    <x-fileupload wire:model="image" :file="$image" accept="image/jpg,image/jpeg,image/png" />
                    <x-input-error :messages="$errors->get('image')" for="image" class="mt-2" />
                </div>

                <div class="w-full px-4">
                    <x-button primary type="submit" wire:loading.attr="disabled" class="w-full text-center">
                        {{ __('Update') }}
                    </x-button>
                </div>
            </form>
        </x-slot>
    </x-modal>
    <!-- End Edit Modal -->
</div>
