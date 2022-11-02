<x-input.upload
    :model="$container"
    wire:key="{{ 'image'.$loop->index }}"
    label="{{ __('page.image') }}"
    :name="$mediaCollectionName"
    rules="mimes:jpeg,jpg,png|max:65536"
    :multiple="false"
></x-input.upload>

@error('container.image')
<small class="text-red-500">
    {{ $errors->first('container.image') }}
</small>
@enderror

@include('livewire.pages.backend.button_actions')
