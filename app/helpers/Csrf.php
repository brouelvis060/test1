<?php
declare(strict_types=1);

namespace App\Helpers;

final class Csrf
{
    public static function token(): string
    {
        if (!isset($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }
        return (string) $_SESSION['_csrf'];
    }

    public static function verify(string $token): bool
    {
        if (!isset($_SESSION['_csrf'])) {
            return false;
        }
        return hash_equals((string) $_SESSION['_csrf'], (string) $token);
    }
}

