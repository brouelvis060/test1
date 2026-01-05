<?php
declare(strict_types=1);

namespace App\Helpers;

final class Config
{
    /** @var array<string, mixed> */
    private static array $data = [];

    public static function load(string $file, string $namespace): void
    {
        if (!is_file($file)) {
            throw new \RuntimeException("Fichier config introuvable: {$file}");
        }
        /** @var array<string, mixed> $config */
        $config = require $file;
        self::$data[$namespace] = $config;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        // key format: namespace.key1.key2
        $parts = explode('.', $key);
        $value = self::$data;
        foreach ($parts as $p) {
            if (!is_array($value) || !array_key_exists($p, $value)) {
                return $default;
            }
            $value = $value[$p];
        }
        return $value;
    }
}

