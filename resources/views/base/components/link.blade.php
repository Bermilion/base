@props([
	'mod' => null,
	'text' => null,
])

@php
	use Chunker2i\Base\Traits\ModifiersTrait;

	// Create anonymous class to use trait
	$modifierHelper = new class {
		use ModifiersTrait;
	};

	// Build CSS class with modifiers
	$class = $modifierHelper->buildModifiersClass('link', $mod);
@endphp

<a {{ $attributes->class($class) }}>
	@if($text)
		<span class="link__text">{{ $text }}</span>
	@else
		{{ $slot }}
	@endif
</a>
