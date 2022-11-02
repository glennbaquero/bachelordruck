<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRules
{
    public static function getRules(?Model $model = null): array
    {
        //todo roy: singleton
        $object = new static($model);

        return $object->rules();
    }

    abstract public function rules(): array;
}
