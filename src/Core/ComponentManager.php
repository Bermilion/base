<?php namespace Chunker2i\Base\Core;

class ComponentManager
{
    private static ?self $instance = null;
    private array $config = [];
    private array $loadingStates = [];

    private function __construct() {}

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function setLoading(string $componentId, bool $state): void
    {
        $this->loadingStates[$componentId] = $state;
    }

    public function isLoading(string $componentId): bool
    {
        return $this->loadingStates[$componentId] ?? false;
    }

    public function registerVariant(string $component, string $name, array $config): void
    {
        $this->config["components.{$component}.variants.{$name}"] = $config;
    }

    public function registerIcon(string $name, string $path): void
    {
        $this->config["icons.custom.{$name}"] = $path;
    }

    public function getComponentConfig(string $component): array
    {
        return $this->config["components.{$component}"] ?? [];
    }

    public function setConfig(string $key, mixed $value): void
    {
        $this->config[$key] = $value;
    }

    public function getConfig(string $key, mixed $default = null): mixed
    {
        return $this->config[$key] ?? $default;
    }
}
