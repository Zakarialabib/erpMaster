<div>
    @section('title', __('My account'))

    <section class="py-24 px-4 bg-gray-100 h-auto my-auto flex items-center">
        <div class="w-full py-10 mx-4 mt-12 flex bg-white" x-data="{ activeTab: 'account' }">
            <div class="w-1/4">
                <ul class="flex flex-col space-y-2 bg-white py-4">
                    <li @click="activeTab = 'account'" :class="{ 'bg-green-500 text-white': activeTab === 'account' }"
                        class="px-4 py-2 w-full text-left text-green-800 hover:bg-green-500 hover:text-white transition-colors cursor-pointer">
                        {{ __('Account Info') }}
                    </li>
                  
                    <li @click="activeTab = 'orders'" :class="{ 'bg-green-500 text-white': activeTab === 'orders' }"
                        class="px-4 py-2 w-full text-left text-green-800 hover:bg-green-500 hover:text-white transition-colors cursor-pointer">
                        {{ __('Orders') }}
                    </li>
                
                    
                </ul>
            </div>
            <div class="w-3/4 px-6 pb-6">

                <div x-show="activeTab === 'account'" class="w-full">
                    @livewire('account.user-infos', ['user' => $user])
                </div>

                <div x-show="activeTab === 'orders'" class="w-full">
                    @livewire('account.orders')
                </div>
               
            </div>
        </div>
    </section>
</div>
