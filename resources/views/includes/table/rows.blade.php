<?php /** @var App\Livewire\View\Column $column*/ ?>

@foreach($rows as $row)
    <tr wire:key="{{$row->id}}">
        @foreach($columns as $column)
            @if ($column->isTypeColumnAction())
                @if ($column->field === 'show')
                    <td class="px-6 py-4 w-8 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                        <a href="#" class="text-indigo-600 hover:text-indigo-900"
                           wire:click.prevent="showAction({{$row->id}})">
                            <x-icon name="document" class="w-5 h-5" title="{{ $column->label }}"/>
                        </a>
                    </td>
                @elseif($column->field === 'edit')
                    <td class="px-6 py-4 w-8 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                        <a href="#" class="text-indigo-600 hover:text-indigo-900"
                           wire:click.prevent="editAction({{$row->id}})">
                            <x-icon name="pencil-alt" class="w-5 h-5" title="{{ $column->label }}"/>
                        </a>
                    </td>
                @elseif($column->field === 'delete')
                    @if ($enableDeleteConfirmation)
                        <td class="px-6 py-4 w-8 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900"
                               wire:click.prevent="deleteAction({{$row->id}})">
                                <x-icon name="trash" class="w-5 h-5" title="{{ $column->label }}"/>
                            </a>
                        </td>
                    @else
                        <td class="px-6 py-4 w-8 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900"
                               wire:click.prevent="delete({{$row->id}})">
                                <x-icon name="trash" class="w-5 h-5" title="{{ $column->label }}"/>
                            </a>
                        </td>
                    @endif
                @elseif($column->field === 'custom')
                    <td class="px-6 py-4 w-8 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                        <div x-data="{ showDropdown: false}" class="z-10">
                            <div class="flex items-center">
                                <div class="inline-block text-left">
                                    <div>
                                        <button class="text-indigo-600 hover:text-indigo-900" @click="showDropdown = true">
                                            <x-icon name="menu" class="w-5 h-5" title="{{ $column->label }}"/>
                                        </button>
                                    </div>
                                    <div
                                        @click.outside="showDropdown = false"
                                        x-cloak
                                        x-show="showDropdown"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="opacity-0 transform scale-95"
                                        x-transition:enter-end="opacity-100 transform scale-100"
                                        x-transition:leave="transition ease-in duration-70"
                                        x-transition:leave-start="opacity-100 transform scale-100"
                                        x-transition:leave-end="opacity-0 transform scale-95"
                                        class="origin-top-right absolute right-6 md:right-14 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-20 overflow-y-visible"
                                        role="menu" aria-orientation="vertical" aria-labelledby="menu-button"
                                        tabindex="-1">
                                        @foreach($column->getCustomActions() as $action)
                                            <div class="py-1" role="none">
                                                <button class="block px-4 py-2 text-sm text-gray-700"
                                                   wire:click.prevent="customAction({{$row->id}}, '{{$action['label']}}')">
                                                    {{$action['label']}}
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                @endif
            @else
                <x-table.column
                    :column="$column"
                    :item="$row"
                ></x-table.column>
            @endif
        @endforeach
    </tr>
@endforeach
