<?php namespace Chunker2i\Base\View\Components;

use Illuminate\View\Component;
use Chunker2i\Base\Core\ComponentManager;
use Chunker2i\Base\Core\ClassBuilder;

abstract class AbstractComponent extends Component
{
    protected ComponentManager $manager;
    protected ClassBuilder $classBuilder;

    public function __construct()
    {
        $this->manager = app(ComponentManager::class);
        $this->classBuilder = app(ClassBuilder::class);
    }

    protected function resolveAutoLoading(array $attributes): bool
    {
        return isset($attributes['wire:click']) &&
               !str_starts_with($attributes['wire:click'], '$js.');
    }

    protected function resolveSquareForm($slot): bool
    {
        return method_exists($slot, 'isEmpty') ? $slot->isEmpty() : empty($slot);
    }

    protected function resolveIconVariant(string $size, bool $square = false): string
    {
        return match($size) {
            'xs' => 'micro',
            default => $square ? 'mini' : 'micro',
        };
    }
}
