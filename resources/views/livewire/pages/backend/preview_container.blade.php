<x-modal.card
    title=""
    max-width="sm:w-9/12"
    wire:model.defer="showPreviewContainerModal"
>
    @if ($previewContainer)
        <x-dynamic-component component="{{  $previewContainer->type->getFrontendComponent() }}" :container="$previewContainer"/>

        <x-slot name="footer">
            <div class="flex flex-row-reverse">
                @if (in_array($previewContainer->id, $selectedContainerIds))
                    <x-button warning label="{{ __('button.unselect') }}"
                              wire:click="unselectContainer({{ $previewContainer->id }}) spinner"/>
                @else (in_array($previewContainer->id, $selectedContainerIds))
                    <x-button positive label="{{ __('button.select') }}"
                              wire:click="selectContainer({{ $previewContainer->id }})" spinner/>
                @endif

                {{--                    <x-button flat label="{{ __('button.close') }}" x-on:click.preventDefault="close" class="mr-2"/>--}}
            </div>
        </x-slot>
    @endif
</x-modal.card>
