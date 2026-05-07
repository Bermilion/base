@php
    // Автоопределение из атрибутов
    $iconTrailing = $attributes->get('icon:trailing');
    $icon = $iconTrailing ?? ($icon ?? $attributes->get('icon'));
    $iconPosition = $iconTrailing ? 'right' : ($square ? 'right' : 'left');
    $loading = $loading ?? $resolveAutoLoading($attributes->getAttributes());
    $square = $square ?? $resolveSquareForm($slot);

    // Удаляем служебные атрибуты из рендера
    $attributes = $attributes->except(['icon:trailing']);

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
        @if($icon && $iconPosition === 'left')
            <x-chunker::icon name="{{ $icon }}" variant="{{ $iconVariant }}" size="{{ $sizeIcon }}" />
        @endif

        {{ $slot }}

        @if($icon && $iconPosition === 'right')
            <x-chunker::icon name="{{ $icon }}" variant="{{ $iconVariant }}" size="{{ $sizeIcon }}" />
        @endif
    </a>
@else
    <button type="{{ $type ?? 'button' }}" {{ $attributes->merge(['class' => $classes()]) }}>
        @if($icon && $iconPosition === 'left')
            <x-chunker::icon name="{{ $icon }}" variant="{{ $iconVariant }}" size="{{ $sizeIcon }}" />
        @endif

        {{ $slot }}

        @if($icon && $iconPosition === 'right')
            <x-chunker::icon name="{{ $icon }}" variant="{{ $iconVariant }}" size="{{ $sizeIcon }}" />
        @endif

        @if($loading)
            <x-chunker::icon name="spinner" variant="micro" class="animate-spin" />
        @endif
    </button>
@endif
