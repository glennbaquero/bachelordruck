<?php

namespace App\View\Editor\Enums;

enum EditorMenuItemEnum: string
{
    case H1 = 'h-1';
    case H2 = 'h-2';
    case ADD_COLUMN_BEFORE = 'add-column-before';
    case ARROW_GO_BACK_LINE = 'arrow-go-back-line';
    case ARROW_GO_FORWARD_LINE = 'arrow-go-forward-line';
    case BOLD = 'bold';
    case CODE_VIEW = 'code-view';
    case DELETE_TABLE = 'delete-table';
    case DOUBLE_QUOTES = 'double-quotes-l';
    case FORMAT_CLEAR = 'format-clear';
    case ITALIC = 'italic';
    case LIST_ORDERED = 'list-ordered';
    case LIST_UNORDERED = 'list-unordered';
    case PARAGRAPH = 'paragraph';
    case STRIKE_THROUGH = 'strikethrough';
    case TABLE = 'table';
    case ADD_COLUMN_AFTER = 'add-column-after';
    case ADD_ROW_BEFORE = 'add-row-before';
    case ADD_ROW_AFTER = 'add-row-after';
    case DELETE_COLUMN = 'delete-column';
    case DELETE_ROW = 'delete-row';
    case MERGE_CELL = 'merge-cell';
    case SPLIT_CELL = 'split-cell';
    case TOGGLE_HEADER_ROW = 'toggle-header-row';
    case TOGGLE_HEADER_COLUMN = 'toggle-header-column';
    case TOGGLE_LINK = 'toggle-link';
}
