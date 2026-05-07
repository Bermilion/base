<?php namespace Chunker2i\Base\Core;

class StateManager
{
    private array $states = [];
    private array $listeners = [];

    public function set(string $componentId, string $key, mixed $value): void
    {
        $oldValue = $this->states[$componentId][$key] ?? null;
        $this->states[$componentId][$key] = $value;

        if ($oldValue !== $value) {
            $this->notify($componentId, $key, $value);
        }
    }

    public function get(string $componentId, string $key, mixed $default = null): mixed
    {
        return $this->states[$componentId][$key] ?? $default;
    }

    public function has(string $componentId, string $key): bool
    {
        return isset($this->states[$componentId][$key]);
    }

    public function clear(string $componentId): void
    {
        unset($this->states[$componentId]);
    }

    public function clearAll(): void
    {
        $this->states = [];
    }

    public function getAll(string $componentId): array
    {
        return $this->states[$componentId] ?? [];
    }

    public function onChange(string $componentId, string $key, callable $callback): void
    {
        $this->listeners[$componentId][$key][] = $callback;
    }

    public function toggle(string $componentId, string $key): bool
    {
        $current = $this->get($componentId, $key, false);
        $newValue = !$current;
        $this->set($componentId, $key, $newValue);
        return $newValue;
    }

    public function increment(string $componentId, string $key, int $step = 1): int
    {
        $current = $this->get($componentId, $key, 0);
        $newValue = $current + $step;
        $this->set($componentId, $key, $newValue);
        return $newValue;
    }

    private function notify(string $componentId, string $key, mixed $value): void
    {
        if (!isset($this->listeners[$componentId][$key])) {
            return;
        }

        foreach ($this->listeners[$componentId][$key] as $callback) {
            $callback($value, $componentId, $key);
        }
    }
}
