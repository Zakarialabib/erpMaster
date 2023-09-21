<div x-data="{
    editPrice: false,
    selectedRowId: null,
    buttonHidden: false,
}">

    <button type="button" @click="editPrice = !editPrice; selectedRowId = '{{ $cart_item->rowId }}'; buttonHidden = true"
        x-show="!buttonHidden">
        <i class="fa fa-pen text-red-500"></i>
    </button>

    <form wire:change="updatePrice('{{ $cart_item->rowId }}', '{{ $cart_item->id }}')" class="flex  justify-center">
        <x-input type="text" wire:model.live="price.{{ $cart_item->id }}" value="{{ $cart_item->qty }}"
            name="price{{ $cart_item->id }}" />
    </form>
</div>
