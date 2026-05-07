<?php namespace Chunker2i\Base\Core;

use Illuminate\View\ComponentAttributeBag;

class AttributeResolver
{
    private ComponentAttributeBag $attributes;
    private array $resolved = [];

    public function __construct(ComponentAttributeBag $attributes)
    {
        $this->attributes = $attributes;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        if (!isset($this->resolved[$key])) {
            $this->resolved[$key] = $this->resolve($key, $default);
        }
        return $this->resolved[$key];
    }

    public function has(string $key): bool
    {
        return $this->attributes->has($key);
    }

    public function pluck(string $key): mixed
    {
        $value = $this->attributes->get($key);
        $this->attributes = $this->attributes->except($key);
        return $value;
    }

    public function merge(array $attributes): ComponentAttributeBag
    {
        return $this->attributes->merge($attributes);
    }

    public function all(): array
    {
        return $this->attributes->getAttributes();
    }

    private function resolve(string $key, mixed $default): mixed
    {
        $value = $this->attributes->get($key);

        if ($value !== null) {
            return $value;
        }

        return $default;
    }

    public function resolveAutoLoading(): bool
    {
        $attrs = $this->all();
        return isset($attrs['wire:click']) &&
               !str_starts_with($attrs['wire:click'], '$js.');
    }

    public function resolveSquareForm(mixed $slot): bool
    {
        return method_exists($slot, 'isEmpty') ? $slot->isEmpty() : empty($slot);
    }

    public function resolveIconVariant(string $size, bool $square = false): string
    {
        return match($size) {
            'xs' => 'micro',
            default => $square ? 'mini' : 'micro',
        };
    }
}
