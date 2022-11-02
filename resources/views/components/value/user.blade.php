@if($user)
    <div {{ $attributes->whereDoesntStartWith(['options', 'option'])->class([
        'py-2 px-3 focus:outline-none transition-colors ease-in-out duration-50 relative group',
        'text-secondary-600 dark:text-secondary-400',
        'cursor-pointer focus:bg-primary-100 focus:text-primary-800 hover:text-white' => !($readonly || $disabled),
        'dark:focus:bg-secondary-700' => !($readonly || $disabled),
        'opacity-60 cursor-not-allowed' => $disabled
    ])->merge([
        'data-label' => $user->name,
        'data-value' => $user->id,
    ]) }}
         @unless($readonly || $disabled)
         tabindex="0"
         x-on:click="select('{{ $user->id }}')"
         x-on:keydown.enter="select('{{ $user->id }}')"
         @endunless
         :class="{
        'font-semibold': isSelected('{{ $user->id }}'),
        @if (!($readonly || $disabled))
             'hover:bg-negative-500 dark:hover:text-secondary-100': isSelected('{{ $user->id }}'),
            'hover:bg-primary-500 dark:hover:bg-secondary-700': !isSelected('{{ $user->id }}'),
        @endif
             }"
    >
        <x-element.avatar
            :img-url="$imgUrl"
            :name="$user->name"
            :color="$user->color"
            :abbrev="$initials"
            :short="$short"
        >
        </x-element.avatar>
    </div>
@endif
