<?php

namespace App;

class AssetManager
{
    private static ?AssetManager $instance = null;

    private array $scripts = [];
    private array $styles = [];

    private function __construct() {}

    public static function getInstance(): AssetManager
    {
        if (self::$instance === null) {
            self::$instance = new AssetManager();
        }

        return self::$instance;
    }

    public function addScript(string $name): void
    {
        $this->scripts[] = $name;
    }

    public function addStyle(string $name): void
    {
        $this->styles[] = $name;
    }

    public function printScripts(): void
    {
        foreach ($this->scripts as $name) {
            echo '<script src="/dist/' . $name . '.js"></script>';
        }
    }

    public function printStyles(): void
    {
        foreach ($this->styles as $name) {
            echo '<link rel="stylesheet" href="/dist/' . $name . '.css"/>';
        }
    }
}