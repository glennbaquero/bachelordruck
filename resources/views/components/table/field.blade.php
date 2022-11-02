@props([
'type' => 'value.text',
'value' => '',
'label' => '',
'force' => false,
'enum' => '',
'options' => [],
'url' => '',
'color' => '',
'short' => false,
])

<x-dynamic-component
    :component="$type"
    :value="$value"
    :label="$label"
    :force="$force"
    :enum="$enum"
    :options="$options"
    :key="$attributes->get('key')"
    :color="$color"
    :short="$short"
></x-dynamic-component>

