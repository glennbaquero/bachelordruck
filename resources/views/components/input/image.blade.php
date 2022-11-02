<div {{ $attributes->whereStartsWith('wire:key') }}>
    <label
        class="block text-sm font-medium leading-5 text-gray-800 cursor-default"
    >
        {{ __('page.image') }}
    </label>
    <div class="flex items-center p-2 rounded-md border border-solid border-gray-400 box-border">
        @if ($value->id)
            <div class="mr-2" x-data="{ showTrash: false }" @mouseover="showTrash = true" @mouseleave="showTrash = false">
                @if ($value->getFirstMediaUrl('images') !== '')
                    @if (isset($index))
                        <a href="#" x-show="showTrash" wire:click.prevent="clearAvatar( {{ $index }})" class="mt-2 relative">
                            <x-icon name="trash" class="w-7 h-7 text-red-600 absolute mt-2 ml-2"/>
                        </a>
                    @else
                        <a href="#" x-show="showTrash" wire:click.prevent="clearAvatar('')" class="mt-2 relative">
                            <x-icon name="trash" class="w-7 h-7 text-red-600 absolute mt-2 ml-2"/>
                        </a>
                    @endif
                @endif
                <x-value.image
                    :url="$value->getFirstMediaUrl('images')"
                >
                </x-value.image>
            </div>
        @endif
        @if (isset($index))
            <div class="w-full"><x-media-library-attachment name="{{ 'images'.$index }}" rules="mimes:jpeg,jpg,png|max:65536"/></div>
        @else
                <div class="w-full"><x-media-library-attachment name="{{ 'images' }}" rules="mimes:jpeg,jpg,png|max:65536"/></div>
        @endif
    </div>

</div>
