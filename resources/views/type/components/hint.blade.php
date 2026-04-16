@props([
	'mod' => null,
])

@php
	// Include trait for modifier handling
	use Chunker2i\Base\Traits\ModifiersTrait;

	// Create anonymous class to use trait
	$modifierHelper = new class {
		use ModifiersTrait;
	};

	// Build CSS class with modifiers
	$class = $modifierHelper->buildModifiersClass('hint', $mod);
@endphp

<p {{ $attributes->class($class) }}>
	{{ $slot }}
</p>
