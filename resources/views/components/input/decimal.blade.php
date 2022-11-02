<div>
    <x-input
        type="number"
        label="{{ $attributes->get('label') }}"
        wire:model.defer="{{ $attributes->get('wire:model.defer') }}"
        step="0.01"
    />
</div>
