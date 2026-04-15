@props([
	'mod' => null,
])

@php
	// Формируем модификатор только если mode передан
    $class = 'hero';
    if ($mod) {
        $class .= ' hero_' . $mod;
    }
    $class = trim($class);
@endphp

<p {{ $attributes->class($class) }}>
	{{ $slot }}
</p>
