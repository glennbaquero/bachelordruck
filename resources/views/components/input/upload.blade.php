<div {{ $attributes->whereStartsWith('wire:key') }}>
    <label
        class="block text-sm font-medium leading-5 text-gray-800 cursor-default"
    >
        {{ $label }}
    </label>
    <div class="flex items-center p-2 rounded-md border border-solid border-gray-400 box-border">
        @if ($model->id && !$editing)
            <div class="mr-2" x-data="{ showTrash: false }" @mouseover="showTrash = true" @mouseleave="showTrash = false">
                @if ($model->getFirstMediaUrl($name) !== '')
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
                    :url="$model->getFirstMediaUrl($name)"
                >
                </x-value.image>
            </div>
        @endif
        @if ($editing)
            <div class="w-full">
                @if($customProperty)
                    <x-media-library-collection
                        :name="$name"
                        :model="$model"
                        :collection="$name"
                        fields-view="components.input.partials.custom-properties"
                    />
                @else
                    <x-media-library-collection
                        :name="$name"
                        :model="$model"
                        :collection="$name"
                    />
                @endif
            </div>
        @else
            @if (isset($index))
                @if ($multiple)
                    <div class="w-full">
                        <x-media-library-attachment
                            multiple name="{{ $name.$index }}"
                            :rules="$rules"
                        />
                    </div>
                @else
                    <div class="w-full">
                        <x-media-library-attachment
                            name="{{ $name.$index }}"
                            :rules="$rules"
                        />
                    </div>
                @endif
            @else
                @if ($multiple)
                    <div class="w-full">
                        <x-media-library-attachment
                            multiple name="{{ $name }}"
                            :rules="$rules"
                        />
                    </div>
                @else
                    <div class="w-full">
                        <x-media-library-attachment
                            name="{{ $name }}"
                            :rules="$rules"
                        />
                    </div>
                @endif
            @endif
        @endif
    </div>
</div>
