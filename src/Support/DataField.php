<?php

namespace Support;

use App\Contracts\FieldEnumContract;
use App\Enums\DataFieldTypeEnum;

class DataField
{
    public function __construct(
        public string|FieldEnumContract $field,
        public string $model,
        public DataFieldTypeEnum $type,
        public ?string $label = null,
        public ?array $options = [],
        public ?string $enum = null,
        public bool $defer = true,
        public bool $basic = true,
        public bool $avatar = false,
        public ?string $hint = null,
        public ?string $rules = null,
        public bool $multiple = false,
        public ?string $mediaCollectionName = null,
        public bool $preview = true,
        public bool $customProperty = false,
        public bool $readonly = false,
        public bool $autofocus = false,
        public ?string $module = null,
        public ?string $value = null,
    ) {
        if (! $this->label && $this->model) {
            $this->label = $this->getLabel();
        }
    }

    private function getField(): string
    {
        if (! is_string($this->field)) {
            return $this->field->value;
        }

        return $this->field;
    }

    private function getLabel(): string
    {
        return __($this->model.'Fields.'.$this->getField());
    }

    public function isFieldTypeSelect(): bool
    {
        return $this->type === DataFieldTypeEnum::SELECT;
    }

    public function isFieldTypeSelectNative(): bool
    {
        return $this->type === DataFieldTypeEnum::SELECT_NATIVE;
    }

    public function isFieldTypeAvatar(): bool
    {
        return $this->type === DataFieldTypeEnum::AVATAR;
    }

    public function isChildList(): bool
    {
        return $this->type === DataFieldTypeEnum::CHILD_LIST;
    }

    public function isFieldTypeUpload(): bool
    {
        return $this->type === DataFieldTypeEnum::UPLOAD;
    }

    public function options(array $options): DataField
    {
        $this->options = $options;

        return $this;
    }

    public function optionsKeyValue(array $options)
    {
        $this->options = [];
        foreach ($options as $key => $label) {
            $this->options[] = [
                'id' => $key,
                'label' => $label,
            ];
        }
    }

    public function getWireModelName(string $model = null, int $index = null): string
    {
        if ($index !== null) {
            return sprintf('%s.%s.%s', $model ?? $this->model, $index, $this->getField());
        }

        return sprintf('%s.%s', $model ?? $this->model, $this->getField());
    }
}
