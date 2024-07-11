<?php

namespace App;

use Random\RandomException;

class Utils
{
    public static function generateSlug(string $name): string
    {
        $slug = preg_replace('/[^a-z0-9]+/i', '-', $name);
        $slug = strtolower(trim($slug, '-'));
        $slug .= '-' . uniqid();
        return $slug;
    }

    public static function generateToken(): string
    {
        try {
            return bin2hex(random_bytes(16));
        } catch (RandomException $e) {
            return 0;
        }
    }

    public static function generateExcerpt(string $wysiwyg): string
    {
        $description = strip_tags($wysiwyg);
        $words = explode(' ', $description);
        if (count($words) > 50) {
            $words = array_slice($words, 0, 50);
            $description = implode(' ', $words) . '...';
        }
        return $description;
    }
}