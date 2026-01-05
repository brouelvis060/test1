<?php
declare(strict_types=1);

namespace App\Helpers;

final class View
{
    public static function render(string $template, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        $templateFile = __DIR__ . '/../views/' . ltrim($template, '/') . '.php';
        if (!is_file($templateFile)) {
            http_response_code(500);
            echo "Vue introuvable: {$template}";
            return;
        }

        $flash = Flash::consume();
        require __DIR__ . '/../views/partials/layout.php';
    }
}

