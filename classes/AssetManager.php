<?php

namespace App;

class AssetManager
{
    private static ?AssetManager $instance = null;
    private array $scripts = [];
    private array $styles = [];

    /**
     * Returns the instance of the AssetManager.
     * @return AssetManager
     */
    public static function getInstance(): AssetManager
    {
        if (self::$instance === null) {
            self::$instance = new AssetManager();
        }

        return self::$instance;
    }

    /**
     * Adds a script to the list of scripts to be included.
     * @param string $name
     * @return void
     */
    public function addScript(string $name): void
    {
        $this->scripts[] = $name;
    }

    /**
     * Adds a style to the list of styles to be included.
     * @param string $name
     * @return void
     */
    public function addStyle(string $name): void
    {
        $this->styles[] = $name;
    }

    /**
     * Prints the scripts to the page.
     * @return void
     */
    public function printScripts(): void
    {
        foreach ($this->scripts as $name) {
            echo '<script src="' . $this->generateUrl($name, '.js') . '"></script>';

        }
    }

    /**
     * Prints the styles to the page.
     * @return void
     */
    public function printStyles(): void
    {
        foreach ($this->styles as $name) {
            echo '<link rel="stylesheet" href="' . $this->generateUrl($name, '.css') . '">';
        }
    }

    /**
     * Generates the URL depending on the name.
     * @param string $name
     * @param string $suffix
     * @return string
     */
    public function generateUrl(string $name, string $suffix): string
    {
        if (str_starts_with($name, 'https://')) {
            return $name;
        } else {
            return '/dist/' . $name . $suffix;
        }
    }
}