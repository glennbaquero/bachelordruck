<?php

namespace App\View\Components;

use App\View\Editor\Enums\EditorMenuItemEnum;
use Illuminate\View\Component;

class Svg extends Component
{
    public EditorMenuItemEnum $icon;

    public int $width;

    public int $height;

    public string $viewBox;

    public string $fill;

    public ?string $strokeWidth;

    public ?string $id;

    public ?string $class;

    public ?string $style;

    public ?string $stroke;

    public ?string $strokeLinecap;

    public ?string $strokeLinejoin;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $icon,
        $width = 24,
        $height = 24,
        $viewBox = '24 24',
        $fill = 'currentColor',
        $strokeWidth = null,
        $id = null,
        $class = 'w-5 h-5',
        $style = null,
        $stroke = null,
        $strokeLinecap = null,
        $strokeLinejoin = null,
    ) {
        $this->icon = $icon;
        $this->width = $width;
        $this->height = $height;
        $this->viewBox = $viewBox;
        $this->fill = $fill;
        $this->strokeWidth = $strokeWidth;
        $this->id = $id;
        $this->class = $class;
        $this->style = $style;
        $this->stroke = $stroke;
        $this->strokeLinecap = $strokeLinecap;
        $this->strokeLinejoin = $strokeLinejoin;
    }

    public function getIconProperty()
    {
        return $this->icon->value();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.svg');
    }
}
