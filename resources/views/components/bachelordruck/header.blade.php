<header x-data="{
        display: false,
        showSidebar: false,
        showBasket: false,

        toggleDisplay() {
            this.display = !this.display;
        },

        toggleSidebar() {
            this.showSidebar = !this.showSidebar;
        },

        toggleShowBasket() {
            this.showBasket = !this.showBasket;
        },

        toggleMobileBasket() {
            this.showBasket = !this.showBasket;
            this.toggleDisplay();
        }
    }"
        class="relative z-50">
    <div class="fixed left-0 right-0 shadow top-0 bg-white bg-opacity-80">
        <div class="py-3 side-padding">
            <div class="flex justify-between items-center py-2 md:justify-start md:space-x-10">
                <div class="w-0 flex-1 flex">
                    <a href="/de" class="inline-flex">
                        <img class="h-10 w-auto sm:h-12 lg:h-16" src="{{ asset('images/logo.png') }}" alt="Logo"/>
                    </a>
                </div>
                <div class="-mr-2 -my-2 md:hidden" x-on:click="toggleDisplay">
                    <button type="button"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
                <div class="hidden md:flex items-center justify-end space-x-4 md:flex-1 lg:w-0">
                    <img class="h-8 w-8" src="{{ asset('images/phone.svg') }}" alt="Phone Logo"/>
                    <a href="tel:+49(0)821-58 10 20" class="font-bold">
                        +49(0)821-58 10 20
                    </a>
                    <span class="font-bold">|</span>
                    <a class="text-xs cursor-pointer" x-on:click="toggleShowBasket">
                        <img class="h-8 w-8" src="{{ asset('images/shopping.svg') }}" alt="Basket"/>
                        <livewire:bachelordruck.basket-counter></livewire:bachelordruck.basket-counter>
                    </a>
                    <span class="font-bold">|</span>
                    <a class="text-xs cursor-pointer"  x-on:click="toggleSidebar">
                        <img class="h-8 w-8" src="{{ asset('images/menu.svg') }}" alt="Menu"/>
                    </a>
                </div>
            </div>
        </div>

        <div class="flex justify-center">
            <livewire:bachelordruck.basket></livewire:bachelordruck.basket>
        </div>

        <div
            x-cloak
            x-show="display"
            x-transition:enter="duration-200 ease-out"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="duration-100 ease-in"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute top-0 inset-x-0 z-10 p-2 transition transform origin-top-right">

            <div class="rounded-lg shadow-lg">
                <div class="rounded-lg shadow-xs bg-white divide-y-2 divide-gray-50">
                    <div class="pt-5 pb-6 px-5 space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <img class="h-8 w-auto sm:h-10" src="{{ asset('images/logo.png') }}" alt="Logo"/>
                            </div>
                            <div class="-mr-2">
                                <button x-on:click="toggleDisplay" type="button"
                                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <nav class="grid row-gap-8">
                                @foreach($mainNavigation as $navigation)
                                    <a  href="{{ $navigation->languageUrl }}" class="mt-1 -m-3 p-3 flex items-center space-x-3 rounded-md hover:bg-brand-primary hover:text-white transition ease-in-out duration-150">
                                        {{ $navigation->title }}
                                    </a>
                                @endforeach

                                <div class="border-t border-brand-secondary mt-3"></div>
                                <a href="tel:+49(0)821-58 10 20"
                                   class="mt-1 -m-3 p-3 flex items-center space-x-3 rounded-md hover:bg-gray-50 transition ease-in-out duration-150">
                                    <img class="w-6 h-6" src="{{ asset('images/phone.svg') }}" alt="Phone Logo"/>
                                    <div>
                                        +49(0)821-58 10 20
                                    </div>
                                </a>
                                <a  x-on:click="toggleMobileBasket"
                                   class="cursor-pointer mt-1 -m-3 p-3 flex items-center space-x-3 rounded-md hover:bg-gray-50 transition ease-in-out duration-150">
                                    <img class="w-6 h-6" src="{{ asset('images/shopping.svg') }}" alt="Basket"/>
                                    <livewire:bachelordruck.basket-counter></livewire:bachelordruck.basket-counter>
                                    <div class="">
                                        Basket
                                    </div>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div
        x-cloak
        x-show="showSidebar"
        x-transition:enter="duration-200 ease-out"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="duration-100 ease-in"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"

        @click.away="showSidebar = false" class="bg-white dark-mode:bg-gray-800 dark-mode:text-gray-200 fixed flex flex-col flex-shrink-0 h-full md:min-h-screen md:w-64 right-0 text-gray-700 w-56 top-[105px] shadow-xl" x-data="{ open: false }">
        <div class="relative">
            <a class="absolute top-0 right-0 text-gray-900 mr-2 mt-1 cursor-pointer" @click="showSidebar = false"><svg class="w-6 h-6 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></a>
        </div>
        <nav :class="{'block': open, 'hidden': !open}" class="py-5 flex-grow md:block px-4 pb-4 md:pb-0 md:overflow-y-auto">
            @foreach($mainNavigation as $navigation)
                <a  href="{{ $navigation->languageUrl }}" class="block focus:bg-gray-200 focus:outline-none focus:shadow-outline focus:text-gray-900 font-semibold hover:bg-brand-primary hover:text-white mt-2 px-4 py-2 rounded-lg text-gray-900">
                    {{ $navigation->title }}
                </a>
            @endforeach
        </nav>
    </div>

</header>
