<?php

namespace App\View\Components\Input;

use App\View\Editor\Advance\AdvanceEditorMenuItems;
use App\View\Editor\Basic\BasicEditorMenuItems;
use Illuminate\View\Component;

class Editor extends Component
{
    public bool $basic;

    public array $basicMenus;

    public array $advanceMenus;

    public function __construct(BasicEditorMenuItems $basicEditorMenuItems, AdvanceEditorMenuItems $advanceEditorMenuItems, bool $basic = true)
    {
        $this->basicMenus = $basicEditorMenuItems();
        $this->advanceMenus = $advanceEditorMenuItems();
        $this->basic = $basic;
    }

    public function render()
    {
        return view('components.input.editor');
    }
}
