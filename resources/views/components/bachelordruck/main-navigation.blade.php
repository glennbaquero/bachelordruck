@props(['mainNavigation'])
@foreach($mainNavigation as $navigation)
    <li>
        <a href="{{ $navigation->languageUrl }}"
           class="hover:text-brand">{{ $navigation->title }}</a>
    </li>
@endforeach
