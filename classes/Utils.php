<?php

namespace App;

use Random\RandomException;

class Utils
{

    /**
     * Generates a slug from a string.
     * @param string $name
     * @return string
     */
    public static function generateSlug(string $name): string
    {
        $slug = preg_replace('/[^a-z0-9]+/i', '-', $name);
        $slug = strtolower(trim($slug, '-'));
        $slug .= '-' . uniqid();
        return $slug;
    }

    /**
     * Generates a random token.
     * @return string
     */
    public static function generateToken(): string
    {
        try {
            return bin2hex(random_bytes(16));
        } catch (RandomException $e) {
            return 0;
        }
    }

    /**
     * Generates an excerpt from a WYSIWYG string.
     * @param string $wysiwyg
     * @return string
     */
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

    /**
     * Checks if the recaptcha token verification is successful.
     * @param $token
     * @return bool|mixed
     */
    public static function isRecaptchaTokenVerificationSuccessful($token): mixed
    {
        if (empty($token)) {
            return false;
        }
        // Initialize cURL
        $ch = curl_init();
        // Set the options
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify?secret=' . $_ENV['RECAPTCHA_SECRET_KEY'] . '&response=' . $token);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return the transfer as a string
        curl_setopt($ch, CURLOPT_FAILONERROR, true); // Required to check for HTTP errors
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification, if needed
        // Execute request
        $recaptcha_response = curl_exec($ch);
        // Check for errors
        if (curl_errno($ch)) {
            exit('reCaptcha verification error: ' . curl_error($ch));
        }
        // Close the cURL resource
        curl_close($ch);
        $recaptcha_response = json_decode($recaptcha_response);
        if ($recaptcha_response->success) {
            return $recaptcha_response;
        }
        return false;
    }
}