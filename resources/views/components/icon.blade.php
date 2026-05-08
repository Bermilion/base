@if($isColored && $svgContent)
	{{-- Цветная иконка: inline SVG для сохранения оригинальных цветов --}}
	<svg {{ $attributes->merge($svgAttrs ?? [])->merge(['class' => $classes()]) }}>
		{!! $svgContent !!}
	</svg>
@else
	{{-- Монохромная иконка: через спрайт с currentColor --}}
	<svg {{ $attributes->merge(['class' => $classes()]) }}>
		<use xlink:href='#icon-{{ $name }}'></use>
	</svg>
@endif
