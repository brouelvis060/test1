<?php
declare(strict_types=1);

namespace App\Helpers;

use App\Models\User;

final class Auth
{
    public static function user(): ?array
    {
        $id = $_SESSION['user_id'] ?? null;
        if (!$id) {
            return null;
        }
        return User::findById((int) $id);
    }

    public static function check(): bool
    {
        return (bool) self::user();
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            Flash::error("Merci de vous connecter.");
            header('Location: /login');
            exit;
        }
    }

    public static function requireRole(string $role): void
    {
        $u = self::user();
        if (!$u || ($u['role'] ?? '') !== $role) {
            http_response_code(403);
            exit('Accès refusé');
        }
    }
}

