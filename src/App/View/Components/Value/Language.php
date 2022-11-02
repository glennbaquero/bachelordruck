<?php

namespace App\View\Components\Value;

use Domain\Pages\Models\Language as LanguageModel;

class Language extends \Illuminate\View\Component
{
    public LanguageModel $language;

    public function __construct(int $value)
    {
        $this->language = LanguageModel::findOrFail($value);
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        return view('components.value.language', [
            'language' => $this->language,
        ]);
    }
}
