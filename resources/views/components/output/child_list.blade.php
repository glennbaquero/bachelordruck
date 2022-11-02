@props([
'componentClass',
'parentModelId',
'title' => '',
])
<div class="m-2">
    <x-card title="{{ $title }}">
        <livewire:is
            component="{{ $componentClass::getName() }}"
            key="{{ $componentClass::getName() }}"
            parent-model-id="{{ $parentModelId }}"
        ></livewire:is>
    </x-card>
</div>
