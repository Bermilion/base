<?php namespace Chunker2i\Base\View\Components;

use Illuminate\View\Component;
use Chunker2i\Base\Core\ComponentManager;
use Chunker2i\Base\Core\ClassBuilder;
use Chunker2i\Base\Traits\ComponentResolversTrait;

abstract class AbstractComponent extends Component
{
    use ComponentResolversTrait;

    protected ComponentManager $manager;
    protected ClassBuilder $classBuilder;

    public function __construct()
    {
        $this->manager = app(ComponentManager::class);
        $this->classBuilder = app(ClassBuilder::class);
    }
}
