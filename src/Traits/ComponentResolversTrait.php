<?php namespace Chunker2i\Base\Traits;

trait ComponentResolversTrait
{
    /**
     * Определяет, нужно ли показывать состояние загрузки для компонента
     *
     * @param array $attributes Массив атрибутов компонента
     * @return bool
     */
    protected function resolveAutoLoading(array $attributes): bool
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
    protected function resolveSquareForm(mixed $slot): bool
    {
        return method_exists($slot, 'isEmpty') ? $slot->isEmpty() : empty($slot);
    }

    /**
     * Определяет вариант иконки в зависимости от размера и формы
     *
     * @param string $size Размер компонента
     * @param bool $square Форма компонента
     * @return string
     */
    protected function resolveIconVariant(string $size, bool $square = false): string
    {
        return match($size) {
            'xs' => 'micro',
            default => $square ? 'mini' : 'micro',
        };
    }
}
