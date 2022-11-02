<?php

namespace Support\Translator\Services;

use Illuminate\Support\Facades\Http;
use Support\Translator\Exceptions\TranslatorException;

class DeeplTranslatorService extends BaseTranslateService
{
    protected string $url = 'https://api-free.deepl.com/v2/translate';

    /**
     * @throws TranslatorException
     */
    public function translate(string|array $textToTranslate, string $targetLanguage): string|array
    {
        $this->setTextToTranslate($textToTranslate);

        $this->targetLanguage = strtoupper($targetLanguage);

        $textQueryString = '?'.$this->makeTextQueryString();

        if (strtolower($this->sourceLanguage) === strtolower($this->targetLanguage)) {
            throw TranslatorException::sameLanguage();
        }

        $jsonResponse = Http::asForm()->post($this->url.$textQueryString, [
            'auth_key' => $this->apiKey,
            'source_lang' => $this->sourceLanguage,
            'target_lang' => $this->targetLanguage,
        ])->json();

        $texts = data_get($jsonResponse['translations'], '*.text');

        // If provided text is array will also provide array response
        if ($this->textToTranslateIsArray) {
            return $texts;
        }

        // Otherwise, it will return the first text.
        return $texts[0];
    }

    protected function makeTextQueryString(): string
    {
        $delimiter = '&text=';

        return $delimiter.implode($delimiter, $this->textToTranslate);
    }
}
