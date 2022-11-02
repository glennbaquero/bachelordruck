@props([
'label' => '',
'placeholder' => '',
'name' => '',
'type' => 'text'
])

<div {{ $attributes->class('flex flex-col h-50') }}>
{{--    <label for="{{$attributes->wire('model')->value}}" class="cursor-pointer block text-sm leading-5 font-medium text-gray-700 mb-1">{{$label}} &nbsp;</label>--}}
    <input
        id="{{$attributes->wire('model')->value}}"
        name="{{$attributes->wire('model')->value}}"
        class="min-h-[46px] border border-gray-400 text-xl bg-white sm:leading-5 focus:outline-none focus:shadow-brand focus:ring-brand-primary focus:ring-1 focus:border-brand-primary"
        placeholder="{{$placeholder}}"
        type="{{$type}}"
        {{ $attributes->wire('model') }}
    >
    @error($attributes->wire('model')->value) <small><span class="text-red-500">{{ $message }}</span></small> @enderror
</div>
