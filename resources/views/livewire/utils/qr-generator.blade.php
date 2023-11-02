<div>
    <div class="flex justify-center" x-data="{ activeTab: 'url' }">
        <div class="w-35 bg-gray-200">
            <ul class="py-4">
                <li @click="activeTab = 'url'" :class="{ 'bg-blue-500 text-white': activeTab === 'url' }"
                    class="cursor-pointer px-4 py-2 mb-2">Website URL</li>
                <li @click="activeTab = 'emailAdress'" :class="{ 'bg-blue-500 text-white': activeTab === 'emailAdress' }"
                    class="cursor-pointer px-4 py-2 mb-2">E-mail Address</li>
                <li @click="activeTab = 'phoneNumber'" :class="{ 'bg-blue-500 text-white': activeTab === 'phoneNumber' }"
                    class="cursor-pointer px-4 py-2 mb-2">Phone Number</li>
                {{-- <li @click="activeTab = 'geoAddress'" :class="{ 'bg-blue-500 text-white': activeTab === 'geoAddress' }"
                    class="cursor-pointer px-4 py-2 mb-2">Geo Address</li> --}}
                <li @click="activeTab = 'VCard'" :class="{ 'bg-blue-500 text-white': activeTab === 'VCard' }"
                    class="cursor-pointer px-4 py-2 mb-2">VCard</li>
            </ul>
        </div>
        <div class="w-1/2 px-4 bg-gray-100 ">
            <div x-show="activeTab === 'url'" x-data="{ utmBuilder : false }">
                <label for="websiteUrl">Website URL</label>
                <input type="text" id="websiteUrl" wire:model.lazy="websiteUrl"
                    class="w-full border border-gray-300 px-2 py-1">
                <label for="">
                    enable url tracking with Utm Builder
                    <input type="checkbox" name="" id="" @click="utmBuilder = !utmBuilder">
                </label>
                <div x-show="utmBuilder">
                    <label for="utmSource">UTM Source</label>
                    <input type="text" id="utmSource" wire:model.defer="utmSource" required
                        class="w-full border border-gray-300 px-2 py-1">
                        <small>e.g. newsletter, twitter, google, etc.</small>

                    <label for="utmMedium">UTM Medium</label>
                    <input type="text" id="utmMedium" wire:model.defer="utmMedium" required
                        class="w-full border border-gray-300 px-2 py-1">
                        <small>e.g. email, social, cpc, etc.</small>

                    <label for="utmCampaign">UTM Campaign</label>
                    <input type="text" id="utmCampaign" wire:model.defer="utmCampaign" required
                        class="w-full border border-gray-300 px-2 py-1">
                        <small>e.g. promotion, sale, etc.</small>

                    <label for="utmTerm">UTM Term</label>
                    <input type="text" id="utmTerm" wire:model.defer="utmTerm" required
                        class="w-full border border-gray-300 px-2 py-1">
                        <small>Keywords for your paid search campaigns</small>
                    
                    <button type="button" wire:click="generateWebsiteUrl"
                        class="mt-4 px-2 py-1 bg-gray-500 text-white rounded-md">
                        Generate
                    </button>
                </div>
                @if ($websiteUrl !== null)
                {{$this->websiteUrl}}
                    <div class="my-4 flex justify-center">
                        {!! SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->style('square')->size(400)->eye('circle')->generate(Request::url($websiteUrl)) !!}
                    </div>
                    <div class="my-4 text-center">
                        <x-button danger type="button" wire:click="refresh">
                            reset
                        </x-button>
                    </div>
                @endif
            </div>
            <div x-show="activeTab === 'emailAdress'">
                <label for="email">Email</label>
                <input type="email" id="email" wire:model.lazy="email"
                    class="w-full border border-gray-300 px-2 py-1">
                @if ($email !== null)
                    <div class="my-4 flex justify-center">
                        {!! SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->style('square')->size(400)->eye('circle')->email($email) !!}
                    </div>
                    <div class="my-4 text-center">
                        <x-button danger type="button" wire:click="refresh">
                            reset
                        </x-button>
                    </div>
                @endif
            </div>
            <div x-show="activeTab === 'phoneNumber'">
                <label for="phone">Phone</label>
                <input type="number" id="phone" wire:model.lazy="phone"
                    class="w-full border border-gray-300 px-2 py-1">
                @if ($phone !== null)
                    <div class="my-4 flex justify-center">
                        {!! SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->style('square')->size(400)->eye('circle')->phoneNumber($phone) !!}
                    </div>
                    <div class="my-4 text-center">
                        <x-button danger type="button" wire:click="refresh">
                            reset
                        </x-button>
                    </div>
                @endif
            </div>
            {{-- <div x-show="activeTab === 'geoAddress'">
                <label for="address">Address</label>
                <input type="text" id="lat" class="w-full border border-gray-300 px-2 py-1">
                <input type="text" id="lon" class="w-full border border-gray-300 px-2 py-1">
            </div> --}}
            <div x-show="activeTab === 'VCard'">
                <label for="name">Name</label>
                <x-input type="text" id="name" class="w-full border border-gray-300 px-2 py-1"
                    wire:model.defer="name" :value="old('name')" />

                <label for="company_name">Company Name</label>
                <x-input type="text" id="company_name" class="w-full border border-gray-300 px-2 py-1"
                    wire:model.defer="company_name" :value="old('company_name')" />

                <label for="phone">Phone</label>
                <x-input type="text" id="phone" class="w-full border border-gray-300 px-2 py-1"
                    wire:model.defer="phone" :value="old('phone')" />

                <label for="email">Email</label>
                <x-input type="text" id="email" class="w-full border border-gray-300 px-2 py-1"
                    wire:model.defer="email" :value="old('email')" />

                <label for="address">Address</label>
                <x-input type="text" id="address" class="w-full border border-gray-300 px-2 py-1"
                    wire:model.defer="address" :value="old('address')" />

                <label for="website">Website</label>
                <x-input type="text" id="websiteUrl" class="w-full border border-gray-300 px-2 py-1"
                    wire:model.defer="websiteUrl" :value="old('websiteUrl')" />

                <label for="instagram">Instagram</label>
                <x-input type="text" id="instagram" class="w-full border border-gray-300 px-2 py-1"
                    wire:model.defer="instagramLink" :value="old('instagramLink')" />

                <label for="facebook">Facebook</label>
                <x-input type="text" id="facebook" class="w-full border border-gray-300 px-2 py-1"
                    wire:model.defer="facebookLink" :value="old('facebookLink')" />

                <label for="tiktok">TikTok</label>
                <x-input type="text" id="tiktok" class="w-full border border-gray-300 px-2 py-1"
                    wire:model.defer="tiktokLink" :value="old('tiktokLink')" />

                <label for="whatsapp">WhatsApp</label>
                <x-input type="text" id="whatsapp" class="w-full border border-gray-300 px-2 py-1"
                    wire:model.defer="whatsappLink" :value="old('whatsappLink')" />
                <div class="my-4 text-center">
                    <x-button danger type="button" wire:click="generateQrCode(false)">
                        generate
                    </x-button>

                    <x-button danger type="button" wire:click="data">
                        fill with data
                    </x-button>
                </div>
                @if ($qrCodeData !== null)
                    <div class="my-4 flex justify-center">
                        {!! SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->style('square')->size(400)->eye('circle')->generate($qrCodeData) !!}
                    </div>
                    <div class="my-4 space-y-4 text-center">
                        <x-button danger type="button" wire:click="downloadQrCode">
                            download
                        </x-button>
                        <x-button danger type="button" wire:click="refresh">
                            reset
                        </x-button>
                    </div>
                @endif
                {{-- QrCode::format('svg')->size(200)->generate( --}}
            </div>
        </div>
    </div>
</div>
