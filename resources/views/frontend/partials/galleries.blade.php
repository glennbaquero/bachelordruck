<div class="xl:container xl:mx-auto px-4 pb-8">
<div class="bg-white">
    <h1 class="text-3xl pt-16">{{ __('page.galleries') }}</h1>
    <div class="w-1/4 mt-6 pb-8 @if (__('page.galleries')) border-t border-solid border-black @endif"></div>

            <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 gap-x-6 lg:grid-cols-3 xl:gap-x-8 xl:grid-cols-4 pb-8">
                @foreach ($galleries as $gallery)
                    <a href="{{ route('gallery.detail', ['gallery' => $gallery->slug, 'language' => $language->languageCode]) }}" class="group">
                        <div class="w-full aspect-w-1 aspect-h-1 rounded-lg overflow-hidden sm:aspect-w-2 sm:aspect-h-3">
                            {{ $gallery->getMedia('image')->first()->img()->attributes(['class' => 'w-full h-full object-center object-cover group-hover:opacity-75', 'alt' => '']) }}
                        </div>
                        <div class="mt-4 flex items-center justify-between text-xl font-medium text-gray-900">
                            <h3>{{ $gallery->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
            {{ $galleries->links('vendor.pagination.tailwind') }}
    </div>
