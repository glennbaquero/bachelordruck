@props(['containers', 'summarize' => false])

@if($containers && count($containers) > 0)
<div class="flex-grow">
    @foreach($containers as $container)
        <x-dynamic-component component="{{  $container->type->getFrontendComponent() }}"
                             :container="$container"
                             :summarize="$summarize"
                             class="{{ ($loop->index % 2 === 0) ? config('cms.container_bg_even') : config('cms.container_bg_odd')}}"/>
    @endforeach
</div>
@endif
