<?php

namespace App\View\Editor\Basic;

use App\View\Components\Svg;
use App\View\Editor\Enums\EditorMenuItemEnum;
use App\View\Editor\MenuItem;

class BasicEditorMenuItems
{
    public function __invoke(): array
    {
        return [
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().toggleHeading({ level: 1 }).focus().run()',
                svg: new Svg(icon: EditorMenuItemEnum::H1),
                active: "isActive('heading', { level: 1 }, updatedAt)"
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().toggleHeading({ level: 2 }).focus().run()',
                svg: new Svg(icon: EditorMenuItemEnum::H2),
                active: "isActive('heading', { level: 2 }, updatedAt)"
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().setParagraph().run()',
                svg: new Svg(icon: EditorMenuItemEnum::PARAGRAPH),
                active: "isActive('paragraph', updatedAt)",
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().toggleBold().focus().run()',
                svg: new Svg(icon: EditorMenuItemEnum::BOLD),
                active: "isActive('bold', updatedAt)",
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().toggleItalic().focus().run()',
                svg: new Svg(icon: EditorMenuItemEnum::ITALIC),
                active: "isActive('italic', updatedAt)"
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().toggleStrike().focus().run()',
                svg: new Svg(icon: EditorMenuItemEnum::STRIKE_THROUGH),
                active: "isActive('strike', updatedAt)"
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().toggleCode().focus().run()',
                svg: new Svg(icon: EditorMenuItemEnum::CODE_VIEW),
                active: "isActive('code', updatedAt)"
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().toggleBulletList().focus().run()',
                svg: new Svg(icon: EditorMenuItemEnum::LIST_UNORDERED),
                active: "isActive('bulletList', updatedAt)"
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().toggleOrderedList().focus().run()',
                svg: new Svg(icon: EditorMenuItemEnum::LIST_ORDERED),
                active: "isActive('orderedList', updatedAt)"
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().toggleBlockquote().focus().run()',
                svg: new Svg(icon: EditorMenuItemEnum::DOUBLE_QUOTES),
                active: "isActive('blockquote', updatedAt)"
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().focus().clearNodes().unsetAllMarks().run()',
                svg: new Svg(icon: EditorMenuItemEnum::FORMAT_CLEAR),
                active: 'false'
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().focus().undo().run()',
                svg: new Svg(icon: EditorMenuItemEnum::ARROW_GO_BACK_LINE),
                active: 'false',
            ),
            MenuItem::create(
                action: 'Alpine.raw(editor).chain().focus().redo().run()',
                svg: new Svg(icon: EditorMenuItemEnum::ARROW_GO_FORWARD_LINE),
                active: 'false'
            ),
            MenuItem::create(
                action: 'setLink',
                svg: new Svg(
                    icon: EditorMenuItemEnum::TOGGLE_LINK,
                    viewBox: '24 24',
                    fill: 'none',
                    strokeWidth: '2',
                    stroke: 'currentColor',
                ),
                active: "isActive('link', 'updatedAt')",
            ),
        ];
    }
}
