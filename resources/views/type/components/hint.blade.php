@props([
	'mod' => null,
])

@php
	// Формируем модификатор только если mode передан
    $class = 'hint';
    if ($mod) {
        $class .= ' hint_' . $mod;
    }
    $class = trim($class);
@endphp

<p {{ $attributes->class($class) }}>
	{{ $slot }}
</p>
