<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Avatar extends Component
{
    public ?string $name;

    public ?string $abbrev;

    public ?string $color;

    public ?string $imageUrl;

    public bool    $short = false;

    public function __construct(
        string $name = '',
        string $abbrev = '',
        string $color = '',
        string $imageUrl = '',
        bool $short = false
    ) {
        $this->name = $name;
        $this->abbrev = $abbrev;
        $this->color = $color;
        $this->imageUrl = $imageUrl;
        $this->short = $short;
    }

    public function render(): View
    {
        return view('components.avatar');
    }
}
