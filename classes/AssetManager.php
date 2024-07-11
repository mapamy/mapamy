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
            echo '<script src="/dist/' . $name . '.js"></script>';
        }
    }

    /**
     * Prints the styles to the page.
     * @return void
     */
    public function printStyles(): void
    {
        foreach ($this->styles as $name) {
            echo '<link rel="stylesheet" href="/dist/' . $name . '.css"/>';
        }
    }
}