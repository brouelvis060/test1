<?php
declare(strict_types=1);

namespace App\Core;

use App\Helpers\Csrf;
use App\Helpers\Flash;
use App\Helpers\View;

abstract class Controller
{
    protected function view(string $template, array $data = []): void
    {
        View::render($template, $data);
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }

    protected function requirePost(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
            http_response_code(405);
            exit('Méthode non autorisée');
        }
    }

    protected function verifyCsrf(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? '')) {
            http_response_code(419);
            Flash::error("Session expirée, merci de réessayer.");
            $this->redirect($_SERVER['HTTP_REFERER'] ?? '/');
        }
    }
}

