<div>
    @if($field->isFieldTypeSelect())
        <x-dynamic-component
            :component="$field->type->getFormType()"
            wire:model.defer="{{ $field->getWireModelName(index: $index ?? null) }}"
            :label="$field->label"
            :options="$field->options"
            option-label="label"
            option-value="id"
            :avatar="$field->avatar"
            :hint="$field->hint"
            :multiselect="$field->multiple"
            :readonly="$field->readonly"
        ></x-dynamic-component>
    @elseif($field->isFieldTypeSelectNative())
        <x-native-select
            wire:model.defer="{{ $field->getWireModelName(index: $index ?? null) }}"
            :label="$field->label"
            :options="$field->options"
            option-label="label"
            option-value="id"
        ></x-native-select>
    @elseif($field->isFieldTypeAvatar())
        <x-dynamic-component
            :component="$field->type->getFormType()"
            :value="$avatarModel"
            :label="$field->label"
            :hint="$field->hint"
        ></x-dynamic-component>
    @elseif($field->isFieldTypeUpload())
        <x-input.upload
            :model="$uploadModel"
            :label="$field->label"
            :rules="$field->rules"
            :name="$field->mediaCollectionName"
            :multiple="$field->multiple"
            :editing="$method === 'update'"
            fields-view="components.input.partials.custom-properties"
            :customProperty="$field->customProperty"
        ></x-input.upload>
    @else
        <div class="{{ $field->type->getFormType() === 'toggle' ? 'my-5':'' }}">
        @if ($field->defer)
            <x-dynamic-component
                :component="$field->type->getFormType()"
                wire:model.defer="{{ $field->getWireModelName(index: $index ?? null) }}"
                :label="$field->label"
                :basic="$field->basic"
                :hint="$field->hint"
                :readonly="$field->readonly"
                :autofocus="$field->autofocus"
            ></x-dynamic-component>
        @else
            <x-dynamic-component
                :component="$field->type->getFormType()"
                wire:model.lazy="{{ $field->getWireModelName(index: $index ?? null) }}"
                :label="$field->label"
                :basic="$field->basic"
                :hint="$field->hint"
                :readonly="$field->readonly"
                :autofocus="$field->autofocus"
            ></x-dynamic-component>
        @endif
        </div>
    @endif
</div>
