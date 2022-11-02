<div>
    <div class="grid grid-cols-6 mb-4 mx-2 sm:mx-0">
        <div class="col-span-6 sm:col-span-1 pr-2">
            <x-native-select
                label="{{ __('datatable.per_page') }}"
                :options="['10', '15', '20']"
                wire:model="perPage"
            />
        </div>

        @if (isset($filters) && count($filters))
            <div class="col-span-6 sm:col-span-1 pr-2">
                <x-input wire:model="search" label="{{ __('datatable.search') }}" placeholder="{{ $searchPlaceholder }}" />
            </div>
            @foreach($filters as $filter)
                <div class="col-span-6 sm:col-span-1 pr-2">
                    <x-select
                        :wire:key="$filter->name"
                        :label="$filter->label"
                        :options="$filter->options"
                        option-label="label"
                        option-value="id"
                        :wire:model="$filter->name"
                    ></x-select>
                </div>
            @endforeach
        @else
            <div class="col-span-6 sm:col-span-3">
                <x-input wire:model="search" label="{{ __('datatable.search') }}" placeholder="{{ $searchPlaceholder }}" />
            </div>
        @endif

        <div class="col-span-6 sm:col-start-6 sm:col-end-7">
            @if($createButtonTitle)
            <div class="flex justify-end mt-7">
                <x-button md primary label="{{ $createButtonTitle }}" wire:click="createAction"/>
            </div>
            @endif
        </div>
    </div>
    <div class="flex flex-col">
        <div xclass="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8"
             class="-my-2 py-2 overflow-x-auto mx-2 sm:mx-0"
        >
            <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                <table class="min-w-full">
                    <thead>
                        @include('includes.table.header')
                    </thead>
                    <tbody class="bg-white">
                        @include('includes.table.rows')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="p-3">
        {{ $rows->links() }}
    </div>
    @include('includes.table.delete-confirmation')
</div>
