@php
    $class = 'hover:bg-'.$attributes->get('color').'-400 py-1 px-2 border-b-2 border-'.$attributes->get('color').'-700 hover:border-'.$attributes->get('color').'-500 rounded';
@endphp

<x-button :attributes="$attributes" :class="$class"/>
