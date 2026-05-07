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
    public bool $square;
    public string $iconVariant;
    public ?string $weight;

    public function __construct(
        string $variant = 'primary',
        string $color = 'accent',
        string $size = 'base',
        ?string $sizeScale = null,
        ?string $sizeFont = null,
        ?string $sizeIcon = null,
        ?string $icon = null,
        ?bool $loading = null,
        ?bool $square = null,
        ?string $iconVariant = null,
        ?string $weight = 'regular'
    ) {
        parent::__construct();

        $this->variant = $variant;
        $this->color = $color;
        $this->size = $size;

        // Новые параметры с fallback на $size для обратной совместимости
        $this->sizeScale = $sizeScale ?? $size;
        $this->sizeFont = $sizeFont ?? ($size === 'sm' ? $size : null);
        $this->sizeIcon = $sizeIcon ?? $size;

        $this->icon = $icon;

        // Автоопределение состояния загрузки
        $this->loading = $loading ?? false;

        // Автоопределение квадратной формы
        $this->square = $square ?? false;

        // Автоопределение варианта иконки
        $this->iconVariant = $iconVariant ?? $this->resolveIconVariant($this->sizeIcon, $this->square);

        // Жирность текста
        $this->weight = $weight;
    }

    public function render()
    {
        return view('chunker::components.button');
    }

    public function classes(): string
    {
        $builder = $this->classBuilder
            ->add('button')
            ->addIf($this->square, 'button_square')
            ->add("button_{$this->variant}");

        // Добавляем цветовой модификатор если цвет не accent и вариант не white
        if ($this->color !== 'accent') {
            $builder->add("button_{$this->variant}-{$this->color}");
        }

        return $builder
            ->addMatch($this->sizeScale, [
                'none' => 'button_size-none',
                'sm' => 'button_sm',
                'base' => 'button_base',
                'lg' => 'button_lg',
            ])
            ->addIf($this->sizeFont === 'sm', 'button_font-sm')
            ->addMatch($this->weight, [
                'regular' => 'button_text-regular',
                'medium' => 'button_text-medium',
                'semibold' => 'button_text-semibold',
                'bold' => 'button_text-bold',
            ])
            ->addIf($this->loading, 'button_loading')
            ->addIf($this->loading, 'opacity-75 cursor-not-allowed')
            ->toString();
    }
}
