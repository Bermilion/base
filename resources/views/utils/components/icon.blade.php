@props([
    'name' => null,
    'size' => 'md',
    'class' => null,
])

@php
    use Illuminate\Support\Facades\File;
    use Chunker2i\Base\Core\ClassBuilder;

    $coloredPath = resource_path("icons-colored/{$name}.svg");
    $isColored = File::exists($coloredPath);

    $svgAttrs = null;
    $svgContent = null;

    if ($isColored) {
        $content = File::get($coloredPath);

        $dom = new \DOMDocument();
        @$dom->loadXML($content, LIBXML_NOERROR | LIBXML_NOWARNING);

        $svgElement = $dom->getElementsByTagName('svg')->item(0);
        if ($svgElement) {
            $svgAttrs = [];
            foreach ($svgElement->attributes as $attr) {
                $svgAttrs[$attr->name] = $attr->value;
            }

            unset($svgAttrs['width'], $svgAttrs['height']);

            $innerContent = '';
            foreach ($svgElement->childNodes as $child) {
                $innerContent .= $dom->saveXML($child);
            }
            $svgContent = trim($innerContent);
        }
    }

    $builder = app(ClassBuilder::class);
    $builder->add('icon')->add($class ?? '');

    $builder->addMatch($size ?? 'md', [
        'md' => 'size',
        'sm' => 'size_sm',
        'lg' => 'size_lg',
    ]);

    $classes = $builder->toString();
@endphp

@if($isColored && $svgContent)
    <svg {{ $attributes->merge($svgAttrs ?? [])->merge(['class' => $classes]) }}>
        {!! $svgContent !!}
    </svg>
@else
    <svg {{ $attributes->merge(['class' => $classes]) }}>
        <use xlink:href='#icon-{{ $name }}'></use>
    </svg>
@endif
