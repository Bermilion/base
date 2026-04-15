@props([
    'size' => 2,
    'mod' => null,
    'text' => null,
])

@php
	$size = (int) $size;
	$size = max(1, min(6, $size)); // Ограничиваем размер от 1 до 6
	$tag = 'h' . $size;

	// Формируем модификатор только если mode передан
    $class = 'h' . $size;
    if ($mod) {
        $class .= ' h' . $size . '_' . $mod;
    }
    $class = trim($class);
@endphp

<{{ $tag }} {{ $attributes->except('text')->class($class) }}>
	{{ $text ?? $slot }}
</{{ $tag }}>
