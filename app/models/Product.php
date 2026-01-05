<?php
declare(strict_types=1);

namespace App\Models;

use App\Helpers\Database;

final class Product
{
    /** @return array<int, array<string, mixed>> */
    public static function allActive(): array
    {
        $pdo = Database::pdo();
        $stmt = $pdo->query("SELECT * FROM products WHERE is_active=1 ORDER BY created_at DESC");
        return $stmt->fetchAll() ?: [];
    }

    /** @return array<string, mixed>|null */
    public static function findById(int $id): ?array
    {
        $pdo = Database::pdo();
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}

