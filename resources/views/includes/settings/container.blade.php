@if (!$element['depends'])
    @if (isset($element['elements']))
        <x-setting.elements
            :elements="$element['elements']"
            :settings="$settings"
            :module="$module"
        ></x-setting.elements>
    @endif
    @if (isset($element['payload']))
        @if (isset($module) && isset($element['key']))
            <x-dynamic-component
                :component="$fieldMap[$element['cast']]"
                wire:model.lazy="settings.{{$module}}.{{$element['key']}}"
                :label="$element['label']"
            >
                @foreach($element['payload']['options'] as $option)
                    <x-select.option label="{{ $option['label'] }}" :value="$option['id']"/>
                @endforeach
            </x-dynamic-component>
        @endif
    @else
        @if (isset($module) && isset($element['key']) && isset($settings[$module][$element['key']]))
            <x-dynamic-component
                :component="$fieldMap[$element['cast']]"
                wire:model.lazy="settings.{{$module}}.{{$element['key']}}"
                :label="$element['label']"
                :checked="$settings[$module][$element['key']]"
            ></x-dynamic-component>
        @else
            @if(isset($element['cast']))
                <x-dynamic-component
                    :component="$fieldMap[$element['cast']]"
                    :label="$element['label']"
                ></x-dynamic-component>
            @endif
        @endif
    @endif
@else
    @if (!$element['depends']['values'])
        @if (isset($element['elements']))
            <x-setting.elements
                :elements="$element['elements']"
                :settings="$settings"
                :module="$module"
            ></x-setting.elements>
        @endif
    @else
        @foreach($element['depends']['values'] as $value)
            @if(isset($module))
                @if($value === $settings[$module][$element['depends']['key']])
                    <div class="sm:rounded-lg mb-4">
                        <div class="px-4 py-2 sm:px-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ $element['title'] }}
                            </h3>
                        </div>
                        <div class="px-4 py-2">
                            <x-setting.elements
                                :elements="$element['elements']"
                                :settings="$settings"
                                :module="$module"
                            ></x-setting.elements>
                        </div>
                    </div>

                @endif
            @endif
        @endforeach
    @endif
@endif
