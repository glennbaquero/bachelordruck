@props([
    'elements' => [],
    'settings' => [],
    'module' => '',
    'fieldMap' => [
        'checkbox' => 'checkbox',
        'select' => 'select',
        'text' => 'input',
        'number' => 'input'
    ]
])


<div class="flex flex-auto flex-col">
    @foreach ($elements as $element)
        @if (isset($element['title']) && !$element['depends'])
            <div class="sm:rounded-lg mb-4">
                <div class="px-4 py-2 sm:px-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        {{ $element['title'] }}
                    </h3>
                </div>
                <div class="px-4 py-2">
                    @include('includes.settings.container')
                </div>
            </div>
        @else
            @include('includes.settings.container')
        @endif
    @endforeach
</div>
