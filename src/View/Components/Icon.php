<?php namespace Chunker2i\Base\View\Components;

use Illuminate\Support\Facades\File;

class Icon extends AbstractComponent
{
    public string $name;
    public ?string $size;
    public ?string $class;

    public function __construct(
        string $name,
        ?string $size = null,
        ?string $class = null
    ) {
        parent::__construct();

        $this->name = $name;
        $this->size = $size;
        $this->class = $class;
    }

    public function render()
    {
        $svgData = $this->svgData();

        return view('chunker::components.icon', [
            'isColored' => $this->isColored(),
            'svgAttrs' => $svgData['attrs'] ?? null,
            'svgContent' => $svgData['content'] ?? null,
        ]);
    }

    /**
     * Проверяет, является ли иконка цветной (лежит в icons-colored)
     */
    public function isColored(): bool
    {
        $coloredPath = resource_path("icons-colored/{$this->name}.svg");
        return File::exists($coloredPath);
    }

    /**
     * Получает структурированные данные SVG для цветной иконки
     * @return array|null ['attrs' => [...], 'content' => '...']
     */
    protected function svgData(): ?array
    {
        if (!$this->isColored()) {
            return null;
        }

        $path = resource_path("icons-colored/{$this->name}.svg");
        $content = File::get($path);

        // Парсим SVG
        $dom = new \DOMDocument();
        @$dom->loadXML($content, LIBXML_NOERROR | LIBXML_NOWARNING);

        $svgElement = $dom->getElementsByTagName('svg')->item(0);
        if (!$svgElement) {
            return null;
        }

        // Собираем атрибуты
        $attrs = [];
        foreach ($svgElement->attributes as $attr) {
            $attrs[$attr->name] = $attr->value;
        }

        // Удаляем width/height (управляем через CSS)
        unset($attrs['width'], $attrs['height']);

        // Получаем внутреннее содержимое
        $innerContent = '';
        foreach ($svgElement->childNodes as $child) {
            $innerContent .= $dom->saveXML($child);
        }

        return [
            'attrs' => $attrs,
            'content' => trim($innerContent),
        ];
    }

    public function classes(): string
    {
        $builder = $this->classBuilder
            ->add('icon')
            ->add($this->class ?? '');

        // Добавляем класс размера (по умолчанию 'md' -> 'size')
        $builder->addMatch($this->size ?? 'md', [
            'md' => 'size',
            'sm' => 'size_sm',
            'lg' => 'size_lg',
        ]);

        return $builder->toString();
    }

}
