<div x-data>
    <form wire:submit.prevent="{{$method}}">
        <div class="shadow sm:rounded-md">
            <div class="px-4 py-5 bg-white space-y-6 xsm:p-6">
                <div class="flex">
                    @foreach ($grids as $fieldset)
                        <div class="flex flex-auto flex-col">
                            <div class="m-2">
                                @if($fieldset->showTitle && $fieldset->title)
                                    <div class="py-5">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                                            {{ $fieldset->title }}
                                        </h3>
                                    </div>
                                @endif

                                @foreach ($fieldset->fields as $field)
                                    @include('includes.form.field')
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @if(!property_exists($this, 'parentModel'))
                @include('includes.table.delete-confirmation')
            @endif

            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                @if(property_exists($this, 'parentModel'))
                    <x-button md label="{{ __('button.cancel') }}" x-on:click="$wire.emitUp('close')"
                              class="inline-flex"/>
                @else
                    <x-button md label="{{ __('button.cancel') }}" wire:click="cancel" class="inline-flex"/>
                @endif
                @if ($method == 'update' && !property_exists($this, 'parentModel'))
                    @if(!$hideDeleteButton)
                        @if ($enableDeleteConfirmation)
                            <x-button md negative label="{{ __('button.delete') }}" wire:click="deleteAction"
                                      class="inline-flex"/>
                        @else
                            <x-button md negative label="{{ __('button.delete') }}" wire:click="delete"
                                      class="inline-flex"/>
                        @endif
                    @endif
                @endif
                @if ($refresh)
                    <x-button md info label="{{ __('button.refresh') }}" wire:click="refresh" class="inline-flex"/>
                @endif
                <x-button md primary label="{{ __('button.save') }}" type="submit" class="inline-flex"/>
            </div>
        </div>
    </form>
</div>

