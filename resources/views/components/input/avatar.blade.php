<div>
    <label
        class="block text-sm font-medium leading-5 text-gray-800 cursor-default"
    >
        Avatar
    </label>
    <div class="flex items-center p-2 rounded-md border border-solid border-gray-400 box-border">
        @if ($value->id)
            <div class="mr-2" x-data="{ showTrash: false }" @mouseover="showTrash = true" @mouseleave="showTrash = false">
                @if ($value->getFirstMediaUrl('avatars') !== '')
                    <a href="#" x-show="showTrash" wire:click.prevent="clearAvatar" class="mt-2 relative">
                        <x-icon name="trash" class="w-7 h-7 text-red-600 absolute mt-2 ml-2"/>
                    </a>
                @endif
                <x-value.avatar
                    :url="$value->getFirstMediaUrl('avatars')"
                    :color="$value->color"
                    value="{{$value->initials ?? Support\Helpers\NameHelpers::getInitials($value->name)}}">
                </x-value.avatar>
            </div>
        @endif
        <div class="w-full"><x-media-library-attachment name="avatar" rules="mimes:jpeg,jpg,png|max:16384"/></div>
    </div>

</div>
