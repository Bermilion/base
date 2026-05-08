<?php namespace Chunker2i\Base\View\Components;

class Button extends AbstractComponent
{
    public string $variant;
    public string $color;
    public string $size;
    public ?string $sizeScale;
    public ?string $sizeFont;
    public ?string $sizeIcon;
    public ?string $icon;
    public bool $loading;
    public ?bool $square;
    public ?string $weight;
    public ?string $text;

    public function __construct(
        string $variant = 'primary',
        string $color = 'accent',
        string $size = 'md',
        ?string $sizeScale = null,
        ?string $sizeFont = null,
        ?string $sizeIcon = null,
        ?string $icon = null,
        ?bool $loading = null,
        ?bool $square = null,
        ?string $weight = 'regular',
        ?string $text = null
    ) {
        parent::__construct();

        $this->variant = $variant;
        $this->color = $color;
        $this->size = $size;

        // Новые параметры с fallback на $size для обратной совместимости
        $this->sizeScale = $sizeScale ?? $size;
        $this->sizeFont = $sizeFont ?? $size;
        $this->sizeIcon = $sizeIcon ?? $size;

        $this->icon = $icon;

        // Автоопределение состояния загрузки
        $this->loading = $loading ?? false;

        // square определяется в шаблоне по контенту (null = автоопределение)
        $this->square = $square;

        // Жирность текста
        $this->weight = $weight;

        // Текст кнопки (альтернатива $slot)
        $this->text = $text;
    }

    public function render()
    {
        return view('chunker::components.button');
    }

    public function classes(bool $square = false): string
    {

        $builder = $this->classBuilder
            ->add('button')
            ->addIf($square, 'spacing_square')
            ->add("button_{$this->variant}");

        // Добавляем цветовой модификатор если цвет не accent и вариант не white
        if ($this->color !== 'accent' && $this->variant !== 'white') {
            $builder->add("button_{$this->variant}-{$this->color}");
        }

        $builder
            ->addMatch($this->sizeScale, [
                'none' => 'spacing_none',
                'sm' => 'spacing_sm',
                'md' => 'spacing',
                'lg' => 'spacing_lg',
            ]);

        // Классы шрифта только для кнопок с текстом
        if (!$square) {
            $builder->addMatch($this->sizeFont, [
                'sm' => 'text_sm',
                'md' => 'text',
                'lg' => 'text_lg',
            ]);
        }

        return $builder
            ->addMatch($this->weight, [
                'regular' => 'weight',
                'medium' => 'weight_medium',
                'semibold' => 'weight_semibold',
                'bold' => 'weight_bold',
            ])
            ->addIf($this->loading, 'button_loading')
            ->toString();
    }
}
