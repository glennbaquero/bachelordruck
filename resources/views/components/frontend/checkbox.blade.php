<div class="flex items-center">
    <div class="flex items-center relative">
        <div class="absolute border border-gray-500 rounded-full w-9 h-9"></div>
        <input
            {{ $attributes->merge(['class' => 'z-10 checkbox ml-1.5 w-6 h-6 focus:ring-0 focus:ring-offset-0']) }}
            type="checkbox"
        />
        <label class="ml-5 mt-1.5 text-normal cursor-pointer {{ $attributes->get('label-class') }}" for="{{ $attributes->get('id') }}">{{ $attributes->get('label') }}</label>
    </div>
</div>

@pushOnce('styles')
<style>
    [type='checkbox'].checkbox {
        transition: background .2s,
        transform .2s;
    }

    [type='checkbox'].checkbox {
        background-color: white;
        border-radius: 50%;
        vertical-align: middle;
        border: none;
        appearance: none;
        -webkit-appearance: none;
        outline: none;
        cursor: pointer;
    }

    [type='checkbox'].checkbox:focus {
        outline: 2px solid black;
    }

    [type='checkbox'].checkbox:checked {
        background-color: var(--color-brand-primary);
        outline: none;
    }

    [type='checkbox'].checkbox:checked:hover {
        background-color: var(--color-brand-primary);
    }

    [type='checkbox'].checkbox:checked:focus {
        background-color: var(--color-brand-primary);
    }

    [type='checkbox'].checkbox:checked + label {
        color: var(--color-brand-primary);
    }
</style>
@endPushOnce
