<div
    x-data="{
        color: $wire.entangle('{{ $attributes->get('wire:model.defer') }}'),
        randomColor: function() {
            this.color = '#'+Math.floor(Math.random()*16777215).toString(16)
        }
    }"
    x-init="
        $watch('color', value => {
            if (value.length > 0 && value.charAt(0) !== '#') {
                value = ('#'+value)
            }
            color = value.toLowerCase().replace(/[^0-9a-f#]+/g,'').substr(0,7)
            $refs.picker.value = color + ('f'.repeat(7-color.length))
        })
    "
>
    <x-input
        wire:model="{{ $attributes->get('wire:model.defer') }}"
        label="{{ $attributes->get('label') }}" class="pl-12"
    >
        <x-slot name="prepend">
            <div class="absolute inset-y-0 left-0 flex items-center p-0.5 m-1">
                <x-input type="color" style="width: 2rem" @input="color = $event.target.value" x-ref="picker"/>
            </div>
        </x-slot>
        <x-slot name="append">
            <div class="absolute inset-y-0 right-0 flex items-center p-0.5">
                <button x-ref="button" class="pr-2" @click.prevent="randomColor()">
                    <x-icon name="refresh" class="w-5 h-5"/>
                </button>
            </div>
        </x-slot>
    </x-input>
</div>
