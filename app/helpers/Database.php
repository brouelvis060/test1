<?php
declare(strict_types=1);

namespace App\Helpers;

use PDO;
use PDOException;

final class Database
{
    private static ?PDO $pdo = null;

    public static function pdo(): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        $host = (string) Config::get('db.host');
        $port = (int) Config::get('db.port');
        $name = (string) Config::get('db.name');
        $user = (string) Config::get('db.user');
        $pass = (string) Config::get('db.pass');
        $charset = (string) Config::get('db.charset', 'utf8mb4');

        $dsn = "mysql:host={$host};port={$port};dbname={$name};charset={$charset}";

        try {
            self::$pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
            return self::$pdo;
        } catch (PDOException $e) {
            http_response_code(500);
            exit("Erreur connexion DB. Vérifiez la configuration. Détail: " . $e->getMessage());
        }
    }
}

