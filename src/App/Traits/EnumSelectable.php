<?php

namespace App\Traits;

trait EnumSelectable
{
    private static function getClassShortName(): string
    {
        return (new \ReflectionClass(self::class))->getShortName();
    }

    public static function select(): array
    {
        $select = [];
        $classShortName = (new \ReflectionClass(self::class))->getShortName();
        foreach (self::cases() as $enum) {
            $select[$enum->value] = __($classShortName.'.'.$enum->value);
        }

        return $select;
    }

    public static function options(): array
    {
        $select = [];
        $classShortName = self::getClassShortName();
        foreach (self::cases() as $enum) {
            $select[] = [
                'id' => $enum->value,
                'label' => __($classShortName.'.'.$enum->value),
            ];
        }

        return $select;
    }

    public static function keys(): array
    {
        $select = [];
        foreach (self::cases() as $enum) {
            $select[] = $enum->value;
        }

        return $select;
    }

    public function label(): string
    {
        $classShortName = self::getClassShortName();

        return __($classShortName.'.'.$this->value);
    }
}
