<x-input
    label="{{ __('page.headline') }}"
    wire:model.defer="container.title"
    wire:key="{{ 'headline'.$loop->index }}"
></x-input>

<x-input.editor
    wire:model.defer="container.content"
    label="{{ __('page.richtext') }}"
    wire:key="{{ 'content'.$container->id}}"
></x-input.editor>

@include('livewire.pages.backend.button_actions')
