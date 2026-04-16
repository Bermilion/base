<?php

namespace Chunker2i\Base\Traits;

trait ModifiersTrait
{
	/**
	 * Build CSS class with modifiers
	 *
	 * @param string $baseClass Base CSS class
	 * @param string|null $modifiers Modifiers string (space separated)
	 * @return string Complete CSS class with modifiers
	 */
	public function buildModifiersClass(string $baseClass, ?string $modifiers = null): string
	{
		$class = $baseClass;

		if ($modifiers) {
			// Split modifiers by space and filter empty values
			$modifierArray = array_filter(explode(' ', trim($modifiers)));

			foreach ($modifierArray as $modifier) {
				$class .= ' ' . $baseClass . '_' . trim($modifier);
			}
		}

		return trim($class);
	}
}
