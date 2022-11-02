<div x-data="{
        display: false,

        toggleDisplay() {
            this.display = !this.display;
        }
    }"
    class="relative">
    <div class="fixed top-0 left-0 right-0 shadow" style="background: rgba(255,255,255, 0.9);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex justify-between items-center py-2 md:justify-start md:space-x-10">
                <div class="w-0 flex-1 flex">
                    <a href="#" class="inline-flex">
                        <img class="h-8 w-auto sm:h-10" src="{{ asset('images/logo.png') }}" alt="Logo" />
                    </a>
                </div>
                <div class="-mr-2 -my-2 md:hidden" x-on:click="toggleDisplay">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
                <div class="hidden md:flex items-center justify-end space-x-2 md:flex-1 lg:w-0">
                    <img class="w-6 h-6" src="{{ asset('images/phone.svg') }}" alt="Phone Logo" />
                    <a href="tel:+49(0)821-58 10 20" class="text-xs font-josefin_sans font-bold">
                        +49(0)821-58 10 20
                    </a>
                    <span class="text-xs">|</span>
                    <a href="#" class="text-xs">
                        <img class="w-6 h-6" src="{{ asset('images/shopping.svg') }}" alt="Cart" />
                    </a>
                    <span class="text-xs">|</span>
                    <a href="#" class="text-xs">
                        <img class="w-6 h-6" src="{{ asset('images/menu.svg') }}" alt="Menu" />
                    </a>
                </div>
            </div>
        </div>

        <div
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
                                <img class="h-8 w-auto sm:h-10" src="{{ asset('images/logo.png') }}" alt="Logo" />
                            </div>
                            <div class="-mr-2">
                                <button x-on:click="toggleDisplay" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <nav class="grid row-gap-8">
                                <a href="tel:+49(0)821-58 10 20" class="mt-1 -m-3 p-3 flex items-center space-x-3 rounded-md hover:bg-gray-50 transition ease-in-out duration-150">
                                    <img class="w-6 h-6" src="{{ asset('images/phone.svg') }}" alt="Phone Logo" />
                                    <div class="text-xs">
                                        +49(0)821-58 10 20
                                    </div>
                                </a>
                                <a href="#" class="mt-1 -m-3 p-3 flex items-center space-x-3 rounded-md hover:bg-gray-50 transition ease-in-out duration-150">
                                    <img class="w-6 h-6" src="{{ asset('images/shopping.svg') }}" alt="Phone Logo" />
                                    <div class="text-xs">
                                        Cart
                                    </div>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
