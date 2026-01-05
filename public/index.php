<?php
declare(strict_types=1);

/**
 * Front controller (single entry point)
 * PHP 8+ compatible
 */

session_start();

// Basic hardening
ini_set('display_errors', '0');
error_reporting(E_ALL);

require __DIR__ . '/../app/core/Bootstrap.php';

$app = new App\Core\Bootstrap();
$app->run();

