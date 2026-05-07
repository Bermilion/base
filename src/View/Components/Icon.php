<?php namespace Chunker2i\Base\View\Components;

class Icon extends AbstractComponent
{
    public string $name;
    public string $variant;
    public ?string $size;
    public ?string $class;

    public function __construct(
        string $name,
        string $variant = 'micro',
        ?string $size = null,
        ?string $class = null
    ) {
        parent::__construct();

        $this->name = $name;
        $this->variant = $variant;
        $this->size = $size;
        $this->class = $class;
    }

    public function render()
    {
        return view('chunker::components.icon');
    }

    public function classes(): string
    {
        $builder = $this->classBuilder
            ->add('inline-block')
            ->add($this->class ?? '');

        // Добавляем класс размера если указан
        if ($this->size) {
            $builder->add("icon_size-{$this->size}");
        }

        return $builder->toString();
    }

    public function iconPath(): string
    {
        // Путь к SVG иконке
        $paths = [
            "resources/icons/{$this->name}.svg",
            "resources/icons-colored/{$this->name}.svg",
        ];

        foreach ($paths as $path) {
            $fullPath = base_path($path);
            if (file_exists($fullPath)) {
                return $fullPath;
            }
        }

        return '';
    }

    public function iconSize(): string
    {
        return match($this->variant) {
            'micro' => '16px',
            'mini' => '20px',
            'small' => '24px',
            default => '16px',
        };
    }
}
