@props([
    'size' => 2,
    'mod' => null,
    'text' => null,
])

@php
	$size = (int) $size;
	$size = max(1, min(6, $size)); // Limit size from 1 to 6
	$tag = 'h' . $size;

	use Chunker2i\Base\Traits\ModifiersTrait;

	// Create anonymous class to use trait
	$modifierHelper = new class {
		use ModifiersTrait;
	};

	// Build CSS class with modifiers
	$class = $modifierHelper->buildModifiersClass('h' . $size, $mod);
@endphp

<{{ $tag }} {{ $attributes->except('text')->class($class) }}>
	{{ $text ?? $slot }}
</{{ $tag }}>
