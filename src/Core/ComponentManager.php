<?php namespace Chunker2i\Base\Core;

/**
 * Менеджер состояний компонентов
 *
 * Управляет глобальными состояниями компонентов (loading, disabled и т.д.)
 * Используется для синхронизации состояния между PHP и JavaScript
 */
class ComponentManager
{
    private static ?self $instance = null;
    private array $loadingStates = [];

    private function __construct() {}

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Установить состояние загрузки для компонента
     */
    public function setLoading(string $componentId, bool $state): void
    {
        $this->loadingStates[$componentId] = $state;
    }

    /**
     * Проверить состояние загрузки компонента
     */
    public function isLoading(string $componentId): bool
    {
        return $this->loadingStates[$componentId] ?? false;
    }
}
