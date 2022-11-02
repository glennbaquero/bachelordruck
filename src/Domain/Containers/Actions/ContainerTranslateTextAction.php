<?php

namespace Domain\Containers\Actions;

use Domain\Containers\Models\Container;
use Domain\Exceptions\UnableToTranslateContainerText;
use Support\Translator\Interfaces\TranslatorInterface;

class ContainerTranslateTextAction
{
    public function __construct(protected TranslatorInterface $translator)
    {
    }

    /**
     * @throws UnableToTranslateContainerText
     */
    public function __invoke(Container $container): void
    {
        $sourceContainer = $container->sourceContainer;

        // If container is not copied.
        if (! $sourceContainer) {
            return;
        }

        /**
         * If the source container and the copied container has the same language,
         * it will not be translated.
         */
        if ($sourceContainer->pageLanguage->id === $container->pageLanguage->id) {
            return;
        }

        $translatableFields = $container->type->translatableFields();

        $fieldKeys = [];
        $fieldValues = [];

        foreach ($translatableFields as $field) {
            if (! empty($fieldValue = $container->{$field})) {
                $fieldKeys[] = $field;
                $fieldValues[] = $fieldValue;
            }
        }

        if (! empty($fieldValues)) {
            try {
                /** @var TranslatorInterface $translator */
                $translatedTexts = $this->translator
                    ->from($sourceContainer->pageLanguage->language->languageCode)
                    ->translate($fieldValues, $container->pageLanguage->language->languageCode);

                $translatedTextsWithKeys = array_combine($fieldKeys, $translatedTexts);

                foreach ($fieldKeys as $fieldKey) {
                    $container->{$fieldKey} = $translatedTextsWithKeys[$fieldKey];
                }

                $container->save();
            } catch (\Exception $e) {
                throw new UnableToTranslateContainerText(__('Unable to translate container text.'));
            }
        }
    }
}
