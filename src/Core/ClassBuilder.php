<?php namespace Chunker2i\Base\Core;

class ClassBuilder
{
    private array $classes = [];

    public function add(string $classes): self
    {
        $this->classes[] = $classes;
        return $this;
    }

    public function addIf(bool $condition, string $classes): self
    {
        if ($condition) {
            $this->classes[] = $classes;
        }
        return $this;
    }

    public function addMatch(mixed $value, array $cases): self
    {
        $this->classes[] = match($value) {
            default => $cases[$value] ?? '',
        };
        return $this;
    }

    public function toString(): string
    {
        return implode(' ', array_filter($this->classes));
    }
}
