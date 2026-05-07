@php
    // Автоопределение из атрибутов
    $icon = $icon ?? $attributes->get('icon');
    $loading = $loading ?? $resolveAutoLoading($attributes->getAttributes());
    $square = $square ?? $resolveSquareForm($slot);

    // Livewire интеграция
    if ($loading && isset($attributes['wire:click'])) {
        $method = $attributes->get('wire:click');
        $attributes = $attributes->merge([
            'wire:loading.attr' => 'data-loading',
            'wire:target' => $method,
        ]);
    }
@endphp

@if (isset($attributes['href']))
    <a {{ $attributes->merge(['class' => $classes()]) }}>
        @if($icon && !$square)
            <x-chunker::icon name="{{ $icon }}" variant="{{ $iconVariant }}" size="{{ $sizeIcon }}" />
        @endif

        {{ $slot }}

        @if($icon && $square)
            <x-chunker::icon name="{{ $icon }}" variant="{{ $iconVariant }}" size="{{ $sizeIcon }}" />
        @endif
    </a>
@else
    <button type="{{ $type ?? 'button' }}" {{ $attributes->merge(['class' => $classes()]) }}>
        @if($icon && !$square)
            <x-chunker::icon name="{{ $icon }}" variant="{{ $iconVariant }}" size="{{ $sizeIcon }}" />
        @endif

        {{ $slot }}

        @if($icon && $square)
            <x-chunker::icon name="{{ $icon }}" variant="{{ $iconVariant }}" size="{{ $sizeIcon }}" />
        @endif

        @if($loading)
            <x-chunker::icon name="spinner" variant="micro" class="animate-spin" />
        @endif
    </button>
@endif
