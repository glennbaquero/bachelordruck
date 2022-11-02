@props([
'root' => [],
'level' => 1,
'index' => 0
])

@if ($index == 0)
<ul
    wire:sortable="update"
    index="{{ (int) $index }}"
>
@endif
    <x-tree.item id="{{ $root['id'] }}" name="{{ $root['name'] }}" level="{{ $level }}"></x-tree.item>
    @foreach ($root['children'] as $index => $children)
        @if (count($children['children']) > 0)
            <x-tree.root :root="$children" :level="$level+1" index="{{ (int) $index }}"></x-tree.root>
        @else
            @if ($index === 0)
                <ul wire:sortable="update" index="{{ (int) $index }}">
            @endif
            <x-tree.item id="{{ $children['id'] }}" name="{{ $children['name'] }}" level="{{ $level + 1 }}"></x-tree.item>
            @if ($index === count($children['children']) - 1)
                </ul>
            @endif
        @endif
    @endforeach
@if ($index === count($root['children']) - 1)
</ul>
@endif
