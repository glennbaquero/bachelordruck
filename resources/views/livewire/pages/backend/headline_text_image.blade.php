<x-input
    label="{{ __('page.headline') }}"
    wire:model.defer="container.title"
    wire:key="{{ 'headline'.$loop->index }}"
></x-input>

<x-input.editor
    wire:model.defer="container.content"
    label="{{ __('page.richtext') }}"
    wire:key="{{ 'content'.$loop->index }}"
></x-input.editor>

<x-input.upload
    :model="$container"
    wire:key="{{ 'image'.$loop->index }}"
    label="{{ __('page.image') }}"
    :name="$mediaCollectionName"
    rules="mimes:jpeg,jpg,png|max:65536"
></x-input.upload>
@error('container.image')
<small class="text-red-500">
    {{ $errors->first('container.image') }}
</small>
@enderror

<x-select
    :options="\Domain\Pages\Enums\ImageAlignmentEnum::options()"
    wire:model.defer="container.image_alignment"
    label="{{ __('page.image_alignment') }}"
    option-label="label"
    option-value="id"
    wire:key="{{ 'alignment'.$loop->index }}"
    :multiple="false"
/>

@include('livewire.pages.backend.button_actions')
