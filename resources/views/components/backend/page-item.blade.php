@props(['languages','pages', 'page','first'=>'', 'last'=>''])

<div class="flex flex-row hover:bg-blue-100">
    @foreach($languages as $language)
        <div class="w-1/4 flex flex-row items-center">
            <span>{{ $language->code }}:&nbsp; </span>
            @if (empty(collect($pages)->firstWhere('language_id',$language->id)))
                <a href="{{ route('page.create',['language_id'=>$language->id,'page_id'=>$page['id']]) }}">
                    <svg class="w-4 inline-block hover:text-blue-700 cursor-pointer" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </a>
            @else
                <a class="hover:text-blue-700" href="{{ route('page.containers',['pageLanguage'=>collect($pages)->firstWhere('language_id',$language->id)['id']]) }}">{{ collect($pages)->firstWhere('language_id',$language->id)['name'] }}</a>
                <a class="hover:text-blue-700 ml-2" href="{{ route('page.edit',['model'=>collect($pages)->firstWhere('language_id',$language->id)['id']]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </a>
            @endif
        </div>
    @endforeach
    <div class="w-6 text-xl hover:text-blue-700 cursor-pointer">
        @if(!$first)
            <span class="cursor-pointer" wire:click="up({{ $page['id'] }})">&uarr;</span>
        @endif
    </div>
    <div class="w-6 text-xl hover:text-blue-700 cursor-pointer">
        @if(!$last)
            <span class="cursor-pointer" wire:click="down({{ $page['id'] }})">&darr;</span>
        @endif
    </div>
    <div class="ml-4 text-xl hover:text-blue-700 cursor-pointer" wire:click="delete({{ $page['id'] }})">&#9587;</div>
</div>
