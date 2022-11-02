<div class="{{ $bg }} px-4">
    <div
        class="py-8 xl:container xl:mx-auto grid grid-cols-3 lg:grid-cols-5 text-sm md:text-base gap-x-4 text-center uppercase">
        <div>
            <a href="{{ app(\Support\Helpers\FrontendLanguageHelper::class)->translateUrlToCurrentLanguage('Orgelbau') }}">
                <img class="w-full" src="/img/x-orgelbau.jpg" alt="">
                <span class="py-2 block">{{ app(\Support\Helpers\FrontendLanguageHelper::class)->translateCurrentLanguageName('Orgelbau') }}</span>
            </a>
        </div>
        <div>
            <a href="{{ app(\Support\Helpers\FrontendLanguageHelper::class)->translateUrlToCurrentLanguage('Neubauten') }}">
                <img class="w-full" src="/img/x-werkverzeichnis.jpg" alt="">
                <span class="py-2 block">{{ app(\Support\Helpers\FrontendLanguageHelper::class)->translateCurrentLanguageName('Werkverzeichnis') }}</span>
            </a>
        </div>
        <div>
            <a href="{{ app(\Support\Helpers\FrontendLanguageHelper::class)->translateUrlToCurrentLanguage('Geschichte') }}">
                <img class="w-full" src="/img/x-geschichte.jpg" alt="">
                <span class="py-2 block">{{ app(\Support\Helpers\FrontendLanguageHelper::class)->translateCurrentLanguageName('Geschichte') }}</span>
            </a>
        </div>
        <div>
            <a href="{{ app(\Support\Helpers\FrontendLanguageHelper::class)->translateUrlToCurrentLanguage('Impressionen') }}">
                <img class="w-full" src="/img/x-impressionen.jpg" alt="">
                <span class="py-2 block">{{ app(\Support\Helpers\FrontendLanguageHelper::class)->translateCurrentLanguageName('Impressionen') }}</span>
            </a>
        </div>
        <div>
            <a href="{{ app(\Support\Helpers\FrontendLanguageHelper::class)->translateUrlToCurrentLanguage('Aktuelles') }}">
                <img class="w-full" src="/img/x-aktuelles.jpg" alt="">
                <span class="py-2 block">{{ app(\Support\Helpers\FrontendLanguageHelper::class)->translateCurrentLanguageName('Aktuelles') }}</span>
            </a>
        </div>
    </div>
</div>
