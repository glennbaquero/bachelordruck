@extends('layouts.base')

@section('body')
    <header class="border-b-2 border-black">
        <div class="xl:container xl:mx-auto">
            <div class="flex justify-between m-4 mb-3">
                <x-frontend.logo></x-frontend.logo>
                <div class="block lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="toggleMenu h-12 cursor-pointer" viewBox="0 0 20 20"
                         fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="hidden lg:block">
                    <div class="flex flex-col pl-4 items-end justify-between h-full">
                        <a href="tel:+499454215" class="flex flex-row items-center mb-2">
                            <img src="/img/phoneicon.svg" class="h-8" alt="">
                            <span class="pl-2 text-xl">+49 9454 215</span>
                        </a>

                        <ul class="flex flex-wrap align-bottom border-t border-gray-400 divide-x divide-gray-400 leading-4 uppercase pt-3 text-md xl:text-lg">
                            @foreach(['Orgelbau','Werksverzeichnis','Geschichte','Impressionen','Aktuelles'] as $item)
                                <x-frontend.navitem
                                    first="{{ $loop->first }}"
                                    last="{{ $loop->last }}"
                                >
                                    {{ $item }}
                                </x-frontend.navitem>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="mobileMenu hidden bg-white fixed left-0 top-0 h-screen w-full md:w-1/2 border-r shadow-lg lg:hidden">
        <div class="grid justify-end p-2 border-b">
            <svg xmlns="http://www.w3.org/2000/svg" class="toggleMenu h-10 cursor-pointer" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <ul class="flex flex-col divide-y uppercase  text-lg border-b">
            @foreach(['Orgelbau','Werksverzeichnis','Geschichte','Impressionen','Aktuelles'] as $item)
                <x-frontend.navitem class="py-2 block">{{ $item }}</x-frontend.navitem>
            @endforeach
        </ul>
    </div>

    <div><img src="/img/x-head.jpg" class="w-full" alt=""></div>
    <div class="bg-gray-300 px-4">
        <div
            class="py-8 xl:container xl:mx-auto grid grid-cols-3 lg:grid-cols-5 text-sm md:text-base gap-x-4 text-center uppercase">
            <div>
                <img class="w-full" src="/img/x-orgelbau.jpg" alt="">
                <span class="py-2 block">Orgelbau</span>
            </div>
            <div>
                <img class="w-full" src="/img/x-werkverzeichnis.jpg" alt="">
                <span class="py-2 block">Werkverzeichnis</span>
            </div>
            <div>
                <img class="w-full" src="/img/x-geschichte.jpg" alt="">
                <span class="py-2 block">Geschichte</span>
            </div>
            <div>
                <img class="w-full" src="/img/x-impressionen.jpg" alt="">
                <span class="py-2 block">Impressionen</span>
            </div>
            <div>
                <img class="w-full" src="/img/x-aktuelles.jpg" alt="">
                <span class="py-2 block">Aktuelles</span>
            </div>
        </div>
    </div>

    <x-frontend.section-textcenter class="bg-gray-100">
        <x-slot name="title">
            Lorem ipsum dolor sit amet, consectetuer adipiscing dolor sit amet, consectetuer adipiscing
        </x-slot>
        <p>orem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.
            Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis,
            ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo,
            fringilla vel, aliquet nec, vulputate eget, arc</p>
    </x-frontend.section-textcenter>

    <x-frontend.section-imagetext class="bg-gray-300" imgurl="/img/x-contentimg.jpg" imagealignment="right">
        <x-slot name="title">
            Lorem ipsum dolor sit amet, consectetuer adipiscing dolor sit amet, consectetuer
            adipiscing
        </x-slot>
        <p>orem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean
            massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec
            quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.
            Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arc</p>
    </x-frontend.section-imagetext>

    {{--    style="background-image: url('/img/x-footer.jpg')"--}}
    <footer class="bg-gray-400 text-white">
        <div class="xl:container xl:mx-auto flex flex-col md:flex-row">
            <div class="md:w-1/2 py-8 px-4">
                <h4 class="font-bold mb-2">KONTAKT</h4>

                <div class="flex flex-row">
                    <div class="w-1/2">
                        <div>Thomas Jann Orgelbau GmbH</div>
                        <div>Allkofen 208</div>
                        <div>84082 Laberweinting</div>
                        <div>Deutschland</div>
                    </div>
                    <div class="w-1/2">
                        <div>Tel. <a href="tel: +499454215">+49 9454 215</a></div>
                        <div>E-Mail <a href="mailto: info@jannorgelbau.de">info@jannorgelbau.de</a></div>
                    </div>
                </div>

            </div>
            <div class="md:w-1/2">
                <div class="bg-gray-600 h-full md:w-80 p-4 md:p-8 text-white">
                    <div class="uppercase">Sie haben Fragen?</div>
                    <div class="my-2">Dann schicken Sie uns eine Nachricht. Wir helfen sehr gerne weiter.</div>
                    <a class="mt-6 bg-gray-200 text-black uppercase w-full block text-center p-2" href="#">Anfrage
                        schicken</a>
                </div>

            </div>
        </div>
    </footer>

    <nav class="flex flex-col md:flex-row justify-between xl:container xl:mx-auto py-4 px-4">
        <ul class="flex flex-row flex-wrap divide-x divide-gray-400">
            @foreach(['Impressum','Datenschutz'] as $item)
                <x-frontend.navitem
                    first="{{ $loop->first }}"
                    last="{{ $loop->last }}"
                >
                    {{ $item }}
                </x-frontend.navitem>
            @endforeach
        </ul>

        <a href="https://www.aranes.de" class="pt-6 md:pt-0" target="_blank">&copy; Webdesign by ARANES</a>
    </nav>

    <script>
        const toggleMenu = document.querySelectorAll('.toggleMenu');
        const mobileMenu = document.querySelector('.mobileMenu');

        for (let btn of toggleMenu) {
            btn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    </script>

@endsection
