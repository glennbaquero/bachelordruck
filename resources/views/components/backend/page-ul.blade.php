@props(['pages','languages'])

<ul class="pl-5 py-3">
    @foreach($pages as $page)
        <li>
            <x-backend.page-item :page="$page" :pages="$page['pages_language']" :languages="$languages" first="{{ $loop->first }}" last="{{ $loop->last }}"></x-backend.page-item>
            @if($page['children'])
                <x-backend.page-ul :pages="$page['children']" :languages="$languages"></x-backend.page-ul>
            @endif
        </li>
    @endforeach
</ul>
