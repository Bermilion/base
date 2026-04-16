@props([
	'mod' => null,
])

@php
	use Chunker2i\Base\Traits\ModifiersTrait;

	// Create anonymous class to use trait
	$modifierHelper = new class {
		use ModifiersTrait;
	};

	// Build CSS class with modifiers
	$class = $modifierHelper->buildModifiersClass('ol', $mod);
@endphp

<ol {{ $attributes->class($class) }}>
	{{ $slot }}
</ol>
