<?php
/** @var Spatie\MediaLibrary\HasMedia $image */
?>

@if($banner)
    <div>
        <!-- Image and Text Swipe -->
        <div x-data="{ swiper: null }" x-init="
       swiper = new Swiper('.swiper', {
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
            },
       });
    ">
            <div class="bg-center bg-cover relative bachelordruck__banner-section"
                 style="background-image: url('{{ $banner->getImages()->first() }}');">
                <div
                    class="absolute h-36 lg:right-10 p-2 xl:right-10 right-0 xl:w-96 lg:w-96 md:w-96 sm:w-full swiper slider__container">
                    <div class="swiper-pagination slider__pagination"></div>
                    <div class="swiper-wrapper">
                        <div class="p-3 swiper-slide">
                            <p class="font-bold font-josefin_sans lg:text-3xl sm:text-2xl text-white xl:text-3xl xs:text-2xl text-2xl md:text-3xl">
                                ONLINE DRUCKSERVICE</p>
                            <div
                                class="font-josefin_sans lg:text-sm md:text-sm mt-4 slider__body text-right text-white xl:text-sm xs:text-xs slider__body">
                                <p>Ob Bachelorarbeit, Masterarbait order Dissertation.</p>
                                <p>Nutzen Sie unseren Online Service fur lhre Facharbeiten</p>
                                <p>und stellen Sie lhre Arbeit in kurzer Zeit zusammen.</p>
                            </div>
                        </div>
                        <div class="p-3 swiper-slide">
                            <p class="font-bold font-josefin_sans lg:text-3xl sm:text-2xl text-white xl:text-3xl xs:text-2xl text-2xl md:text-3xl">
                                TITLE HERE (2)</p>
                            <div
                                class="font-josefin_sans lg:text-sm md:text-sm mt-4 slider__body text-right text-white xl:text-sm xs:text-xs slider__body">
                                <p>2</p>
                            </div>
                        </div>
                        <div class="p-3 swiper-slide">
                            <p class="font-bold font-josefin_sans lg:text-3xl sm:text-2xl text-white xl:text-3xl xs:text-2xl text-2xl md:text-3xl">
                                TITLE HERE (3)</p>
                            <div
                                class="font-josefin_sans lg:text-sm md:text-sm mt-4 slider__body text-right text-white xl:text-sm xs:text-xs slider__body">
                                <p>3</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endif
