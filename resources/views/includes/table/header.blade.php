<tr>
    @foreach($columns as $index => $column)
        <x-table.th
            label="{{$column->isTypeColumnAction() ? '' : $column->label}}"
            value="{{$column->getSortableField()}}"
            :canSort="$column->isSortable()"
            :sortField="$sortField"
            :sortAsc="$sortAsc"
            :column="$column"
        />
    @endforeach
</tr>
