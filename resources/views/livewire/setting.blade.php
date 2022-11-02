<div>
    <form wire:submit.prevent="update">
        <div class="shadow sm:rounded-md">
            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                <h3 class="text-xl leading-6 font-medium text-gray-900">
                    {{ $form['title'] }}
                </h3>
                <div class="flex">
                    <x-setting.elements
                        :elements="$form['elements']"
                        :settings="$settings"
                        :module="$model"
                    ></x-setting.elements>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <x-button md primary label="{{ __('button.save') }}" type="submit" class="inline-flex"/>
            </div>
        </div>
    </form>
    @if (session('message'))
        <x-notification
            :redirect="true"
            message-to-display="{{ (session('message')) }}"
        />
    @endif
</div>
