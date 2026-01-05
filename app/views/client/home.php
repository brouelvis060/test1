<?php
use App\Helpers\Escape;
?>

<div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h4 mb-0">Produits</h1>
    <a class="btn btn-outline-primary btn-sm" href="/cart">Voir le panier</a>
</div>

<?php if (empty($products)): ?>
    <div class="alert alert-info">
        Aucun produit pour le moment. (Installez la base et ajoutez des produits depuis l’admin.)
    </div>
<?php else: ?>
    <div class="row g-3">
        <?php foreach ($products as $p): ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card card-product shadow-sm">
                    <?php if (!empty($p['image_path'])): ?>
                        <img src="<?= Escape::e($p['image_path']); ?>" alt="">
                    <?php endif; ?>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h2 class="h6 mb-1"><?= Escape::e($p['name'] ?? ''); ?></h2>
                            <span class="badge bg-dark"><?= number_format((float) ($p['price'] ?? 0), 0, ',', ' ') ?> F</span>
                        </div>
                        <p class="text-muted small mb-2"><?= Escape::e($p['category'] ?? ''); ?></p>
                        <a class="btn btn-primary btn-sm" href="/product?id=<?= (int) $p['id']; ?>">Voir</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

