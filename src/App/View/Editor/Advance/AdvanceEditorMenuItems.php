<?php

namespace App\View\Editor\Advance;

use App\View\Components\Svg;
use App\View\Editor\Enums\EditorMenuItemEnum;
use App\View\Editor\MenuItem;

class AdvanceEditorMenuItems
{
    public function __invoke(): array
    {
        return [
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().focus().insertTable({ rows: 3, cols: 3, withHeaderRow: true }).run()',
                svg: new Svg(EditorMenuItemEnum::TABLE)
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().focus().deleteTable().run()',
                svg: new Svg(
                    EditorMenuItemEnum::DELETE_TABLE,
                    viewBox: '1024 1024',
                    style: 'width: 1em; height: 1em;vertical-align: middle;fill: currentColor;overflow: hidden;',
                )
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().focus().addColumnBefore().run()',
                svg: new Svg(
                    icon: EditorMenuItemEnum::ADD_COLUMN_BEFORE,
                    width: '17.5',
                    height: '17.5',
                    strokeWidth: '1.5',
                    stroke: '#000000',
                    strokeLinecap: 'round',
                    strokeLinejoin: 'round'
                )
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().focus().addColumnAfter().run()',
                svg: new Svg(
                    icon: EditorMenuItemEnum::ADD_COLUMN_AFTER,
                    width: '17.5',
                    height: '17.5',
                    strokeWidth: '1.5',
                    stroke: '#000000',
                    strokeLinecap: 'round',
                    strokeLinejoin: 'round'
                )
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().focus().addRowBefore().run()',
                svg: new Svg(
                    icon: EditorMenuItemEnum::ADD_ROW_BEFORE,
                    width: '17.5',
                    height: '17.5',
                    strokeWidth: '1.5',
                    stroke: '#000000',
                    strokeLinecap: 'round',
                    strokeLinejoin: 'round'
                )
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().focus().addRowAfter().run()',
                svg: new Svg(
                    icon: EditorMenuItemEnum::ADD_ROW_AFTER,
                    width: '17.5',
                    height: '17.5',
                    strokeWidth: '1.5',
                    stroke: '#000000',
                    strokeLinecap: 'round',
                    strokeLinejoin: 'round'
                )
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().focus().deleteColumn().run()',
                svg: new Svg(
                    icon: EditorMenuItemEnum::DELETE_COLUMN,
                    viewBox: '26 26',
                    stroke: '#000000',
                )
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().focus().deleteRow().run()',
                svg: new Svg(
                    icon: EditorMenuItemEnum::DELETE_ROW,
                    stroke: '#000000',
                )
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().focus().mergeCells().run()',
                svg: new Svg(
                    icon: EditorMenuItemEnum::MERGE_CELL,
                    viewBox: '512 512',
                    stroke: '#000000'
                )
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().focus().splitCell().run()',
                svg: new Svg(
                    icon: EditorMenuItemEnum::SPLIT_CELL,
                    viewBox: '512 512',
                    stroke: '#000000',
                )
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().focus().toggleHeaderRow().run()',
                svg: new Svg(
                    icon: EditorMenuItemEnum::TOGGLE_HEADER_ROW,
                    stroke: '#000000',
                )
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().focus().toggleHeaderColumn().run()',
                svg: new Svg(
                    icon: EditorMenuItemEnum::TOGGLE_HEADER_COLUMN,
                    stroke: '#000000',
                )
            ),
        ];
    }
}
