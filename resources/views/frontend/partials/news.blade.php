<div class="xl:container xl:mx-auto px-4">
    @foreach ($news as $item)
        <div class="flex flex-col lg:flex-row w-full rounded p-4 justify-between m-2">
            <div class="w-full lg:w-1/2">
                <a href="{{ route('news.slug', ['slug' => $item->slug, 'language' => $language->languageCode]) }}"><h2 class="text-xl text-gray-500">{{ $item->title }}</h2></a>
                <span class="text-sm">{{ Carbon\Carbon::parse($item->news_date)->format('d.m.Y') }}</span>
                <p class="py-8 pr-4">{{ Illuminate\Support\Str::limit($item->description, 200) }}</p>
                <a
                    href="{{ route('news.slug', ['slug' => $item->slug, 'language' => $language->languageCode]) }}"
                    type="button"
                    class="inline-flex items-center px-4 mb-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    {{ __('pagination.readmore') }}
                </a>
            </div>
            {{ $item->getMedia('image')->first()->img()->attributes(['class' => 'w-full lg:w-1/2']) }}
        </div>
    @endforeach

    {{ $news->links('vendor.pagination.tailwind') }}
</div>
