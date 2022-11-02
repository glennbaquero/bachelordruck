<?php

namespace App\Livewire\View;

use function __;
use App\Contracts\EnumContract;
use App\Livewire\Enums\ColumnEnum;
use Closure;

class Column
{
    /**
     * @var string|null|array
     */
    public array|string|null $field = null;

    /**
     * @var string|null
     */
    public ?string $label = null;

    /**
     * @var bool
     */
    public bool $sortable = false;

    /**
     * @var ColumnEnum|null
     */
    public ?ColumnEnum $type;

    public ?string $sortableField = null;

    protected ?Closure $callback = null;

    /**
     * @var array<array{label: string, action: Closure}>
     */
    protected array $customActions = [];

    public bool $forceLabel = false;

    public ?string $enum;

    public array $options;

    public bool $short;

    /**
     * @param  string|null  $text
     * @param  ColumnEnum  $type
     */
    public function __construct(
        string $label = null,
        string|array $field = null,
        string $token = null,
        ColumnEnum $type = null,
        bool $forceLabel = false,
        string $enum = null,
        array $options = [],
        bool $short = false
    ) {
        if (isset($label)) {
            $this->label = $label;
        } elseif (isset($token)) {
            $this->label = $this->getLabel($token, $field);
        }

        $this->type = $type ?? ColumnEnum::text();

        $this->field = $field;

        $this->forceLabel = $forceLabel;

        $this->enum = $enum;

        $this->options = $options;

        $this->short = $short;
    }

    private function getLabel(string $token, string $field): string
    {
        return __($token.'Fields.'.$field);
    }

    /**
     * @param  string|null  $text
     * @return Column
     */
    public static function make(
        string|array $field = null,
        string $label = null,
        string $token = null,
        ColumnEnum $type = null,
        bool $forceLabel = false,
        string $enum = null,
        array $options = [],
        bool $short = false
    ): Column {
        return new static(
            label:      $label,
            field:      $field,
            token:      $token,
            type:       $type,
            forceLabel: $forceLabel,
            enum:       $enum,
            options:    $options,
            short:      $short
        );
    }

    public static function text(string|array $field = null, string $label = null, string $token = null, bool $forceLabel = false): Column
    {
        return self::make(field: $field, label: $label, token: $token, type: ColumnEnum::text(), forceLabel: $forceLabel);
    }

    public static function boolean(string $field, string $label = null, string $token = null, bool $forceLabel = false): Column
    {
        return self::make(field: $field, label: $label, token: $token, type: ColumnEnum::boolean(), forceLabel: $forceLabel);
    }

    public static function phone(string $field, string $label = null, string $token = null, bool $forceLabel = false): Column
    {
        return self::make(field: $field, label: $label, token: $token, type: ColumnEnum::phone(), forceLabel: $forceLabel);
    }

    public static function color(string $field, string $label = null, string $token = null, bool $forceLabel = false): Column
    {
        return self::make(field: $field, label: $label, token: $token, type: ColumnEnum::color(), forceLabel: $forceLabel);
    }

    public static function email(string $field, string $label = null, string $token = null, bool $forceLabel = false): Column
    {
        return self::make(field: $field, label: $label, token: $token, type: ColumnEnum::email(), forceLabel: $forceLabel);
    }

    public static function url(string $field, string $label = null, string $token = null, bool $forceLabel = false): Column
    {
        return self::make(field: $field, label: $label, token: $token, type: ColumnEnum::url(), forceLabel: $forceLabel);
    }

    public static function team(string $field, string $label = null, string $token = null, bool $forceLabel = false, bool $short = false): Column
    {
        return self::make(field: $field, label: $label, token: $token, type: ColumnEnum::team(), forceLabel: $forceLabel, short: $short);
    }

    public static function user(string $field, string $label = null, string $token = null, bool $forceLabel = false, bool $short = false): Column
    {
        return self::make(field: $field, label: $label, token: $token, type: ColumnEnum::user(), forceLabel: $forceLabel, short: $short);
    }

    public static function fieldset(array $fields, string $label = null, bool $forceLabel = false): Column
    {
        return self::make(field: $fields, label: $label, forceLabel: $forceLabel);
    }

    public static function action(string $action, string $label = null): Column
    {
        if (! isset($label)) {
            $label = __('button.'.$action);
        }

        return self::make(field: $action, label: $label, type: ColumnEnum::action());
    }

    public static function enum(string $field, string $label = null, string $token = null, bool $forceLabel = false, string|EnumContract $enum = null): Column
    {
        return self::make(field: $field, label: $label, token: $token, type: ColumnEnum::enum(), forceLabel: $forceLabel, enum: $enum);
    }

    public static function select(string $field, string $label = null, string $token = null, bool $forceLabel = false, array $options = []): Column
    {
        return self::make(field: $field, label: $label, token: $token, type: ColumnEnum::select(), forceLabel: $forceLabel, options: $options);
    }

    public static function decimal(string $field = null, string $label = null, string $token = null, bool $forceLabel = false): Column
    {
        return self::make(field: $field, label: $label, token: $token, type: ColumnEnum::decimal(), forceLabel: $forceLabel);
    }

    public static function date(string $field = null, string $label = null, string $token = null, bool $forceLabel = false): Column
    {
        return self::make(field: $field, label: $label, token: $token, type: ColumnEnum::date(), forceLabel: $forceLabel);
    }

    public static function language(string $field, string $label = null, string $token = null, bool $forceLabel = false, bool $short = false): Column
    {
        return self::make(field: $field, label: $label, token: $token, type: ColumnEnum::language(), forceLabel: $forceLabel, short: $short);
    }

    /**
     * @return bool
     */
    public function isSortable(): bool
    {
        return $this->sortable === true;
    }

    //    /**
    //     * @return bool
    //     */
    //    public function isSearchable() : bool {
    //        return $this->searchable === true;
    //    }

    /**
     * @return string|null
     */
    public function column(): ?string
    {
        return $this->field;
    }

    //    /**
    //     * @return string|null
    //     */
    //    public function text() : ?string {
    //        return $this->text;
    //    }

    /**
     * @param  ColumnEnum  $type
     */
    public function type(ColumnEnum $type)
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isTypeColumnAction()
    {
        return $this->type === ColumnEnum::action();
    }

    /**
     * @return $this
     */
    public function sortable(string $field = null): self
    {
        if ($field) {
            $this->sortableField = $field;
        }

        $this->sortable = true;

        return $this;
    }

    public function getSortableField()
    {
        if (! $this->sortableField && ! is_array($this->field)) {
            return $this->field;
        }

        return $this->sortableField;
    }

    /**
     * @param  callable|null  $callback
     * @return $this
     */
    public function setCallback(callable $callback = null): Column
    {
        $this->callback = $callback;

        return $this;
    }

    public function getCallback()
    {
        return $this->callback;
    }

    public function getColumnAttribute(): string
    {
        return match ($this->type) {
            ColumnEnum::decimal() => 'number',
            default => 'string'
        };
    }

    public function isFieldTypeAvatar(): bool
    {
        return $this->type === ColumnEnum::avatar();
    }

    /**
     * @param  array<array{label: string, action: Closure}>  $customActions
     * @return Column
     */
    public function setCustomActions(array $customActions): self
    {
        $this->customActions = $customActions;

        return $this;
    }

    /**
     * @return array<array{label: string, action: Closure}>
     */
    public function getCustomActions(): array
    {
        return $this->customActions;
    }
}
