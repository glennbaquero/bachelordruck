@props([
'value' => '',
'label' => '',
'force' => false,
])

@if ($value !== "")
    <span class="text-sm leading-5 font-medium">

        <div class="flex items-center">
<label class="block text-sm font-medium text-secondary-700 dark:text-gray-400 mr-2" for="left-label">
@if ($force) {{ $label }} @endif
</label>
<div class="relative flex items-center select-none">
<input name="model" id="left-label" wire:key="{{ rand() }}" class="absolute mx-0.5 my-auto inset-y-0 checked:translate-x-3 w-3 h-3 rounded-full border-0 appearance-none
            translate-x-0 transform transition ease-in-out duration-200 cursor-pointer shadow
            checked:bg-none peer focus:ring-0 focus:ring-offset-0 focus:outline-none bg-white
            checked:text-white dark:bg-secondary-200" type="checkbox" disabled {{ $value? 'checked' : '' }}>
<label for="left-label" class="
            block rounded-full cursor-pointer transition ease-in-out duration-100
            peer-focus:ring-2 peer-focus:ring-offset-2 h-4 w-7

                    bg-secondary-200 peer-checked:bg-primary-600 peer-focus:ring-primary-600
                    dark:peer-focus:ring-secondary-600 dark:peer-focus:ring-offset-secondary-800
                    dark:bg-secondary-600 dark:peer-checked:bg-secondary-700
                "></label>
</div>
</div>


    </span>
@endif

