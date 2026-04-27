@props([
	'mod' => 'accent',
	'text' => null,
	'icon' => null,
	'iconRight' => false,
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
	@if($icon && $iconRight === false)
		<x-utils::icon :name="$icon" />
	@endif

	@if($text)
		<span class="link__text">{{ $text }}</span>
	@else
		{{ $slot }}
	@endif

	@if($icon && $iconRight === true)
		<x-utils::icon :name="$icon" />
	@endif

</a>
