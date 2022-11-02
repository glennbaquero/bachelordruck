@props([
'label' => '',
'value' => '',
'options' => [],
])
<dl>
    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500 sm:flex sm:items-center">
            {{ $label }}
        </dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            <div class="sm:flex sm:items-center">
                @if(is_array($value))
                    <div>
                        @foreach (collect($options)->whereIn('id', $value)->pluck('label') as $label)
                            <p>{{$label}}</p>
                        @endforeach
                    </div>
                @else
                    {{ collect($options)->where('id',$value)->pluck('label')->first() }}
                @endif
            </div>
        </dd>
    </div>
</dl>
