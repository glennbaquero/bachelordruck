<x-input
    label="{{ __('page.url') }}"
    wire:model.defer="container.url"
    wire:key="{{ 'url'.$loop->index }}"
></x-input>

@include('livewire.pages.backend.button_actions')
