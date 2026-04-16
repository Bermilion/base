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
	$class = $modifierHelper->buildModifiersClass('supheading', $mod);
@endphp

<p {{ $attributes->class($class) }}>
	{{ $slot }}
</p>
