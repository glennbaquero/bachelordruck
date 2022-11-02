@props([
    'bg' => 'blue-500',
    'color' => 'white',
])

<div {{ $attributes->merge(['class' => "bg-$bg rounded-md py-2 px-4 text-sm text-$color"]) }}>
   {{ $slot }}
</div>
