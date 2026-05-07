@php
    $size = $iconSize();
@endphp

<svg {{ $attributes->merge(['class' => $classes() . ' icon']) }}>
	<use xlink:href='#icon-{{ $name }}'></use>
</svg>
