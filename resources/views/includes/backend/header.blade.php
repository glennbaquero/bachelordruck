<nav class="bg-gray-800">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img class="h-8 w-8" src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg"
                         alt="Workflow">
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="/users"
                           class="{{ Route::is('user*') ? 'bg-gray-900' : ''}} text-white hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">{{ __('model.users') }}</a>
                        <a href="/pages"
                           class="{{ Route::is('page*') ? 'bg-gray-900' : ''}} text-white hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                           aria-current="page">{{ __('model.pages') }}</a>
                        <a href="/banners"
                           class="{{ Route::is('banner*') ? 'bg-gray-900' : ''}} text-white hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                           aria-current="page">{{ __('model.banners') }}</a>
                        <a href="/galleries"
                           class="{{ Route::is('gallery*') ? 'bg-gray-900' : ''}} text-white hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                           aria-current="page">{{ __('model.galleries') }}</a>
                        <a href="/news"
                           class="{{ Route::is('news*') ? 'bg-gray-900' : ''}} text-white hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                           aria-current="page">{{ __('model.news') }}</a>
                        <a href="/orders"
                           class="{{ Route::is('order*') ? 'bg-gray-900' : ''}} text-white hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                           aria-current="page">{{ __('model.orders') }}</a>
                        <div x-data="{ openMenu: false }" class="relative z-10">
                            <a href=""
                               @mouseover="openMenu = true"
                               class="{{ Route::is('product*') ? 'bg-gray-900' : ''}} text-white hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">{{ __('model.products') }}
                                <svg
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    class="inline w-6 h-6 -mt-0.5 transition-transform duration-200 transform"
                                    :class="openMenu ? 'rotate-180' : 'rotate-0'"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </a>
                            <div
                                x-cloak
                                x-show="openMenu === true"
                                x-transition:enter="transition ease-in-out duration-300"
                                x-transition:enter-start="opacity-0 transform -scale-y-50"
                                x-transition:leave="transition ease-in-out duration-300"
                                x-transition:leave-start="opacity-100 transform scale-y-100"
                                x-transition:leave-end="opacity-0 transform scale-y-0"
                                class="absolute w-full mt-2 origin-top-right shadow-lg md:min-w-[12rem] w-max"
                                @mouseover="openMenu = true"
                                @mouseleave="openMenu = false"
                                @click.away="openMenu = false"
                            >
                                <div class="flex flex-col gap-y-0.5 shadow mt-3">
                                    <a class="block px-4 py-2 bg-gray-800 text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium"
                                       href="{{ route('product.list') }}">{{ __('List') }}</a>
                                    <a class="block px-4 py-2 bg-gray-800 text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium"
                                       href="{{ route('product_ribbon_color.list') }}">{{ __('Ribbon Colors') }}</a>
                                    <a class="block px-4 py-2 bg-gray-800 text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium"
                                       href="{{ route('product_book_corner_color.list') }}">{{ __('Book Corner Colors') }}</a>
                                    <a class="block px-4 py-2 bg-gray-800 text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium"
                                       href="{{ route('product_cover_foil.list') }}">{{ __('Cover Foils') }}</a>
                                    <a class="block px-4 py-2 bg-gray-800 text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium"
                                       href="{{ route('product_back_cover.list') }}">{{ __('Back Covers') }}</a>
                                    <a class="block px-4 py-2 bg-gray-800 text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium"
                                       href="{{ route('product_cover_imprint_color.list') }}">{{ __('Cover Imprint Colors') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div x-data="{show:false}" class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    <!-- Profile dropdown -->
                    <div class="ml-3 relative">
                        <div>
                            <button @click="show = true" type="button"
                                    class="max-w-xs bg-gray-800 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                <x-value.avatar
                                    :url="auth()->user()->getFirstMediaUrl('avatars')"
                                    :color="auth()->user()->color"
                                    value="{{auth()->user()->initials ?? Support\Helpers\NameHelpers::getInitials(auth()->user()->name)}}">
                                </x-value.avatar>
                            </button>
                        </div>
                        <div
                            @click.outside="show = false"
                            x-cloak
                            x-show="show"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-70"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-10"
                            role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                            <div class="py-1" role="none">
                                <a href="{{ route('home') }}" target="_blank"
                                   class="block px-4 py-2 text-sm text-gray-700" tabindex="-1">
                                    {{__('Visit Site')}}
                                </a>
                            </div>
                            <!-- Active: "bg-gray-100", Not Active: "" -->
                            <div class="py-1" role="none">
                                @foreach( $language->all() as $language)
                                    <a href="{{ route('user.language', ['languageCode' => $language->languageCode]) }}"
                                       class="block px-4 py-2 text-sm text-gray-700 {{ \Support\Helpers\UserLanguageSessionHelper::get() === $language->languageCode  ? 'bg-blue-50' : '' }}"
                                       role="menuitem" tabindex="-1" id="user-menu-item-0">{{ $language->title }}</a>
                                @endforeach
                            </div>
                            <div class="py-1" role="none">
                                <a href="{{ route('user.edit', ['model' => auth()->user()->id])}}"
                                   class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                   id="user-menu-item-0">{{__('Your Profile')}}</a>
                                @if (Route::has('login'))
                                    @auth
                                        <a
                                            href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                            class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                            tabindex="-1"
                                            id="user-menu-item-2"
                                        >
                                            {{__('Sign out')}}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              style="display: none;">
                                            @csrf
                                        </form>
                                    @endauth
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div x-data="{show:false}" class="-mr-2 flex md:hidden">
                <!-- Mobile menu button -->
                <button @click="show = !show;$dispatch('set-show', show)" type="button"
                        class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                        aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!--
                      Heroicon name: outline/menu

                      Menu open: "hidden", Menu closed: "block"
                    -->
                    <svg x-cloak :class="show ? 'hidden' : 'block'" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <!--
                      Heroicon name: outline/x

                      Menu open: "block", Menu closed: "hidden"
                    -->
                    <svg x-cloak :class="show ? 'block':'hidden'" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div x-cloak x-show="show" x-data="{show:false}" @set-show.window="show = $event.detail" class="md:hidden"
         id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <a href="/users"
               class="{{ Route::is('user*') ? 'bg-gray-900' : ''}} text-white hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium"
               aria-current="page">{{ __('model.users') }}</a>
            <a href="/pages"
               class="{{ Route::is('page*') ? 'bg-gray-900' : ''}} text-white hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium"
               aria-current="page">{{ __('model.pages') }}</a>
            <a href="/banners"
               class="{{ Route::is('banner*') ? 'bg-gray-900' : ''}} text-white hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium"
               aria-current="page">{{ __('model.banners') }}</a>
            <a href="/galleries"
               class="{{ Route::is('gallery*') ? 'bg-gray-900' : ''}} text-white hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium"
               aria-current="page">{{ __('model.galleries') }}</a>
            <a href="/news"
               class="{{ Route::is('news*') ? 'bg-gray-900' : ''}} text-white hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium"
               aria-current="page">{{ __('model.news') }}</a>

            <div x-data="{ openMenu: false }" class="relative">
                <div
                   @mouseover="openMenu = true"
                   class="{{ Route::is('product*') ? 'bg-gray-900' : ''}} text-white hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium flex justify-between">
                    <div>
                        {{ __('model.products') }}
                    </div>
                    <svg
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        class="inline w-6 h-6 -mt-0.5 transition-transform duration-200 transform"
                        :class="openMenu ? 'rotate-180' : 'rotate-0'"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>
                <div
                    x-cloak
                    x-show="openMenu === true"
                    x-transition:enter="transition ease-in-out duration-300"
                    x-transition:enter-start="opacity-0 transform"
                    x-transition:leave="transition ease-in-out duration-300"
                    x-transition:leave-start="opacity-100 transform"
                    x-transition:leave-end="opacity-0 transform"
                    @mouseover="openMenu = true"
                    @mouseleave="openMenu = false"
                    @click.away="openMenu = false"
                >
                    <div class="flex flex-col gap-y-0.5 shadow mt-3 pl-4">
                        <a class="block px-4 py-2 bg-gray-800 text-white hover:bg-gray-700 px-3 py-2 rounded-md text-base font-medium"
                           href="{{ route('product.list') }}">{{ __('List') }}</a>
                        <a class="block px-4 py-2 bg-gray-800 text-white hover:bg-gray-700 px-3 py-2 rounded-md text-base font-medium"
                           href="{{ route('product_ribbon_color.list') }}">{{ __('Ribbon Colors') }}</a>
                        <a class="block px-4 py-2 bg-gray-800 text-white hover:bg-gray-700 px-3 py-2 rounded-md text-base font-medium"
                           href="{{ route('product_book_corner_color.list') }}">{{ __('Book Corner Colors') }}</a>
                        <a class="block px-4 py-2 bg-gray-800 text-white hover:bg-gray-700 px-3 py-2 rounded-md text-base font-medium"
                           href="{{ route('product_cover_foil.list') }}">{{ __('Cover Foils') }}</a>
                        <a class="block px-4 py-2 bg-gray-800 text-white hover:bg-gray-700 px-3 py-2 rounded-md text-base font-medium"
                           href="{{ route('product_back_cover.list') }}">{{ __('Back Covers') }}</a>
                        <a class="block px-4 py-2 bg-gray-800 text-white hover:bg-gray-700 px-3 py-2 rounded-md text-base font-medium"
                           href="{{ route('product_back_cover.list') }}">{{ __('Cover Imprint Colors') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-700">
            <div class="flex items-center px-5">
                <div class="flex-shrink-0">
                    <x-value.avatar
                        :url="$user->getFirstMediaUrl('avatars')"
                        :color="$user->color"
                        value="{{$user->initials ?? Support\Helpers\NameHelpers::getInitials($user->name)}}">
                    </x-value.avatar>
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium leading-none text-white">{{ $user->name}}</div>
                    <div class="text-sm font-medium leading-none text-gray-400">{{ $user->email}}</div>
                </div>
            </div>
            <div class="mt-3 px-2 space-y-1">
                @foreach( $language->all() as $language)
                    <a href="{{ route('user.language', ['languageCode' => $language->languageCode]) }}"
                       class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700"
                       role="menuitem" tabindex="-1" id="user-menu-item-0">{{ $language->title }}</a>
                @endforeach
                <a href="{{ route('user.edit', ['model' => auth()->user()->id])}}"
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">{{__('Your Profile')}}</a>

                @if (Route::has('login'))
                    @auth
                        <a
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700"
                            role="menuitem"
                            tabindex="-1"
                            id="user-menu-item-2"
                        >
                            {{__('Sign out')}}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endauth
                @endif
            </div>
        </div>
    </div>
</nav>
