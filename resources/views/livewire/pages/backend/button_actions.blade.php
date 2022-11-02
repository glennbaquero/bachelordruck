<div class="flex flex-row-reverse mt-4 gap-2">
    <x-button sm primary label="{{ __('button.save') }}" wire:click="save()"/>
    @if($container->id)
        <x-button sm negative label="{{ __('button.remove') }}" x-data="{}"
                  @click.prevent="$openModal('showModalContainerConfirmation'); $wire.set('containerIdForDeletion', {{ $container->id }}, true)"
        />
    @endif
    <x-button sm warning label="{{ __('button.cancel') }}" wire:click="cancel()"/>
</div>
