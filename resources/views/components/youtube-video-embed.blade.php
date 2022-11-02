@props(['youtubeId', 'portrait' => false])

<div {{ $attributes->class(['xl:container xl:mx-auto xl:px-32']) }}>
    <div @class([
            'aspect-w-16 aspect-h-9' => ! $portrait,
            'aspect-w-9 aspect-h-16' => $portrait,
         ])>
        <iframe src="https://www.youtube-nocookie.com/embed/{{$youtubeId}}" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
    </div>
</div>
