# Архитектура Chunker2i/Base

## Обзор

Пакет предоставляет фундаментальную инфраструктуру для построения UI-компонентов в Laravel. Архитектура построена на трёх принципах:

1. **Разделение ответственности** — каждый namespace решает свою задачу
2. **Минимализм** — только необходимый код, ничего лишнего
3. **Расширяемость** — легко добавлять новые компоненты не меняя существующие

---

## Структура namespace'ов

### `base::` — Базовые интерактивные компоненты

**Что содержит:**
- `button` — полнофункциональная кнопка (loading, variants, active, square mode)
- `link` — ссылка с иконками и модификаторами

**Когда использовать:**
- Для интерактивных элементов, требующих состояний (loading, active, disabled)
- Когда нужна сложная логика визуализации (варианты, цвета, размеры)
- Для элементов с автоопределением формы (square при отсутствии текста)

**Пример:**
```blade
<x-base::button variant="primary" color="accent" icon="save" loading>
    Сохранить
</x-base::button>
```

---

### `utils::` — Утилитарные компоненты

**Что содержит:**
- `icon` — иконка с поддержкой двух режимов:
  - **Монохромные** — через SVG-спрайт, наследуют `currentColor`
  - **Цветные** — inline SVG с оригинальными цветами

**Когда использовать:**
- Для вставки иконок в любые другие компоненты
- Когда нужна цветная иконка (карты, иллюстрации)
- Для системных иконок (спиннеры, индикаторы)

**Почему utils:**
Иконка — чисто презентационный элемент без бизнес-логики. Она используется всеми другими компонентами, поэтому находится в утилитах.

**Пример:**
```blade
<x-utils::icon name="arrow-right" size="lg" />
```

---

### `type::` — Типографика

**Что содержит:**
- `h` — заголовки h1-h6 с модификаторами
- `p` — параграфы
- `hero` — hero-текст (крупные дисплейные заголовки)
- `hint` — подсказки и мелкий текст
- `ol/ul/li` — списки
- `supheading` — надзаголовки

**Когда использовать:**
- Для любого текстового контента
- Когда нужна семантическая типографика с модификаторами (цвет, вес, размер)

**Интеграция с Core:**
Все типографические компоненты используют `ModifiersTrait` через анонимный класс в шаблоне. Это позволяет применять BEM-модификаторы:

```blade
<x-type-h size="2" mod="accent bold">Заголовок</x-type-h>
{{-- Результат: <h2 class="h2 h2_accent h2_bold">Заголовок</h2> --}}
```

---

## PHP Core

### `ComponentManager`

**Назначение:** Управление глобальными состояниями компонентов (loading).

**Почему singleton:**
Состояния должны быть доступны из любого места приложения без передачи экземпляров.

**Методы:**
- `setLoading(string $componentId, bool $state)` — установить состояние загрузки
- `isLoading(string $componentId)` — проверить состояние

**Удалённые методы (не использовались):**
- `registerVariant`, `registerIcon`, `getComponentConfig` — конфигурация теперь в Blade-шаблонах
- `setConfig`, `getConfig` — не использовались

---

### `ClassBuilder`

**Назначение:** Fluent-построитель CSS-классов.

**Зачем нужен:**
```php
$builder->add('button')
    ->addIf($square, 'spacing_square')
    ->addMatch($size, ['sm' => 'text_sm', 'md' => 'text'])
    ->toString();
// "button spacing_square text"
```

**Преимущества:**
- Читаемый chained API
- Автоматическая фильтрация пустых значений
- Автоматический reset после `toString()`

---

### `AttributeResolver`

**Назначение:** Работа с атрибутами Blade-компонентов.

**Возможности:**
- Кэширование resolved значений
- `pluck()` — получить и удалить атрибут
- `merge()` — объединение с новыми значениями

**Удалённые методы:**
- `resolveAutoLoading`, `resolveSquareForm`, `resolveIconVariant` — дублировались в `ComponentResolversTrait`

---

## Traits

### `ComponentResolversTrait`

**Назначение:** Логика резолвинга состояний компонентов.

**Методы:**
- `resolveAutoLoading(array $attributes)` — определить автозагрузку по `wire:click`
- `resolveSquareForm(mixed $slot)` — определить квадратную форму по отсутствию контента

**Почему trait:**
Логика используется в Blade-шаблонах через анонимный класс:
```php
$resolver = new class {
    use ComponentResolversTrait;
};
$loading = $resolver->resolveAutoLoading($attributes->getAttributes());
```

---

### `ModifiersTrait`

**Назначение:** BEM-построитель модификаторов.

```php
buildModifiersClass('button', 'accent lg')
// "button button_accent button_lg"
```

**Где используется:**
- `type::` компоненты (через анонимный класс в шаблоне)
- `base::link` (в шаблоне)

---


## Почему убран namespace `chunker`

**Проблема исходного подхода:**
```php
// Было: всё в куче
Blade::componentNamespace('Chunker2i\Base\View\Components', 'chunker');
// <x-chunker::button>, <x-chunker::icon> — непонятно где что
```

**Решение:**
```php
// Стало: разделение по ответственности
base::button  // интерактивный элемент
utils::icon   // утилита
type::h       // типографика
```

**Преимущества:**
- Чёткая семантика: сразу понятно назначение компонента
- Проще искать: знаешь где искать button — в base
- Масштабируемость: новые категории добавляются без конфликтов

---

## Регистрация компонентов

```php
// AppServiceProvider::boot()
$this->loadViewsFrom($path, 'utils');  // utils::icon
$this->loadViewsFrom($path, 'base');   // base::button, base::link
$this->loadViewsFrom($path, 'type');   // type::h, type::p, ...
```

Все компоненты — Blade-only. Нет PHP-классов, только шаблоны с `@props` и inline-логикой.

---

## Использование в проекте

```blade
{{-- Кнопка с иконкой и loading --}}
<x-base::button icon="save" loading wire:click="store">
    Сохранить
</x-base::button>

{{-- Иконка отдельно --}}
<x-utils::icon name="check" size="sm" />

{{-- Типографика --}}
<x-type-h size="1" mod="accent">Заголовок</x-type-h>
<x-type-p mod="muted">Описание</x-type-p>

{{-- Ссылка --}}
<x-base::link href="/" mod="primary" icon="arrow-left">
    На главную
</x-base::link>
```

---

## Итоговая структура файлов

```
chunker2i/base/
├── src/
│   ├── Core/
│   │   ├── ComponentManager.php      # Управление состояниями
│   │   ├── ClassBuilder.php          # Построитель CSS
│   │   └── AttributeResolver.php     # Работа с атрибутами
│   ├── Traits/
│   │   ├── ComponentResolversTrait.php # Логика резолвинга
│   │   └── ModifiersTrait.php          # BEM-модификаторы
│   └── Providers/
│       └── AppServiceProvider.php      # Регистрация
└── resources/views/
    ├── base/components/
    │   ├── button.blade.php            # Rich-кнопка (Blade-only)
    │   └── link.blade.php              # Ссылка (Blade-only)
    ├── utils/components/
    │   └── icon.blade.php              # Иконка (Blade-only, 2 режима)
    └── type/components/
        ├── h.blade.php                 # Заголовки (Blade-only)
        ├── p.blade.php                 # Параграф (Blade-only)
        └── ...                         # Остальная типографика
```
