<?php
/** @var Domain\Containers\Models\Container $container */
?>

<div>
    <div class="mb-2">
        <x-backend.button
            color="green"
            icon="view-list"
            sm
            positive
            label="{{ __('Containers List') }}"
            href="{{ route('page.containers', [$currentPageLanguage]) }}"
        />
    </div>

    <div class="flex flex-col sm:flex-row flex-col-reverse px-2 gap-2 sm:px-0">
        {{-- Source Containers --}}
        <div class="w-full sm:w-1/2">
            <x-card>
                <x-slot:header>
                    <div class="px-4 py-1 flex justify-between items-center border-b dark:border-0 ">
                        <h3 class="text-md text-secondary-700 dark:text-secondary-400 whitespace-normal font-semibold uppercase">{{ __('Source Containers') }}</h3>
                    </div>
                    </x-slot>
                    <div>
                        <x-select
                            label="{{__('Page Languages')}}"
                            placeholder="{{__('Select page languages')}}"
                            :options="$pageLanguages"
                            option-label="name"
                            option-value="id"
                            multiselect
                            wire:model.lazy="selectedPageLanguages"
                        />
                    </div>

                    <div>
                        @forelse($sourcePageLanguages as $pageLanguage)
                            <div class="my-4">
                                <x-card title="{{ $pageLanguage->name  }}" class="text-blue">
                                    <x-slot:header>
                                        <div
                                            class="px-4 py-1 flex justify-between items-center border-b dark:border-0 ">
                                            <h3 class="text-md text-secondary-700 dark:text-secondary-400 whitespace-normal">{{ $pageLanguage->name }}</h3>
                                        </div>
                                        </x-slot>

                                        @foreach($pageLanguage->containers as $container)
                                            <div class="flex py-1.5 items-center space-x-1">
                                                <div class="flex flex-col">
                                                    <div class="flex items-center space-x-2">
                                                        <x-checkbox
                                                            lg
                                                            id="selectedContainer{{$container->id}}"
                                                            wire:key="selectedContainer{{$container->id}}"
                                                            wire:model.defer="selectedContainerIds"
                                                            value="{{ $container->id }}"
                                                            class="text-2xl font-bold cursor-pointer"
                                                            :label="$container->type->label()"/>

                                                        <x-button.circle xs positive icon="eye"
                                                                         wire:click="previewContainer({{ $container->id }})"
                                                                         spinner="previewContainer({{ $container->id }})"/>
                                                    </div>

                                                    <div class="ml-8">
                                                        <small
                                                            class="italic text-gray-500">{{ $container->title }}</small>
                                                        @if($container->status->notReady())
                                                            <small
                                                                class="italic text-gray-500 text-warning-400">{{ $container->status->label() }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                    @endforeach

                                </x-card>

                            </div>
                        @empty
                            <x-backend.alert bg="blue-500" class="mt-2">
                                {{ __('Please select at least one page language.') }}
                            </x-backend.alert>
                        @endforelse

                        @error('no_selected_container')
                        <x-backend.alert bg="red-500" class="mt-2">
                            {{ __($errors->first('no_selected_container')) }}
                        </x-backend.alert>
                        @enderror
                    </div>

                    <x-slot name="footer">
                        <div class="flex justify-end relative">
                            <x-button icon="clipboard-copy" label="{{__('button.copy')}}"
                                      wire:click="copySelectedContainers" spinner="copySelectedContainers" primary/>
                        </div>
                    </x-slot>
            </x-card>
        </div>

        {{-- Current Container --}}
        <div class="w-full sm:w-1/2">
            <x-card>
                <x-slot:header>
                    <div class="px-4 py-1 flex justify-between items-center border-b dark:border-0 ">
                        <h3 class="text-md text-secondary-700 dark:text-secondary-400 whitespace-normal font-semibold uppercase">{{ __('Current Container') }}</h3>
                    </div>
                </x-slot:header>
                <div>
                    <x-card class="text-blue">
                        <x-slot:header>
                            <div class="px-4 py-1 flex justify-between items-center border-b dark:border-0 ">
                                <h3 class="text-md text-secondary-700 dark:text-secondary-400 whitespace-normal">{{ $currentPageLanguage->getNameWithLanguageCode() }}</h3>

                                @if(! $currentPageLanguage->containers->isAllReady())
                                    <div x-data="{ tooltip: @js(__('Copying and Translating')) }">
                                        <span x-tooltip="tooltip">
                                            <x-icon wire:poll.visible="loadCurrentPageLanguageContainers" name="exclamation-circle" class="w-5 h-5 text-warning-400"></x-icon>
                                        </span>
                                    </div>
                                @endif
                            </div>
                            </x-slot>

                            @forelse($currentPageLanguage->containers as $container)
                                <div class="flex flex-col py-1.5 space-x-1">
                                    <div class="flex items-center">
                                        <span>
                                            {{ $loop->index + 1 }}.
                                        </span>
                                        <p class="mx-2">{{ $container->type->label() }}</p>
                                        <x-button.circle xs positive icon="eye"
                                                         wire:click="previewContainerFromCurrentPageLanguage({{ $container->id }})"
                                                         spinner="previewContainerFromCurrentPageLanguage({{ $container->id }})"/>
                                    </div>
                                    <div class="flex flex-col">
                                        <small class="italic text-gray-500 ml-4">{{ $container->title }}</small>
                                        <small class="italic text-gray-500 ml-4">{{ $container->url }}</small>
                                        @if($container->status->notReady())
                                            <small
                                                class="italic text-gray-500 text-warning-400 ml-4">{{ $container->status->label() }}</small>
                                        @endif
                                    </div>
                                    <div class="self-start">


                                    </div>
                                </div>
                            @empty
                                <x-backend.alert bg="info-400">
                                    {{ __('No available containers.') }}
                                </x-backend.alert>
                        @endforelse
                    </x-card>

                </div>
            </x-card>
        </div>

        @include('livewire.pages.backend.preview_container')
    </div>
</div>
