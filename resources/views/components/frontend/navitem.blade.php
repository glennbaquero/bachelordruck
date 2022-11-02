@props(['first' => false, 'last' => false, 'url' => '#', 'children' => [], 'language' => '', 'mobile' => false, 'languageId' => null])

@php
    $classes = \Illuminate\Support\Str::contains(Request::url(), $url) ? 'text-blue-500 underline' : 'hover:text-blue-500';
@endphp
<div class="relative inline-block text-left" x-data="{dropdown:false}" @click.outside="dropdown=false">
    @if($first)
        <li>
            <a
                href="{{ $url }}" {{ $attributes->merge(['class' => "pr-2 xl:pr-4 hover:underline {$classes}"]) }}
                style="text-underline-offset: 5px"
                @if ($children)
                    @click.prevent="show = true"
                @endif
            >
                {{ $slot }}
            </a>
        </li>
    @elseif($last)
        <li>
            <a
                href="{{ $url }}" {{ $attributes->merge(['class' => "pl-2 xl:pl-4 hover:underline {$classes}"]) }}
                style="text-underline-offset: 5px"
                @if ($children)
                    @click.prevent="dropdown = true"
                @endif
            >
                {{ $slot }}
            </a>
        </li>
    @else
        <li>
            <a
                href="{{ $url }}" {{ $attributes->merge(['class' => "px-2 xl:px-4 hover:underline {$classes}"]) }}
                style="text-underline-offset: 5px"
                @if ($children)
                    @click.prevent="dropdown = true"
                @endif
            >
                {{ $slot }}
            </a>
        </li>
    @endif
    @if ($mobile)
        <ul class="flex flex-col divide-y uppercase  text-lg">
            @foreach($children as $index => $child)

                @foreach($child['pages_language'] as $pageLanguage)
                    @if ($pageLanguage['language_id'] === (int) $languageId)
                        <li class="@if($loop->first) border-t  @endif">
                            <a
                                href="/{{ $language }}{{ $pageLanguage['url'] }}"
                                {{ $attributes->merge(['class' => "px-2 xl:px-4 hover:underline ml-5"]) }}
                                style="text-underline-offset: 5px"
                            >
                                {{ $pageLanguage['name'] }}
                            </a>
                        </li>
                    @endif
                @endforeach
            @endforeach
        </ul>
    @else
        <div x-cloak x-show="dropdown" class="origin-top-right absolute right-0 mt-2 w-56 shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
            <div class="py-1" role="none">
                @foreach($children as $index => $child)
                    @foreach($child['pages_language'] as $pageLanguage)
                        @if ($pageLanguage['language_id'] === (int) $languageId)
                            <a
                                href="/{{ $language }}{{ $pageLanguage['url'] }}"
                                class="text-left leading-loose tracking-wide text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100"
                                role="menuitem"
                                tabindex="-1"
                            >
                                {{ $pageLanguage['name'] }}
                            </a>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    @endif
</div>
