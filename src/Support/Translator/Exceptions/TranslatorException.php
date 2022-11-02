<?php

namespace Support\Translator\Exceptions;

use Exception;

class TranslatorException extends Exception
{
    public static function sameLanguage()
    {
        return new static(__('Target and Source Language must not be same.'));
    }
}
