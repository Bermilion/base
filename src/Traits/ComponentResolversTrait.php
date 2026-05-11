<?php namespace Chunker2i\Base\Traits;

trait ComponentResolversTrait
{
    /**
     * Определяет, нужно ли показывать состояние загрузки для компонента
     *
     * @param array $attributes Массив атрибутов компонента
     * @return bool
     */
    public function resolveAutoLoading(array $attributes): bool
    {
        return isset($attributes['wire:click']) &&
               !str_starts_with($attributes['wire:click'], '$js.');
    }

    /**
     * Определяет, является ли форма квадратной (без контента)
     *
     * @param mixed $slot Слот компонента
     * @return bool
     */
    public function resolveSquareForm(mixed $slot): bool
    {
        return method_exists($slot, 'isEmpty') ? $slot->isEmpty() : empty($slot);
    }
}
