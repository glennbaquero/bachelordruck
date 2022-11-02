<?php

namespace Domain\Orders\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Support\Helpers\Decimals;

trait HasConfiguration
{
    public function productDetails1(): Attribute
    {
        return Attribute::get(function () {
            $text = '';

            foreach ($this->configuration['details'] as $detail) {
                $text .= $detail['label'].(empty($detail['label']) ? '' : ': ').$detail['value'].PHP_EOL;
            }

            return $text;
        });
    }

    public function productDetails2(): Attribute
    {
        $this->loadMissing('product');

        return Attribute::get(function () {
            $texts[] = $this->product->title;

            foreach ($this->configuration['details'] as $detail) {
                $texts[] = $detail['label'].(empty($detail['label']) ? '' : ' ').$detail['value'];
            }

            return implode(', ', $texts);
        });
    }

    /**
     * @throws \Exception
     */
    public function priceFormatted(): Attribute
    {
        return Decimals::formatAsAttribute($this->price);
    }

    public function totalCost(): Attribute
    {
        return Attribute::get(function () {
            return round($this->price * $this->qty, 2, PHP_ROUND_HALF_UP);
        });
    }

    /**
     * @throws \Exception
     */
    public function totalCostFormatted(): Attribute
    {
        return Decimals::formatAsAttribute($this->total_cost);
    }
}
