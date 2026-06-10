@props(['id', 'show' => false, 'title' => '', 'maxWidth' => '560px'])

<div
    x-data="{ show: @entangle($show) }"
    x-show="show"
    x-on:keydown.escape.window="show = false"
    class="modal-overlay"
    style="display: none;"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <div 
        class="modal-content" 
        style="max-width: {{ $maxWidth }};" 
        x-show="show"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
    >
        <div class="modal-header">
            <h3 style="font-size: 1rem; font-weight: 700; margin: 0;">{{ $title }}</h3>
            <button type="button" @click="show = false" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: var(--color-text-muted);">✕</button>
        </div>
        <div class="modal-body">
            {{ $slot }}
        </div>
        @if(isset($footer))
            <div class="modal-footer">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
