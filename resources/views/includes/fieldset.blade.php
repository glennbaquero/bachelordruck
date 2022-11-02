<div class="bg-white shadow overflow-hidden sm:rounded-lg m-2">
    @if($fieldset->showTitle && !empty($fieldset->title))
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                {{ $fieldset->title }}
            </h3>
        </div>
    @endif
    @foreach ($fieldset->fields as $field)
        <div @class([
            "border-t border-gray-200" => (!$loop->first)
        ])>
            @if($field->isFieldTypeAvatar())
                <x-dynamic-component
                    component="{{ $field->type->getOutputType() }}"
                    :value="$model->initials??Support\Helpers\NameHelpers::getInitials($model->name)"
                    label="{{ $field->label }}"
                    enum="{{ $field->enum }}"
                    :url="$model->getFirstMediaUrl('avatars')"
                    :color="$model->color"
                >
                </x-dynamic-component>
            @elseif($field->isChildList())
                <x-dynamic-component
                    component="{{ $field->type->getOutputType() }}"
                    title="{{ $field->label }}"
                    component-class="{{ $field->module }}"
                    parent-model-id="{{ $model->id }}"
                >
                </x-dynamic-component>
            @else
                <x-dynamic-component
                    component="{{ $field->type->getOutputType() }}"
                    :value="$model->{$field->field->value??$field->field}"
                    label="{{ $field->label }}"
                    enum="{{ $field->enum }}"
                    :options="$field->options"
                    :default-value="$field->value"
                >
                </x-dynamic-component>
            @endif
        </div>
    @endforeach
</div>
