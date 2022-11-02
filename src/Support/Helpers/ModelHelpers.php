<?php

namespace Support\Helpers;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ModelHelpers
{
    public static function getDomain(string $model): string
    {
        return match ((string) Str::of($model)->lower()->singular()) {
            'account' => 'Accounts',
            'contact' => 'Contacts',
            'team' => 'Teams',
        };
    }

    public static function getRelationIds(Model $model, string $relationName, ?string $keyName = null): Attribute
    {
        if ($keyName === null) {
            $keyName = Str::singular($relationName).'_ids';
        }

        if (array_key_exists($keyName, $model->getAttributes())) {
            return Attribute::get(fn () => $model->getAttributes()[$keyName]);
        }

        if ($model->relationLoaded($relationName)) {
            return Attribute::get(fn () => $model->{$relationName}->modelKeys());
        }

        return Attribute::get(fn () => []);
    }
}
