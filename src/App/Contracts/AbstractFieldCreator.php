<?php

namespace App\Contracts;

use App\Enums\DataFieldTypeEnum;
use Support\DataField;

class AbstractFieldCreator
{
    protected string $model;

    public function __construct(string $model)
    {
        $this->setModel($model);
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function dynamic(
        string|FieldEnumContract $field,
        DataFieldTypeEnum $type,
        string $label = null,
        string $enum = null,
        array $options = [],
        bool $defer = true,
        bool $basic = true,
        bool $avatar = false,
        string $hint = null,
        string $rules = null,
        bool $multiple = false,
        string $mediaCollectionName = null,
        bool $preview = true,
        bool $customProperty = false,
        bool $readonly = false,
        bool $autofocus = false,
        string $module = null,
        string $value = null,
    ): DataField {
        return new DataField(
            field: $field,
            model: $this->model,
            type:  $type,
            label: $label,
            options: $options,
            enum: $enum,
            defer: $defer,
            basic: $basic,
            avatar: $avatar,
            hint: $hint,
            rules: $rules,
            multiple: $multiple,
            mediaCollectionName: $mediaCollectionName,
            preview: $preview,
            customProperty: $customProperty,
            readonly: $readonly,
            autofocus: $autofocus,
            module: $module,
            value: $value,
        );
    }

    public function text(string|FieldEnumContract $field, string $label = null, bool $defer = true, bool $readonly = false, bool $autofocus = false): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::TEXT, label: $label, defer: $defer, readonly: $readonly, autofocus: $autofocus);
    }

    public function textarea(string|FieldEnumContract $field, string $label = null, bool $defer = true, string $hint = null): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::TEXTAREA, label: $label, defer: $defer, hint: $hint);
    }

    public function phone(string|FieldEnumContract $field, string $label = null, bool $defer = true): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::PHONE, label: $label, defer: $defer);
    }

    public function email(string|FieldEnumContract $field, string $label = null, bool $defer = true, bool $readonly = false, bool $autofocus = false): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::EMAIL, label: $label, defer: $defer, readonly: $readonly, autofocus: $autofocus);
    }

    public function url(string|FieldEnumContract $field, string $label = null, bool $defer = true): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::URL, label: $label, defer: $defer);
    }

    public function color(string|FieldEnumContract $field, string $label = null, bool $defer = true): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::COLOR, label: $label, defer: $defer);
    }

    public function checkbox(string|FieldEnumContract $field, string $label = null, bool $defer = true, bool $readonly = false): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::CHECKBOX, label: $label, defer: $defer, readonly: $readonly);
    }

    public function select(string|FieldEnumContract $field, string $label = null, array $options = [], bool $defer = true, bool $avatar = false, bool $readonly = false): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::SELECT, label: $label, options: $options, defer: $defer, avatar: $avatar, readonly: $readonly);
    }

    public function selectMultiple(string|FieldEnumContract $field, string $label = null, array $options = [], bool $defer = true, bool $avatar = false): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::SELECT, label: $label, options: $options, defer: $defer, avatar: $avatar, multiple: true);
    }

    public function selectNative(string|FieldEnumContract $field, string $label = null, array $options = [], bool $defer = true, bool $avatar = false): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::SELECT_NATIVE, label: $label, options: $options, defer: $defer, avatar: $avatar);
    }

    public function date(string|FieldEnumContract $field, string $label = null, bool $defer = true): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::DATE, label: $label, defer: $defer);
    }

    public function editor(string|FieldEnumContract $field, string $label = null, bool $defer = true, bool $basic = true): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::EDITOR, label: $label, defer: $defer, basic: $basic);
    }

    public function team(string|FieldEnumContract $field, string $label = null, bool $defer = true): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::TEAM, label: $label, defer: $defer);
    }

    public function user(string|FieldEnumContract $field, string $label = null, bool $defer = true): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::USER, label: $label, defer: $defer);
    }

    public function enum(string|FieldEnumContract $field, string|EnumContract $label = null, string $enum = null, bool $defer = true): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::ENUM, label: $label, enum: $enum, defer: $defer);
    }

    public function decimal(string|FieldEnumContract $field, string $label = null, bool $defer = true): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::DECIMAL, label: $label, defer: $defer);
    }

    public function avatar(string|FieldEnumContract $field, $label = null, bool $defer = true): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::AVATAR, label: $label, defer: $defer);
    }

    public function hidden(string|FieldEnumContract $field, $label = null, bool $defer = true): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::HIDDEN, label: $label, defer: $defer);
    }

    public function upload(string|FieldEnumContract $field, $label = null, bool $defer = true, string $rules = null, bool $multiple = false, string $mediaCollectionName = null, bool $preview = false, bool $customProperty = false): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::UPLOAD, label: $label, defer: $defer, rules: $rules, multiple: $multiple, mediaCollectionName: $mediaCollectionName, preview: $preview, customProperty: $customProperty);
    }

    public function password(string|FieldEnumContract $field, string $label = null, bool $defer = true, bool $readonly = false, bool $autofocus = false): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::PASSWORD, label: $label, defer: $defer, readonly: $readonly, autofocus: $autofocus);
    }

    public function childList(string $module, string $title = ''): DataField
    {
        return $this->dynamic(field: '', type: DataFieldTypeEnum::CHILD_LIST, label: $title, module: $module);
    }

    public function customText(string|FieldEnumContract $field, string $label = null, bool $defer = true, bool $readonly = false, bool $autofocus = false, string $value = null): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::CUSTOM_TEXT, label: $label, defer: $defer, readonly: $readonly, autofocus: $autofocus, value: $value);
    }

    public function customUrl(string|FieldEnumContract $field, string $label = null, bool $defer = true, string $value = null): DataField
    {
        return $this->dynamic(field: $field, type: DataFieldTypeEnum::CUSTOM_URL, label: $label, defer: $defer, value: $value);
    }
}
