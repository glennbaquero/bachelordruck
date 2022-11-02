<?php

namespace Support\Translator\Interfaces;

interface TranslatorInterface
{
    public function setApiKey(?string $apiKey): self;

    public function from(?string $sourceLanguage): self;

    public function translate(string|array $textToTranslate, string $targetLanguage): string|array;
}
