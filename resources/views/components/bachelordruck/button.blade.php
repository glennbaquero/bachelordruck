<button {{ $attributes->merge(['type' => 'button', 'class' => 'py-3 px-12 text-title text-xl']) }}>
    {{ $slot }}
</button>
