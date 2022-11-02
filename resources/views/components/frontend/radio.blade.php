<div class="flex items-center">
    <input
        {{ $attributes->merge(['class' => 'radio hidden']) }}
        type="radio"
    />
    <label for="{{ $attributes->get('id') }}" class="flex items-center cursor-pointer text-normal">
        <span class="self-start circle w-9 h-9 inline-block mr-2 rounded-full border border-gray-500 flex-no-shrink bg-white"></span>
        <span class="ml-1.5 mt-1.5">{{ $attributes->get('label') }}</span>
    </label>

    {{ $slot }}
</div>

@pushOnce('styles')
<style>
    .radio + label span.circle {
        transition: background .2s,
        transform .2s;
    }

    .radio:checked + label span.circle {
        background-color: var(--color-brand-primary);
        box-shadow: 0px 0px 0px 6px var(--color-brand) inset;
    }

    .radio:checked + label {
        color: var(--color-brand-primary);
    }
</style>
@endPushOnce
