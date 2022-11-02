@props([
'value' => '',
'label' => '',
'force' => false,
'options' => []
])
@if ($value !== "")
    @if ($force) {{ $label }} : @endif
    <span class="text-sm leading-5 font-medium truncate">
        @if(is_array($value))
            <div>
            @foreach (collect($options)->whereIn('id', $value)->pluck('label') as $label)
                <p> &bull; {{$label}}</p>
            @endforeach
            </div>
        @else
            {{ collect($options)->where('id',$value)->pluck('label')->first() }}
        @endif
    </span>
    @if ($force) <br/> @endif
@endif

