@props([
	'mod' => null,
])

@php
	// Формируем модификатор только если mode передан
    $class = 'supheading';
    if ($mod) {
        $class .= ' supheading_' . $mod;
    }
    $class = trim($class);
@endphp

<p {{ $attributes->class($class) }}>
	{{ $slot }}
</p>
