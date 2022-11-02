<div
    x-data="{
        color: $wire.entangle('{{ $attributes->get('wire:model.defer') }}'),
        picker: null,
        validate: function () {
            if (this.color.charAt(0) !== '#') {
                this.color = `#${this.color}`
            }
        }
    }"
    x-init="
        picker = new Picker($refs.button);
        picker.onDone = rawColor => {
            color = rawColor.hex.substring(0, rawColor.hex.length - 2);
            $dispatch('input', color)
        }
        picker.setOptions({
            popup: 'left',
            alpha: false
        })
    "
    wire:ignore
>
    <x-input x-model="color" label="{{ $attributes->get('label') }}" class="pl-12" @enter="picker.show()" @blur="validate()">
        <x-slot name="append">
            <div class="absolute inset-y-0 right-0 flex items-center p-0.5">
                <button x-ref="button" class="pr-2"><x-icon name="pencil" class="w-5 h-5" /></button>
            </div>
        </x-slot>
        <x-slot name="prepend">
            <div class="absolute inset-y-0 left-0 flex items-center p-0.5 m-1">
                <div :style="`background: ${color}`" class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-6 sm:w-6 text-white text-xl">
                </div>
            </div>
        </x-slot>
    </x-input>
</div>
