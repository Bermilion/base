@props([
	'mod' => null,
])

@php
	// Формируем модификатор только если mode передан
    $class = 'p';
    if ($mod) {
        $class .= ' p_' . $mod;
    }
    $class = trim($class);
@endphp

<p {{ $attributes->class($class) }}>
	{{ $slot }}
</p>
