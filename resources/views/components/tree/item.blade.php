@props([
'id' => '',
'name' => '',
'level' => ''
])
<li
    wire:sortable.item="{{ $id }}"
    wire:key="list-{{ $id }}"
    class="flex items-center p-0.5 m-1 list-none text-left text-black rounded border border-gray-300 border-solid"
    style="list-style: outside none none; margin-left: {{ $level }}em"
>
    <a
        wire:sortable.handle
        class="mx-2.5 text-sm text-red-400 no-underline cursor-pointer"
    >
        <x-icon name="arrows-expand" class="w-5 h-5" />
    </a>
    <a class="flex mx-2.5 text-sm text-black no-underline cursor-pointer">
        <x-icon name="chevron-right" class="w-5 h-5" />
        &nbsp{{ $name }}
    </a>
    <x-icon name="minus-sm" class="w-5 h-5 cursor-pointer" wire:click="remove({{ $id }})"/>
</li>

