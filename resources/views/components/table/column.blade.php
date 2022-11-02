@props([
    'column' => '',
    'item' => '',
])
<td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
    <div class="flex items-center {{ $column->getColumnAttribute() === 'number' ? 'justify-end':'justify-start' }}">
        <div>
            <div>
                @if (is_array($column->field))
                    @foreach($column->field as $field)
                        <x-table.field
                            :type="'value.'.$field->type->value"
                            :value="$item->{$field->field}"
                            :label="$field->label"
                            :force="$column->forceLabel === true ? $column->forceLabel : $field->forceLabel"
                            :enum="$column->enum"
                            :options="$column->options"
                            :short="$field->short"
                        ></x-table.field>
                    @endforeach
                @else
                    <x-table.field
                        :type="'value.'.$column->type->value"
                        :value="$item->{$column->field}"
                        :label="$column->label"
                        :force="$column->forceLabel"
                        :enum="$column->enum"
                        :options="$column->options"
                        :short="$column->short"
                    ></x-table.field>
                @endif
            </div>
        </div>
    </div>
</td>
