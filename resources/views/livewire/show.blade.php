<div x-data>
    @if ($this->IsGridHasArrayOfFieldset)
        <div class="flex">
            @foreach($grids as $grid)
                <div class="flex flex-auto flex-col">
                    @foreach($grid as $fieldset)
                        @include('includes.fieldset')
                    @endforeach
                </div>
            @endforeach
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-2 items-start">
            @foreach ($grids as $fieldset)
                @include('includes.fieldset')
            @endforeach
        </div>
    @endif
    @if ($showBackButton)
        <div class="m-2 text-right">
            @if(property_exists($this, 'parentModel'))
                <x-button md label="{{ __('button.cancel') }}" x-on:click="$wire.emitUp('close')"
                          class="inline-flex"/>
            @else
                <x-button md label="{{ __('button.cancel') }}" wire:click="back" class="inline-flex"/>
            @endif

            @if(!property_exists($this, 'parentModel'))
                @if(!$hideDeleteButton)
                    @if ($enableDeleteConfirmation)
                        <x-button md negative label="{{ __('button.delete') }}" wire:click="deleteAction"
                                  class="inline-flex"/>
                    @else
                        <x-button md negative label="{{ __('button.delete') }}" wire:click="delete" class="inline-flex"/>
                    @endif
                @endif

                <x-button md primary label="{{ __('button.edit') }}" wire:click="edit" class="inline-flex"/>
            @endif
        </div>
    @endif

    @if(!property_exists($this, 'showModal'))
        @include('includes.table.delete-confirmation')
    @endif

    @if(property_exists($this, 'modalComponentName'))
        <x-modal.card
            wire:model.defer="showModal"
            :title="$modalComponentTitle"
            blur
            max-width="w-full"
            padding="px-0"
            x-on:close="$wire.close"
        >
            @if ($modalComponentName)
                <livewire:is
                    component="{{ $modalComponentName }}"
                    key="{{ $modalComponentName }}"
                    :parent-model="$model"
                    model="{{$childModelId}}"
                ></livewire:is>
            @endif
        </x-modal.card>
    @endif
</div>


