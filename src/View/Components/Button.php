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
    public ?string $weight;
    public ?string $text;

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
        ?string $weight = 'regular',
        ?string $text = null
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

        // Автоопределение квадратной формы происходит в шаблоне
        $this->square = $square ?? false;

        // Жирность текста
        $this->weight = $weight;

        // Текст кнопки (альтернатива $slot)
        $this->text = $text;
    }

    public function render()
    {
        return view('chunker::components.button');
    }

    public function classes(?bool $square = null): string
    {
        $square = $square ?? $this->square;

        $builder = $this->classBuilder
            ->add('button')
            ->addIf($square, 'button_square')
            ->add("button_{$this->variant}");

        // Добавляем цветовой модификатор если цвет не accent и вариант не white
        if ($this->color !== 'accent' && $this->variant !== 'white') {
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
            ->toString();
    }
}
