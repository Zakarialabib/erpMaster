<div>
    <div class="px-6 py-10">
        <h3 class="text-lg font-bold">Media Library</h3>

        <div class="mb-4">
            <label for="model" class="mr-2">Select Model:</label>
            <select wire:model="model" id="model" class="p-2 border rounded">
                <option value="">All</option>
                @foreach ($models as $modelName)
                    <option value="{{ $modelName }}">{{ $modelName }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <div x-data="{
                imageGalleryOpened: false,
                imageGalleryActiveUrl: null,
                imageGalleryImageIndex: null,
                imageGalleryOpen(event) {
                    this.imageGalleryImageIndex = event.target.dataset.index;
                    this.imageGalleryActiveUrl = event.target.src;
                    this.imageGalleryOpened = true;
                    $wire.setActiveImage(event.target.dataset.index);
                },
                imageGalleryClose() {
                    this.imageGalleryOpened = false;
                    setTimeout(() => this.imageGalleryActiveUrl = null, 300);
                },
                imageGalleryNext() {
                    if (this.imageGalleryImageIndex == this.$refs.gallery.childElementCount) {
                        this.imageGalleryImageIndex = 1;
                    } else {
                        this.imageGalleryImageIndex = parseInt(this.imageGalleryImageIndex) + 1;
                    }
                    this.imageGalleryActiveUrl = this.$refs.gallery.querySelector('[data-index=\'' + this.imageGalleryImageIndex + '\']').src;
                    $wire.setActiveImage(this.imageGalleryImageIndex);
                },
                imageGalleryPrev() {
                    if (this.imageGalleryImageIndex == 1) {
                        this.imageGalleryImageIndex = this.$refs.gallery.childElementCount;
                    } else {
                        this.imageGalleryImageIndex = parseInt(this.imageGalleryImageIndex) - 1;
                    }
                    this.imageGalleryActiveUrl = this.$refs.gallery.querySelector('[data-index=\'' + this.imageGalleryImageIndex + '\']').src;
                    $wire.setActiveImage(this.imageGalleryImageIndex);
                },
            }" @image-gallery-next.window="imageGalleryNext()"
                @image-gallery-prev.window="imageGalleryPrev()" @keyup.right.window="imageGalleryNext();"
                @keyup.left.window="imageGalleryPrev();" x-init="imageGalleryPhotos = $refs.gallery.querySelectorAll('img');
                for (let i = 0; i < imageGalleryPhotos.length; i++) {
                    imageGalleryPhotos[i].setAttribute('data-index', i + 1);
                }" class="w-full h-full select-none">
                <div class="max-w-6xl mx-auto duration-1000 delay-300 opacity-0 select-none ease animate-fade-in-view"
                    style="translate: none; rotate: none; scale: none; opacity: 1; transform: translate(0px, 0px);">
                    <ul x-ref="gallery" id="gallery" class="grid grid-cols-2 gap-5 lg:grid-cols-5">
                        @if ($mediaItems)
                            @foreach ($mediaItems as $index => $media)
                                <li>
                                    <img x-on:click="imageGalleryOpen" src="{{ $media->getUrl() }}"
                                        class="object-cover select-none w-full h-auto bg-gray-200 rounded cursor-zoom-in aspect-[5/6] lg:aspect-[2/3] xl:aspect-[3/4]"
                                        alt="photo gallery image {{ $index + 1 }}" data-index="{{ $index + 1 }}">
                                    <div class="flex flex-row">
                                        <button wire:click="deleteMedia('{{ $media->id }}')"
                                            class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <template x-teleport="body">
                    <div x-show="imageGalleryOpened" x-transition:enter="transition ease-in-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:leave="transition ease-in-in duration-300"
                        x-transition:leave-end="opacity-0" @keydown.window.escape="imageGalleryClose"
                        class="fixed inset-0 mx-auto bg-black bg-opacity-50 z-50 flex items-center justify-center"
                        x-cloak>
                        <div class="relativ bg-white flex justify-center mx-auto p-6">
                            <x-cropper :accepted-file-types="['image/jpeg', 'image/png']" 
                                :can-reorder="false" :state="entangle('image')" :viewport-width="300"
                                :viewport-height="200" :boundary-width="400" :boundary-height="300" :show-zoomer="true"
                                :is-avatar="true" :image-crop-aspect-ratio="16 / 9" :image-preview-height="150" :image-resize-mode="'contain'"
                                :image-resize-target-height="400" :image-resize-target-width="600" :image-format="'jpeg'" :image-quality="0.8"
                                :id="'cropper1'" />

                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>