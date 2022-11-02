<?php
/** @var Spatie\MediaLibrary\HasMedia $image */
?>

@props([
'images' => [],
'imageSourceSets' => [],
'hideBullet' => false,
'bulletClass' => '',
'bulletActiveClass' => '',

'thumbnails' => false,

'maxHeightClass' => '',

'imageClass' => 'sm:h-auto h-72',

'fullscreen' => false,

'buttonClass' => 'bg-transparent flex justify-center items-center focus:outline-none',

'iconPrevPositionClass' => 'left-4 sm:left-side',
'iconNextPositionClass' => 'right-4 sm:right-side',

'iconPrev',
'iconNext',
])

<div x-cloak x-data="{ swiper: null }"
     x-init="

     @if($thumbnails)
         thumbsSwiper = new Swiper($refs.thumbs, {
            preloadImages: false,
            // Enable lazy loading
            lazy: {
                enabled: true,
                loadPrevNext: true,
            },

            loop: true,
            spaceBetween: 14,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
          });
@endif

         swiper = new Swiper($refs.container, {
            preloadImages: false,
            // Enable lazy loading
            lazy: {
                enabled: true,
                loadPrevNext: true,
            },

            loop: true,
            slidesPerView: 1,
            autoplay: {
              delay: 2500,
              disableOnInteraction: false,
            },

            navigation: {
              nextEl: '.swiper-button-next',
              prevEl: '.swiper-button-prev-cu',
            },

            pagination: {
              el: '.swiper-pagination',
              type: 'bullets',
              clickable: true,
@if(!$hideBullet && $bulletActiveClass) bulletActiveClass: '{{$bulletActiveClass}}', @endif
     @if(!$hideBullet && $bulletClass) bulletClass: '{{$bulletClass}}', @endif

     @if ($hideBullet)
         bulletActiveClass: 'hidden',
         bulletClass: 'hidden',
@endif
         },

@if($thumbnails)
         thumbs: {
            swiper: thumbsSwiper,
            multipleActiveThumbs: false,
         }
@endif
         });

@if($fullscreen)
         images = new Viewer(document.getElementById('swiper-images'));
@endif
         "
>
    <div class="w-full mx-auto flex {{ $maxHeightClass }}">
        <div class="swiper" x-ref="container">
            <div class="absolute inset-y-0 flex items-center z-20 {{ $iconPrevPositionClass }}">
                <button
                    @click="swiper.slidePrev()"
                    @class([$buttonClass => isset($iconPrev)])
                @if(isset($iconPrev))
                    {{$iconPrev->attributes->class([$buttonClass])}}
                    @endif
                >
                    @if(! isset($iconPrev) || $iconPrev->isEmpty())
                        <svg class="w-8 h-8 stroke-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 19l-7-7 7-7"></path>
                        </svg>
                    @else
                        {{$iconPrev}}
                    @endif
                </button>
            </div>

            <!-- Additional required wrapper -->
            <div id="swiper-images" class="swiper-wrapper">
                @foreach($images as $key => $image)
                    <div @class([
                        'swiper-slide flex justify-center items-center',
                        'cursor-pointer' => $fullscreen,
                    ])">
                    <img class="object-cover swiper-lazy min-h-[1px] min-w-[1px] {{$imageClass}}"
                         src="{{ $image }}"
                         @if(count($imageSourceSets)) srcset="{{ $imageSourceSets[$key] }}" @endif
                         alt=""
                         @click="images.show()">
                    <div class="swiper-lazy-preloader"><x-spinner class="h-5 w-5 text-brand"></x-spinner></div>
            </div>
            @endforeach
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination space-x-2">
        </div>

        <!-- If we need navigation buttons -->

        <div class="swiper-button-prev-custom">

        </div>
        <div class="swiper-button-next"></div>

        <!-- If we need scrollbar -->
        <div class="swiper-scrollbar"></div>

        <div class="absolute inset-y-0 flex items-center z-20 {{ $iconNextPositionClass }}">
            <button
                @click="swiper.slideNext()"
                @class([$buttonClass => isset($iconNext)])
            @if(isset($iconNext))
                {{$iconNext->attributes->class([$buttonClass])}}
                @endif
            >
                @if(! isset($iconNext) || $iconNext->isEmpty())
                    <svg class="w-8 h-8 stroke-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5l7 7-7 7"></path>
                    </svg>
                @else
                    {{$iconNext}}
                @endif
            </button>
        </div>
    </div>
</div>

@if($thumbnails)
    <!-- Thumbslider -->
    <div class="mt-3 overflow-x-hidden">
        <div class="thumbs-swiper" x-ref="thumbs">
            <div class="swiper-wrapper">
                @foreach($images as $key => $image)
                    <div class="swiper-slide flex justify-center items-center cursor-pointer">
                        <img class="object-cover cursor-pointer swiper-lazy"
                             src="{{ $image }}"
                             @if(count($imageSourceSets)) srcset="{{ $imageSourceSets[$key] }}" @endif
                             alt="">
                        <div class="swiper-lazy-preloader my-auto"><x-spinner class="h-5 w-5 text-brand"></x-spinner></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    </div>

    @push('styles')
        <style>
            .thumbs-swiper .swiper-slide {
                width: 25%;
                height: 100%;
                opacity: 0.7;
            }

            .thumbs-swiper .swiper-slide-thumb-active {
                opacity: 1;
            }
        </style>
    @endpush
