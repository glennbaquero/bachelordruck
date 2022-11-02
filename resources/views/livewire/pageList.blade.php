<div>
    <x-backend.button
        sm
        color="blue"
        icon="document-add"
        href="{{ route('page.create') }}"
        label="{{ __('page.create_page') }}">
    </x-backend.button>

    <ul class="mt-4 w-1/2">
        @foreach($pages as $page)
            <li>
                <span
                    class="font-bold">{{ collect($page['pages_language'])->firstWhere('language_id',1)['name'] }}</span>
                <x-backend.page-ul :pages="$page['children']" :languages="$languages"></x-backend.page-ul>
            </li>
        @endforeach
    </ul>

</div>
