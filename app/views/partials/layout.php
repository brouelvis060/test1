<?php
use App\Helpers\Auth;
use App\Helpers\Csrf;
use App\Helpers\Escape;

$user = Auth::user();
$isAdmin = $user && ($user['role'] ?? '') === 'admin';
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Escape::e(($title ?? null) ?: 'E-commerce'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/app.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">Boutique</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/">Produits</a></li>
                <li class="nav-item"><a class="nav-link" href="/cart">Panier</a></li>
                <?php if ($user): ?>
                    <li class="nav-item"><a class="nav-link" href="/client">Mon compte</a></li>
                <?php endif; ?>
                <?php if ($isAdmin): ?>
                    <li class="nav-item"><a class="nav-link" href="/admin">Admin</a></li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if (!$user): ?>
                    <li class="nav-item"><a class="nav-link" href="/login">Connexion</a></li>
                    <li class="nav-item"><a class="nav-link" href="/register">Inscription</a></li>
                <?php else: ?>
                    <li class="nav-item"><span class="navbar-text me-2"><?= Escape::e($user['email'] ?? ''); ?></span></li>
                    <li class="nav-item">
                        <form method="post" action="/logout" class="d-inline">
                            <input type="hidden" name="_csrf" value="<?= Escape::e(Csrf::token()); ?>">
                            <button class="btn btn-sm btn-outline-light">Déconnexion</button>
                        </form>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4">
    <?php if (!empty($flash)): ?>
        <div class="alert alert-<?= Escape::e($flash['type']); ?>"><?= Escape::e($flash['message']); ?></div>
    <?php endif; ?>

    <?php require $templateFile; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/app.js"></script>
</body>
</html>

