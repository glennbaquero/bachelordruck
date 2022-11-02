<?php

namespace App\Enums;

enum DataFieldTypeEnum: string
{
    case TEXT = 'text';
    case TEXTAREA = 'textarea';
    case PHONE = 'phone';
    case EMAIL = 'email';
    case URL = 'url';
    case COLOR = 'color';
    case CHECKBOX = 'checkbox';
    case SELECT = 'select';
    case DATE = 'date';
    case EDITOR = 'editor';
    case TEAM = 'team';
    case ENUM = 'enum';
    case DECIMAL = 'decimal';
    case AVATAR = 'avatar';
    case HIDDEN = 'hidden';
    case USER = 'user';
    case UPLOAD = 'upload';
    case SELECT_NATIVE = 'select_native';
    case PASSWORD = 'password';
    case CHILD_LIST = 'child_list';
    case CUSTOM_TEXT = 'custom_text';
    case CUSTOM_URL = 'custom_url';

    case ACTION = 'action';

    public function getFormType(): string
    {
        return match ($this) {
            self::TEXT,
            self::PHONE,
            self::EMAIL,
            self::URL => 'input',
            self::DATE => 'input.date',
            self::COLOR => 'input.color',
            self::CHECKBOX => 'toggle',
            self::TEXTAREA => 'textarea',
            self::EDITOR => 'input.editor',
            self::SELECT_NATIVE => 'select',
            self::SELECT,
            self::USER,
            self::TEAM => 'input.select',
            self::DECIMAL => 'input.decimal',
            self::AVATAR => 'input.avatar',
            self::HIDDEN => 'input.hidden',
            self::UPLOAD => 'input.upload',
            self::PASSWORD => 'input.password',
            default => throw new \Exception('Unexpected match value'),
        };
    }

    public function getOutputType(): string
    {
        return match ($this) {
            self::TEXT => 'output.text',
            self::TEXTAREA,
            self::EDITOR => 'output.editor',
            self::DATE => 'output.date',
            self::SELECT_NATIVE,
            self::SELECT => 'output.select',
            self::TEAM => 'output.team',
            self::USER => 'output.user',
            self::PHONE => 'output.phone',
            self::EMAIL => 'output.email',
            self::URL => 'output.url',
            self::COLOR => 'output.color',
            self::ENUM => 'output.enum',
            self::CHECKBOX => 'output.boolean',
            self::DECIMAL => 'output.decimal',
            self::AVATAR => 'output.avatar',
            self::HIDDEN => 'output.hidden',
            self::CHILD_LIST => 'output.child_list',
            self::CUSTOM_TEXT => 'output.custom-text',
            self::CUSTOM_URL => 'output.custom-url',
            default => throw new \Exception('Unexpected match value'),
        };
    }
}
