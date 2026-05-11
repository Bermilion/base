@props([
    'variant' => 'primary',
    'color' => 'accent',
    'size' => 'md',
    'sizeScale' => null,
    'sizeFont' => null,
    'sizeIcon' => null,
    'icon' => null,
    'loading' => false,
    'square' => null,
    'weight' => 'regular',
    'text' => null,
    'active' => false,
])

@php
    use Chunker2i\Base\Core\ClassBuilder;
    use Chunker2i\Base\Traits\ComponentResolversTrait;

    $resolver = new class {
        use ComponentResolversTrait;
    };

    $sizeScale = $sizeScale ?? $size;
    $sizeFont = $sizeFont ?? $size;
    $sizeIcon = $sizeIcon ?? $size;

    $iconTrailing = $attributes->get('icon:trailing');
    $icon = $iconTrailing ?? ($icon ?? $attributes->get('icon'));
    $loading = $loading ?: $resolver->resolveAutoLoading($attributes->getAttributes());

    $hasSlotContent = $slot && !$slot->isEmpty();
    $hasTextContent = filled($text);
    $iconPosition = filled($iconTrailing) ? 'right' : 'left';

    $attributes = $attributes->except(['icon:trailing']);

    if ($loading && isset($attributes['wire:click'])) {
        $method = $attributes->get('wire:click');
        $attributes = $attributes->merge([
            'wire:loading.attr' => 'data-loading',
            'wire:target' => $method,
        ]);
    }

    $isSquare = $square === null
        ? (!$hasSlotContent && !$hasTextContent)
        : $square;

    $builder = app(ClassBuilder::class);
    $builder->add('button')
        ->addIf($isSquare, 'spacing_square')
        ->add("button_{$variant}");

    if ($color !== 'accent' && $variant !== 'white') {
        $builder->add("button_{$variant}-{$color}");
    }

    $builder->addMatch($sizeScale, [
        'none' => 'spacing_none',
        'sm' => 'spacing_sm',
        'md' => 'spacing',
        'lg' => 'spacing_lg',
    ]);

    if (!$isSquare) {
        $builder->addMatch($sizeFont, [
            'sm' => 'text_sm',
            'md' => 'text',
            'lg' => 'text_lg',
        ]);
    }

    $class = $builder
        ->addMatch($weight, [
            'regular' => 'weight',
            'medium' => 'weight_medium',
            'semibold' => 'weight_semibold',
            'bold' => 'weight_bold',
        ])
        ->addIf($loading, 'button_loading')
        ->addIf($active, $color !== 'accent' && $variant !== 'white'
            ? "button_{$variant}-{$color}-active"
            : "button_{$variant}-active")
        ->toString();
@endphp

@if ($active)
    <div {{ $attributes->merge(['class' => $class]) }}>
        @if($icon && $iconPosition === 'left')
            <x-utils::icon name="{{ $icon }}" size="{{ $sizeIcon }}" />
        @endif

        {{ $slot }}
        @if((empty($slot) || $slot->isEmpty()) && filled($text))
            <span class="button__text">{{ $text }}</span>
        @endif

        @if($icon && $iconPosition === 'right')
            <x-utils::icon name="{{ $icon }}" size="{{ $sizeIcon }}" />
        @endif
    </div>
@elseif (isset($attributes['href']))
    <a {{ $attributes->merge(['class' => $class]) }}>
        @if($icon && $iconPosition === 'left')
            <x-utils::icon name="{{ $icon }}" size="{{ $sizeIcon }}" />
        @endif

        {{ $slot }}
        @if((empty($slot) || $slot->isEmpty()) && filled($text))
            <span class="button__text">{{ $text }}</span>
        @endif

        @if($icon && $iconPosition === 'right')
            <x-utils::icon name="{{ $icon }}" size="{{ $sizeIcon }}" />
        @endif
    </a>
@else
    <button type="{{ $type ?? 'button' }}" {{ $attributes->merge(['class' => $class]) }}>
        @if($icon && $iconPosition === 'left')
            <x-utils::icon name="{{ $icon }}" size="{{ $sizeIcon }}" />
        @endif

        {{ $slot }}
        @if((empty($slot) || $slot->isEmpty()) && filled($text))
            <span class="button__text">{{ $text }}</span>
        @endif

        @if($icon && $iconPosition === 'right')
            <x-utils::icon name="{{ $icon }}" size="{{ $sizeIcon }}" />
        @endif

        @if($loading)
            <x-utils::icon name="spinner" size="{{ $sizeIcon }}" class="animate-spin" />
        @endif
    </button>
@endif
