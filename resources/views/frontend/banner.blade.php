@extends('layouts.page')
@section('content')
    <div x-data="{
    banner: null,
    page: {{ $page }},
    fetchBanner() {
        axios.get(`/api/banner?filter[language_id]=1&filter[page_id]=${this.page}`)
        .then((response) => {
            this.banner = response.data.data
        })
        .catch((error) => {
            console.log(error)
        })
    }
}"
         x-init="function () {
        this.fetchBanner()
    }"
         class="p-6"
    >
        <template x-if="banner">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Banner Information</h3>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Transmission</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" x-text="banner[0].transmission ? 'True':'False'"></dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Title</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" x-text="banner[0].title"></dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" x-html="banner[0].description"></dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Url</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" x-tet="banner[0].url"></dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Link Text</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" x-text="banner[0].link_text"></dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" x-text="banner[0].status"></dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Image</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <div
                                    class="w-full min-h-80 aspect-w-1 aspect-h-1 rounded-md overflow-hidden group-hover:opacity-75 lg:h-80 lg:aspect-none"
                                    x-html="banner[0].image.image_html"
                                >
                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </template>
    </div>
@endsection
