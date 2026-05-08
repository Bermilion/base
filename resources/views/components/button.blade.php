@php
    // Автоопределение из атрибутов
    $iconTrailing = $attributes->get('icon:trailing');
    $icon = $iconTrailing ?? ($icon ?? $attributes->get('icon'));
    $loading = $loading ?? $resolveAutoLoading($attributes->getAttributes());

    // Определяем квадратную форму: если есть $text или $slot не пустой — не квадратная
    $hasSlotContent = $slot && !$slot->isEmpty();
    $hasTextContent = filled($text);
    $square = $square && !$hasSlotContent && !$hasTextContent;

    // Позиция иконки: trailing справа, обычная иконка слева
    $iconPosition = filled($iconTrailing) ? 'right' : 'left';

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
    <a {{ $attributes->merge(['class' => $classes($square)]) }}>
        @if($icon && $iconPosition === 'left')
            <x-chunker::icon name="{{ $icon }}" size="{{ $sizeIcon }}" />
        @endif

        {{ $slot }}
        @if((empty($slot) || $slot->isEmpty()) && filled($text))
			<span class="button__text">{{ $text }}</span>
        @endif

        @if($icon && $iconPosition === 'right')
            <x-chunker::icon name="{{ $icon }}" size="{{ $sizeIcon }}" />
        @endif
    </a>
@else
    <button type="{{ $type ?? 'button' }}" {{ $attributes->merge(['class' => $classes($square)]) }}>
        @if($icon && $iconPosition === 'left')
            <x-chunker::icon name="{{ $icon }}" size="{{ $sizeIcon }}" />
        @endif

        {{ $slot }}
        @if((empty($slot) || $slot->isEmpty()) && filled($text))
			<span class="button__text">{{ $text }}</span>
        @endif

        @if($icon && $iconPosition === 'right')
            <x-chunker::icon name="{{ $icon }}" size="{{ $sizeIcon }}" />
        @endif

        @if($loading)
            <x-chunker::icon name="spinner" size="{{ $sizeIcon }}" class="animate-spin" />
        @endif
    </button>
@endif
