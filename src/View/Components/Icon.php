<?php namespace Chunker2i\Base\View\Components;

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
        return view('chunker::components.icon');
    }

    public function classes(): string
    {
        $builder = $this->classBuilder
            ->add('icon')
            ->add($this->class ?? '');

        // Добавляем класс размера если указан
        if ($this->size) {
            $builder->add("icon_size-{$this->size}");
        }

        return $builder->toString();
    }

}
