@props([
'footerNavigation' => []
])

<footer class="side-padding py-12 text-white bg-darkgray z-10">
    <div class="font-josefin_sans grid lg:grid-cols-4 md:grid-cols-2 sm:gap-6 sm:grid-cols-1 xl:grid-cols-4">
        <div>
            <h2 class="mb-6 text-title text-gray-200 uppercase">KONTAKT</h2>
            <ul class="text-gray-200 w-65 text-12pt">
                <li class="mb-4">
                    <a href="https://www.google.com/maps/place/Sbg+Copy+Shop+at+university/@48.3337708,10.8994889,15z/data=!4m2!3m1!1s0x0:0xd168bfc4458bd6a4?sa=X&ved=2ahUKEwjBtP32wu33AhUxzYsBHcJ6BTkQ_BJ6BAhLEAU"
                       target="_blank" class="hover:underline ">
                        SBG CopyShop UNI Salomon-Idler Straße 24F 86159 Augsburg
                    </a>
                </li>
            </ul>
        </div>
        <div class="font-josefin_sans">
            <div class="flex flex-col md:mt-14 text-gray-200">
                <div class="flex">
                    <div class="w-20">Tel.</div>
                    <div>
                        <a href="tel:+49(0)821-58 10 20" class="hover:underline ">+49(0)821-58 10 20</a>
                    </div>
                </div>
                <div class="flex">
                    <div class="w-20">E-mail</div>
                    <div>
                        <a href="email:info@bachelor-druck.de" class="hover:underline">info@bachelor-druck.de</a>
                    </div>
                </div>
                <div class="flex">
                    <div class="w-20"></div>
                    <div class="col-span-4">
                        <a href="email:sbg-copyshop@t-online." class="hover:underline">sbg-copyshop@t-online.de</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="font-josefin_sans lg:mt-0 mt-10">
            <h2 class="font-semibold text-2xl text-gray-200 uppercase">öffnungszeiten</h2>
            <ul class="text-gray-200 mt-6">
                <li class="mb-4">
                    <p class="">Montag bis Freitag von 9 Uhr bis 18 Uhr</p>
                </li>
            </ul>
        </div>
        <div class="flex justify-center lg:justify-end font-josefin_sans lg:mt-0 mt-10">
            <img src="{{ asset('images/footer-image.png')  }}" class="h-auto w-auto object-contain">
        </div>
    </div>
</footer>
<footer class="sm:flex sm:items-center sm:justify-between py-4 pl-12 pr-12 bg-darkestgray  z-10">
    <div
        class="text-xl font-josefin_sans lg:flex lg:flex-row lg:space-x-6 mt-4 sm:flex-col sm:justify-center sm:mt-0 sm:space-x-4 xl:flex xl:flex-row xl:space-x-6">
        @foreach($footerNavigation as $navigation)
            <a href="{{$navigation->languageUrl}}" class="text-gray-200 hover:text-brand-primary">
                {{$navigation->title}}
            </a>
        @endforeach
    </div>
    <span class="text-xl text-gray-500 sm:text-center dark:text-gray-400">
        <a href="https://www.aranes.de" target="_blank">Webdesign by ARANES & Co. KG</a>
    </span>
</footer>
