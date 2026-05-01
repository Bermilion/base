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

	$modifiers = $mod;
	if (empty($text) && empty(trim($slot ?? ''))) {
		$modifiers .= ' circle';
	}

	// Build CSS class with modifiers
	$class = $modifierHelper->buildModifiersClass('button', $modifiers);
@endphp

<button {{ $attributes->class($class) }}>
	@if($icon && $iconRight === false)
		<x-utils::icon :name="$icon" />
	@endif

	@if($text)
		<span class="button__text">{{ $text }}</span>
	@else
		{{ $slot }}
	@endif

	@if($icon && $iconRight === true)
		<x-utils::icon :name="$icon" />
	@endif

</button>
