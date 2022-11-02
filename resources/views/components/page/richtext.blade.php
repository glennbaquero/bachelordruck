@props([
'model' => ''
'placeholder' => ''
'basic' => 'true'
])

<div {{ $attributes }}>
    <x-input.editor
        wire:model.lazy="$model"
        label="{{ __('page.richtext') }}"
        placeholder="{{ $placeholder }}"
        :basic="$basic">
    </x-input.editor>
</div>
