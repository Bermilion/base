<?php namespace Chunker2i\Base\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	public function register():void {
		//
	}

	public function boot():void {

		$this->publishesScss([
			'app.scss',

			'certain/_index.scss',
			'certain/_body.scss',
			'certain/_link.scss',

			'config/_colors.scss',
			'config/_scale.scss',
			'config/_viewports.scss',
		]);

		$this->loadViewsFrom($this->packageViewsPath('utils'), 'utils');
		$this->loadViewsFrom($this->packageViewsPath('type'), 'type');
		$this->loadViewsFrom($this->packageViewsPath('base'), 'base');
	}

	/**
	 * Публикация SCSS-файлов пакета
	 *
	 * @param array $files
	 * @return void
	 */
	protected function publishesScss(array $files):void {
		$paths = [];

		foreach ($files as $file) {
			$key = $this->packageScssPath($file);
			$value = $this->projectScssPath($file);
			$paths[$key] = $value;
		}

		$this->publishes($paths, ['resources', 'scss']);
	}

	/**
	 * Путь к корневой папке пакета
	 *
	 * @param string $path
	 * @return string
	 */
	protected function packageRootPath(string $path = ''):string {
		return __DIR__ . '/../../' . $path;
	}

	/**
	 * Путь к папке пакета с ресурсами
	 *
	 * @param string $path
	 * @return string
	 */
	protected function packageResourcePath(string $path = ''):string {
		return $this->packageRootPath('resources/' . $path);
	}

	/**
	 * Путь к папке пакета с SCSS
	 *
	 * @param string $path
	 * @return string
	 */
	protected function packageScssPath(string $path = ''):string {
		return $this->packageResourcePath('scss/' . $path);
	}

	/**
	 * Путь к папке пакета с представлениями
	 *
	 * @param string $path
	 * @return string
	 */
	protected function packageViewsPath(string $path = ''):string {
		return $this->packageResourcePath('views/' . $path);
	}

	/**
	 * Путь к папке проекта с SCSS
	 *
	 * @param string $path
	 * @return string
	 */
	protected function projectScssPath(string $path = ''):string {
		return resource_path('scss/' . $path);
	}
}
