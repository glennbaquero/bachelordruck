<?php

namespace Support\Translator\Services;

use Support\Translator\Exceptions\TranslatorException;
use Support\Translator\Interfaces\TranslatorInterface;

abstract class BaseTranslateService implements TranslatorInterface
{
    protected ?string $apiKey;

    /**
     * @var array{string}
     */
    protected array $textToTranslate;

    /**
     * The target language where the provided text(s) will be translated.
     *
     * @var string
     */
    protected string $targetLanguage;

    /**
     * The source language of the provided text(s).
     *
     * @var string|null
     */
    protected ?string $sourceLanguage = null;

    /**
     * @var bool
     */
    protected bool $textToTranslateIsArray;

    public function setApiKey(?string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function from(?string $sourceLanguage): self
    {
        $this->sourceLanguage = strtoupper($sourceLanguage);

        return $this;
    }

    protected function setTextToTranslate(string|array $textToTranslate): self
    {
        $this->textToTranslateIsArray = is_array($textToTranslate);

        if (! $this->textToTranslateIsArray) {
            $textToTranslate = [$textToTranslate];
        }

        $this->textToTranslate = $textToTranslate;

        return $this;
    }

    /**
     * @throws TranslatorException
     */
    abstract public function translate(string|array $textToTranslate, string $targetLanguage): string|array;
}
