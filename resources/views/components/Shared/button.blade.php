@props(['type' => 'button', 'variant' => 'primary', 'disabled' => false])

<button
    type="{{ $type }}"
    @disabled($disabled)
    {{ $attributes->merge(['class' => 'btn btn-' . $variant]) }}
>
    {{ $slot }}
</button>
