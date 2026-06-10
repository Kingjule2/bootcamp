@props(['label' => null, 'name' => '', 'type' => 'text', 'placeholder' => '', 'required' => false])

<div class="form-group">
    @if($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif
    
    @if($type === 'textarea')
        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            placeholder="{{ $placeholder }}"
            @required($required)
            {{ $attributes->merge(['class' => 'form-input']) }}
        ></textarea>
    @else
        <input
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            placeholder="{{ $placeholder }}"
            @required($required)
            {{ $attributes->merge(['class' => 'form-input']) }}
        >
    @endif

    @error($name)
        <div class="form-error">{{ $message }}</div>
    @enderror
</div>
