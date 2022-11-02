<?php

namespace App\Faker;

use Faker\Provider\Base;

class ColorProvider extends Base
{
    private function randomPart(): string
    {
        return str_pad(dechex(random_int(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    private function generateColor(): string
    {
        return '#'.$this->randomPart().$this->randomPart().$this->randomPart();
    }

    public function color(): string
    {
        return $this->generateColor();
    }
}
