<x-modal.card
    title="{{ __('notification.delete_title') }}"
    max-width="sm"
    wire:model.defer="showModalConfirmation">
    <p> {{ __('notification.delete_content') }}</p>
    <x-slot name="footer">
        <div class="flex flex-row-reverse">
            <x-button negative label="{{ __('button.delete') }}" wire:click="delete" spinner  />
            <x-button flat label="{{ __('button.close') }}" x-on:click="close" class="mr-2" />
        </div>
    </x-slot>
</x-modal.card>
