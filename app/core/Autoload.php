<?php
declare(strict_types=1);

namespace App\Core;

final class Autoload
{
    public static function register(): void
    {
        spl_autoload_register(static function (string $class): void {
            // Only autoload App\*
            if (!str_starts_with($class, 'App\\')) {
                return;
            }

            $relative = str_replace('App\\', '', $class);
            $relative = str_replace('\\', DIRECTORY_SEPARATOR, $relative) . '.php';
            $path = __DIR__ . '/../' . strtolower(dirname($relative)) . '/' . basename($relative);

            // Our folders are lower-case (core/controllers/models/helpers/services/config/views not autoloaded)
            // Try a direct mapping first
            $pathDirect = __DIR__ . '/../' . $relative;
            if (is_file($pathDirect)) {
                require_once $pathDirect;
                return;
            }

            // Fallback: search common folders with original case
            $candidates = [
                __DIR__ . '/../core/' . basename($relative),
                __DIR__ . '/../controllers/' . basename($relative),
                __DIR__ . '/../models/' . basename($relative),
                __DIR__ . '/../helpers/' . basename($relative),
                __DIR__ . '/../services/' . basename($relative),
            ];

            foreach ($candidates as $file) {
                if (is_file($file)) {
                    require_once $file;
                    return;
                }
            }

            // Last resort (legacy)
            if (is_file($path)) {
                require_once $path;
            }
        });
    }
}

