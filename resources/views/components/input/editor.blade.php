<div>
    <label class="block text-sm font-medium
        @if ($errors->has($attributes->wire('model')->value()))
            text-red-600
        @else
            dark:text-gray-400 text-secondary-700
        @endif"
        for="{{$attributes->get('label')}}}"
    >
        {{$attributes->get('label')}}
    </label>
    <div class="editor"
        x-data="setupEditor($wire.entangle('{{ $attributes->wire('model')->value() }}').defer)"
        x-init="() => init($refs.element)"
        wire:ignore
        {{ $attributes->whereDoesntStartWith('wire:model') }}>


        <template x-if="editor">
            <div class="flex flex-col">
                <div>
                    @foreach($basicMenus as $menu)
                        <x-menu.item
                            @click.prevent.stop="{{ $menu->action }}"
                            active="{!! $menu->active !!}"
                            svg="{{ $menu->svg->render()->with($menu->svg->data()) }}"
                        >
                        </x-menu.item>
                    @endforeach
                </div>
                @if (! $basic)
                    <div>
                        @foreach($advanceMenus as $menu)
                            <x-menu.item
                                @click.prevent.stop="{{ $menu->action }}"
                                svg="{{ $menu->svg->render()->with($menu->svg->data()) }}"
                            >
                            </x-menu.item>
                        @endforeach
                    </div>
                @endif
            </div>
        </template>
        <div x-ref="element" class="overflow-y-auto"></div>
    </div>

    @error($attributes->wire('model')->value())
    <p class="mx-0 mt-2 mb-0 text-sm leading-5 text-red-600">
        {{ $message }}
    </p>
    @enderror
</div>
