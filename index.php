<?php
declare(strict_types=1);

/**
 * Compatibilité hébergeur / preview:
 * Si la racine du document est /workspace (et pas /public),
 * on redirige vers le front controller officiel.
 */

require __DIR__ . '/public/index.php';

