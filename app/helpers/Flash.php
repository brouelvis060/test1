<?php
declare(strict_types=1);

namespace App\Helpers;

final class Flash
{
    public static function success(string $message): void
    {
        $_SESSION['_flash'] = ['type' => 'success', 'message' => $message];
    }

    public static function error(string $message): void
    {
        $_SESSION['_flash'] = ['type' => 'danger', 'message' => $message];
    }

    /** @return array{type:string, message:string}|null */
    public static function consume(): ?array
    {
        if (!isset($_SESSION['_flash'])) {
            return null;
        }
        $v = $_SESSION['_flash'];
        unset($_SESSION['_flash']);
        return is_array($v) ? $v : null;
    }
}

