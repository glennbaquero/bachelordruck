<div>
    <x-input
        type="password"
        label="{{ $attributes->get('label') }}"
        wire:model.defer="{{ $attributes->get('wire:model.defer') }}"
        :autofocus="$attributes->get('autofocus')"
    />
</div>
