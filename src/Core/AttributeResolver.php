<?php namespace Chunker2i\Base\Core;

use Illuminate\View\ComponentAttributeBag;

/**
 * Резолвер атрибутов компонентов
 *
 * Предоставляет унифицированный интерфейс для работы с атрибутами Blade-компонентов.
 * Поддерживает кэширование resolved значений и fluent API для манипуляций.
 */
class AttributeResolver
{
    private ComponentAttributeBag $attributes;
    private array $resolved = [];

    public function __construct(ComponentAttributeBag $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Получить значение атрибута с кэшированием
     */
    public function get(string $key, mixed $default = null): mixed
    {
        if (!isset($this->resolved[$key])) {
            $this->resolved[$key] = $this->resolve($key, $default);
        }
        return $this->resolved[$key];
    }

    /**
     * Проверить наличие атрибута
     */
    public function has(string $key): bool
    {
        return $this->attributes->has($key);
    }

    /**
     * Извлечь атрибут (получить и удалить из коллекции)
     */
    public function pluck(string $key): mixed
    {
        $value = $this->attributes->get($key);
        $this->attributes = $this->attributes->except($key);
        return $value;
    }

    /**
     * Объединить атрибуты с новыми значениями
     */
    public function merge(array $attributes): ComponentAttributeBag
    {
        return $this->attributes->merge($attributes);
    }

    /**
     * Получить все атрибуты как массив
     */
    public function all(): array
    {
        return $this->attributes->getAttributes();
    }

    private function resolve(string $key, mixed $default): mixed
    {
        $value = $this->attributes->get($key);
        return $value !== null ? $value : $default;
    }
}
