<button
    @click.prevent.stop="{!!  $attributes->get('@click.prevent.stop') !!}"
    :class="{ 'bg-gray-200': {{ $attributes->has('active') ? $attributes->get('active') : 'false' }} }"
    @if ($attributes->has('disabled'))
        :disabled="{{ $attributes->get('disabled') }}"
    @endif
    class="py-1 px-2 m-0 text-sm leading-5 text-center text-gray-600 normal-case bg-transparent bg-none rounded-md transition-all duration-75 ease-in cursor-pointer box-border hover:bg-gray-200 focus:shadow-xs"
>
    @if($attributes->has('svg'))
        {!! $attributes->get('svg') !!}
    @endif
</button>
