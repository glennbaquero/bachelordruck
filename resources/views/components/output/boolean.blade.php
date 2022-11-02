@props([
'label' => '',
'value' => ''
])
<dl>
    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500 sm:flex sm:items-center">
            {{ $label }}
        </dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">



            <div class="flex items-center">
                <div class="relative flex items-center select-none">
                    <input name="model" id="md" class="absolute mx-0.5 my-auto inset-y-0 checked:translate-x-3.5 left-0.5 w-3.5 h-3.5 rounded-full border-0 appearance-none
            translate-x-0 transform transition ease-in-out duration-200 cursor-pointer shadow
            checked:bg-none peer focus:ring-0 focus:ring-offset-0 focus:outline-none bg-white
            checked:text-white dark:bg-secondary-200" type="checkbox" disabled {{ $value? 'checked' : '' }}>
                    <label for="md" class="
            block rounded-full cursor-pointer transition ease-in-out duration-100
            peer-focus:ring-2 peer-focus:ring-offset-2 h-5 w-9

                    bg-secondary-200 peer-checked:bg-primary-600 peer-focus:ring-primary-600
                    dark:peer-focus:ring-secondary-600 dark:peer-focus:ring-offset-secondary-800
                    dark:bg-secondary-600 dark:peer-checked:bg-secondary-700
                "></label>
                </div>
            </div>
        </dd>
    </div>
</dl>
