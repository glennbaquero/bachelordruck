<?php
/** @var Domain\Containers\Models\Container $loopContainer */
?>

<div class="w-full">
    <div class="mt-2 sm:mt-0">
        <x-backend.button
            color="green"
            icon="clipboard-copy"
            sm
            positive
            label="{{ __('button.copy_containers') }}"
            href="{{ route('page.copy_containers', [$pageLanguage]) }}"
        />
    </div>

    <div wire:so rtable="updateContainerOrder">
        @forelse($containers as $loopContainer)
            <div
                wire:sortable.item="{{ $loop->index }}"
                wire:key="{{ $loopContainer->id }}"
                @class([
                    'flex w-full flex-col border border-solid rounded border-gray-100 p-2 mt-8 relative',
                    'bg-warning-100' => $this->hasNewContainer && ! $loopContainer->id
                ])
            >
                @if ($loopContainer->id && ! $this->hasActiveContainer)
                    <div class="flex flex-row-reverse absolute -top-3 right-0 mr-2 gap-x-1.5">
                        <x-icon
                            wire:sortable.handle
                            name="arrows-expand"
                            class="w-5 h-5 border border-solid border-gray-400 cursor-move"
                        />

                        <span wire:click="editContainer({{ $loopContainer }})">
                            <x-icon
                                class="w-5 h-5 border border-solid border-gray-400 cursor-pointer"
                                name="pencil"
                            ></x-icon>
                        </span>

                        <span x-data="{}"
                              @click.prevent="$openModal('showModalContainerConfirmation'); $wire.set('containerIdForDeletion', {{ $loopContainer->id }}, true)">
                            <x-icon
                                class="w-5 h-5 right-12 border border-solid border-gray-400 cursor-pointer"
                                name="trash"
                            ></x-icon>
                        </span>
                    </div>
                @endif

                @if ($this->isEditing($loopContainer))
                    @include($loopContainer->type->getBackendView())
                @else
                    <x-dynamic-component component="{{  $loopContainer->type->getFrontendComponent() }}" :container="$loopContainer"
                            class="{{ ($loop->index % 2 === 0) ? config('cms.container_bg_even') : config('cms.container_bg_odd')}}"/>
                @endif
            </div>
        @empty
            <x-backend.alert bg="info-400" class="mt-2">
                {{ __('No available containers.') }}
            </x-backend.alert>
        @endforelse
    </div>

    @if (! $this->hasNewContainer)
        <div class="sm:flex mt-4 justify-between px-2 sm:px-0">
            <div class="space-y-2">
                <x-backend.button class="sm:w-auto w-full" color="blue" icon="video-camera" sm positive
                                  label="{{ __('button.insert_youtube_video') }}"
                                  wire:click="insertNewContainer('youtube_video')"/>
                <x-backend.button class="sm:w-auto w-full" color="blue" icon="camera" sm positive
                                  label="{{ __('button.insert_headline_text_image') }}"
                                  wire:click="insertNewContainer('headline_text_image')"/>
                <x-backend.button class="sm:w-auto w-full" color="blue" icon="document-text" sm positive
                                  label="{{ __('button.insert_headline_text') }}"
                                  wire:click="insertNewContainer('headline_text')"/>
                <x-backend.button class="sm:w-auto w-full" color="blue" icon="camera" sm positive
                                  label="{{ __('button.insert_image') }}" wire:click="insertNewContainer('image')"/>
                <x-backend.button class="sm:w-auto w-full" color="blue" icon="video-camera" sm positive
                                  label="{{ __('button.insert_headline_text_youtube_video') }}"
                                  wire:click="insertNewContainer('headline_text_youtube_video')"/>
            </div>
        </div>
    @endif

    <x-modal.card
        title="{{ __('notification.delete_title') }}"
        max-width="sm"
        wire:model.defer="showModalContainerConfirmation"
    >
        <p> {{ __('notification.delete_container') }}</p>
        <x-slot name="footer">
            <div class="flex flex-row-reverse">
                <x-button negative label="{{ __('button.delete') }}" wire:click="deleteContainer"/>
                <x-button flat label="{{ __('button.close') }}" x-on:click="close" class="mr-2"/>
            </div>
        </x-slot>
    </x-modal.card>
</div>
