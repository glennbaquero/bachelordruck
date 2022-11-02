<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Select extends Component
{
    public string $rightIcon;

    public string $optionComponent;

    public bool $searchable;

    public bool $multiselect;

    public ?string $icon;

    public ?string $label;

    public ?string $placeholder;

    public ?string $optionValue;

    public ?string $optionLabel;

    public bool $optionKeyLabel;

    public bool $avatar;

    public bool $optionKeyValue;

    public array|null|Collection $options;

    public function __construct(
        string $rightIcon = 'selector',
        string $optionComponent = 'select.option',
        bool $searchable = true,
        bool $multiselect = false,
        bool $optionKeyLabel = false,
        bool $optionKeyValue = false,
        ?string $label = null,
        ?string $placeholder = null,
        ?string $optionValue = null,
        ?string $optionLabel = null,
        ?string $icon = null,
        $options = null,
        bool $avatar = false
    ) {
        $this->rightIcon = $rightIcon;
        $this->optionComponent = $optionComponent;
        $this->searchable = $searchable;
        $this->multiselect = $multiselect;
        $this->icon = $icon;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->optionValue = $optionValue;
        $this->optionLabel = $optionLabel;
        $this->optionKeyLabel = $optionKeyLabel;
        $this->optionKeyValue = $optionKeyValue;
        $this->options = $options;
        $this->avatar = $avatar;
    }

    public function defaultClasses(): string
    {
        return 'block w-full pl-3 pr-10 py-2 text-base sm:text-sm shadow-sm
                rounded-md border bg-white focus:ring-1 focus:outline-none
                dark:bg-secondary-800 dark:border-secondary-600 dark:text-secondary-400';
    }

    public function colorClasses(): string
    {
        return 'border-secondary-300 focus:ring-primary-500 focus:border-primary-500';
    }

    public function errorClasses()
    {
        return 'border-negative-400 focus:ring-negative-500 focus:border-negative-500 text-negative-500
                dark:border-negative-600 dark:text-negative-500';
    }

    public function getOptionValue($key, $option)
    {
        if ($this->optionKeyValue) {
            return $key;
        }

        return data_get($option, $this->optionValue);
    }

    public function getOptionLabel($key, $option)
    {
        if ($this->optionKeyLabel) {
            return $key;
        }

        return data_get($option, $this->optionLabel);
    }

    protected function sharedAttributes(): array
    {
        return ['id', 'name', 'disabled', 'readonly'];
    }

    protected function mergeAttributes(array $data): array
    {
        $attributes = $data['attributes'];
        $model = $attributes->wire('model')->value();

        if (! $attributes->has('name') && $model) {
            $attributes->offsetSet('name', $model);
        }

        if (! $attributes->has('id') && $model) {
            $attributes->offsetSet('id', md5($model));
        }

        foreach ($this->sharedAttributes() as $attribute) {
            $data[$attribute] = $attributes->get($attribute);
        }

        return $data;
    }

    protected function classes(array $classList): string
    {
        $classes = [];

        foreach ($classList as $class => $constraint) {
            if (is_numeric($class)) {
                $classes[] = $constraint;
            } elseif ($constraint) {
                $classes[] = $class;
            }
        }

        return implode(' ', $classes);
    }

    public function getView(): string
    {
        return 'components.input.select';
    }

    public function render()
    {
        return function (array $data) {
            return view($this->getView(), $this->mergeAttributes($data))->render();
        };
    }
}
