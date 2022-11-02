<x-modal.card
    title="{{ $modalTitle }}"
    blur
    max-width="{{ $modalWidth }}"
    wire:model.defer="showModal"
    x-on:close="$wire.close">
    @if ($showModal)
        <livewire:is
            :component="$componentName"
            :model="$currentId"
            key="{{ $componentName  }}"
        ></livewire:is>
    @endif
    @if ($showFooter)
        <x-slot name="footer">
            <div class="flex flex-row-reverse">
                <x-button md primary label="{{ __('button.edit') }}" wire:click="edit" class="inline-flex ml-2"/>
                @if ($enableDeleteConfirmation)
                    <x-button md negative label="{{ __('button.delete') }}" wire:click="deleteAction" class="inline-flex ml-2"/>
                @else
                    <x-button md negative label="{{ __('button.delete') }}" wire:click="delete" class="inline-flex ml-2"/>
                @endif
                <x-button md label="{{ __('button.close') }}" x-on:click="close" class="inline-flex ml-2"/>
            </div>
        </x-slot>
    @endif
</x-modal.card>
