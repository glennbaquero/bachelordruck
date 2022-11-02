@extends('layouts.bachelordruck.page')
@section('content')
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
        <div class="bg-center bg-cover relative bachelordruck__banner-section"  style="background-image: url('{{ asset('images/banner-image.png') }}');" >
        <div class="absolute h-36 lg:right-12 p-2 xl:right-12 right-0 xl:w-96 lg:w-96 md:w-96 sm:w-full swiper slider__container" >
                <div class="swiper-pagination slider__pagination" ></div>
                <div class="swiper-wrapper">
                    <div class="p-3 swiper-slide">
                        <p class="font-bold font-josefin_sans lg:text-3xl sm:text-2xl text-white xl:text-3xl xs:text-2xl text-2xl md:text-3xl">ONLINE DRUCKSERVICE</p>
                        <div class="font-josefin_sans lg:text-sm md:text-sm mt-4 sm:text-xs text-right text-white text-xs xl:text-sm xs:text-xs">
                            <p>Ob Bachelorarbeit, Masterarbait order Dissertation.</p>
                            <p>Nutzen Sie unseren Online Service fur lhre Facharbeiten</p>
                            <p>und stellen Sie lhre Arbeit in kurzer Zeit zusammen.</p>
                        </div>
                    </div>
                    <div class="p-3 swiper-slide">
                        <p class="font-bold font-josefin_sans lg:text-3xl sm:text-2xl text-white xl:text-3xl xs:text-2xl text-2xl md:text-3xl">TITLE HERE (2)</p>
                        <div class="font-josefin_sans lg:text-sm md:text-sm mt-4 sm:text-xs text-right text-white text-xs xl:text-sm xs:text-xs">
                            <p>2</p>
                        </div>
                    </div>
                    <div class="p-3 swiper-slide">
                        <p class="font-bold font-josefin_sans lg:text-3xl sm:text-2xl text-white xl:text-3xl xs:text-2xl text-2xl md:text-3xl">TITLE HERE (3)</p>
                        <div class="font-josefin_sans lg:text-sm md:text-sm mt-4 sm:text-xs text-right text-white text-xs xl:text-sm xs:text-xs">
                            <p>3</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="relative bg-gray-100">
            <div class="font-josefin_sans pt-5 text-center">
                <h2 class="mt-3 mx-auto text-2xl w-11/12 font-bold">FACHARBEIT DRUCKEN & BINDEN LASSEN</h2>
                <p class="mx-auto text-sm mt-4 custom__width-67__percent" >Lorem ipsum dolor sit amet consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nasccetur ridiculus.</p>
            </div>

            <div class="gap-4 grid lg:grid-cols-4 p-6 sm:grid-cols-none xl:grid-cols-4 md:grid-cols-2">
                <div class="col-span-1">
                    <div class="grid grid-cols-4">
                        <div class="col-span-2">
                            <img src="{{ asset('images/books/book1.png') }}">
                        </div>
                        <div class="col-span-2 font-josefin_sans relative">
                            <div class="lg:h-5/6 sm:h-full xl:h-5/6 md:h-auto">
                                <p class="font-bold mb-1">Premium Hardcover inkl. Pradgeruck</p>
                                <p class="text-sm">ber 80- und 100g Papier bis 540 Blatt moglich, ber 120g Papier bis 280 Blatt moglich</p>
                                <p class="text-right font-bold">ab 28€</p>
                            </div>
                            <div class="absolute w-full">
                                <button class="bg-sky-500 font-bold p-1 text-white w-full">Auswählen</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-1">
                    <div class="grid grid-cols-4">
                        <div class="col-span-2">
                            <img src="{{ asset('images/books/book2.png') }}">
                        </div>
                        <div class="col-span-2 font-josefin_sans relative">
                            <div class="lg:h-5/6 sm:h-full xl:h-5/6 md:h-auto">
                                <p class="font-bold mb-1">Premium Hardcover inkl. Pradgeruck</p>
                                <p class="text-sm">ber 80- und 100g Papier bis 540 Blatt moglich, ber 120g Papier bis 280 Blatt moglich</p>
                                <p class="text-right font-bold">ab 28€</p>
                            </div>
                            <div class="absolute w-full">
                                <button class="bg-sky-500 font-bold p-1 text-white w-full">Auswählen</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-1">
                    <div class="grid grid-cols-4">
                        <div class="col-span-2">
                            <img src="{{ asset('images/books/book3.png') }}">
                        </div>
                        <div class="col-span-2 font-josefin_sans relative">
                            <div class="lg:h-5/6 sm:h-full xl:h-5/6 md:h-auto">
                                <p class="font-bold mb-1">Premium Hardcover inkl. Pradgeruck</p>
                                <p class="text-sm">ber 80- und 100g Papier bis 540 Blatt moglich, ber 120g Papier bis 280 Blatt moglich</p>
                                <p class="text-right font-bold">ab 28€</p>
                            </div>
                            <div class="absolute w-full">
                                <button class="bg-sky-500 font-bold p-1 text-white w-full">Auswählen</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-1">
                    <div class="grid grid-cols-4">
                        <div class="col-span-2">
                            <img src="{{ asset('images/books/book4.png') }}">
                        </div>
                        <div class="col-span-2 font-josefin_sans relative">
                            <div class="lg:h-5/6 sm:h-full xl:h-5/6 md:h-auto">
                                <p class="font-bold mb-1">Premium Hardcover inkl. Pradgeruck</p>
                                <p class="text-sm">bis 500 Setten moglich</p>
                                <p class="text-right font-bold">ab 28€</p>
                            </div>
                            <div class="absolute w-full">
                                <button class="bg-sky-500 font-bold p-1 text-white w-full">Auswählen</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-1">
                    <div class="grid grid-cols-4">
                        <div class="col-span-2">
                            <img src="{{ asset('images/books/book5.png') }}">
                        </div>
                        <div class="col-span-2 font-josefin_sans relative">
                            <div class="lg:h-5/6 sm:h-full xl:h-5/6 md:h-auto">
                                <p class="font-bold mb-1">Premium Hardcover inkl. Pradgeruck</p>
                                <p class="text-sm">bis 320 Setten moglich</p>
                                <p class="text-right font-bold">ab 28€</p>
                            </div>
                            <div class="absolute w-full">
                                <button class="bg-sky-500 font-bold p-1 text-white w-full">Auswählen</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-1">
                    <div class="grid grid-cols-4">
                        <div class="col-span-2">
                            <img src="{{ asset('images/books/book6.png') }}">
                        </div>
                        <div class="col-span-2 font-josefin_sans relative">
                            <div class="lg:h-5/6 sm:h-full xl:h-5/6 md:h-auto md:h-auto">
                                <p class="font-bold mb-1">Premium Hardcover inkl. Pradgeruck</p>
                                <p class="text-sm">bis 340 Setten moglich</p>
                                <p class="text-right font-bold">ab 28€</p>
                            </div>
                            <div class="absolute w-full">
                                <button class="bg-sky-500 font-bold p-1 text-white w-full">Auswählen</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-1">
                    <div class="grid grid-cols-4">
                        <div class="col-span-2">
                            <img src="{{ asset('images/books/book7.png') }}">
                        </div>
                        <div class="col-span-2 font-josefin_sans relative">
                            <div class="lg:h-5/6 sm:h-full xl:h-5/6 md:h-auto">
                                <p class="font-bold mb-1">Premium Hardcover inkl. Pradgeruck</p>
                                <p class="text-sm">ab 340 Setten & Dauer 24 Siunden</p>
                                <p class="text-right font-bold">ab 28€</p>
                            </div>
                            <div class="absolute w-full">
                                <button class="bg-sky-500 font-bold p-1 text-white w-full">Auswählen</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative">
            <div class="grid xl:grid-cols-2 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-none gap-5">
                <div class="col-span-1 lg:p-12 md:p-8 p-6 sm:p-6 xl:p-12">
                    <img src="{{ asset('images/cntimg1.png')  }}" class="h-full">
                </div>
                <div class="col-span-1 lg:p-12 md:p-8 p-6 sm:p-6 xl:p-12">
                    <div class="h-full p-6 bg-brand-secondary">
                        <p class="mx-auto font-josefin_sans font-bold text-2xl text-center uppercase">ihr copyshop fur professionelle druck und bindungen an der uni augsburg</p>
                        <p class="mx-auto font-josefin_sans text-center mt-6">Lorem ipsum dolor sit amet consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nasccetur ridiculus.</p>
                        <p class="mx-auto font-josefin_sans text-center mt-6">Done pede justo, fringilla vel, alique nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula porttitor eu, consequat vitae.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
