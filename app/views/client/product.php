<?php
use App\Helpers\Csrf;
use App\Helpers\Escape;
?>

<?php if (!$product): ?>
    <div class="alert alert-warning">Produit introuvable.</div>
    <a class="btn btn-outline-secondary" href="/">Retour</a>
<?php else: ?>
    <div class="row g-4">
        <div class="col-12 col-lg-5">
            <div class="card shadow-sm">
                <?php if (!empty($product['image_path'])): ?>
                    <img class="w-100" style="height:320px;object-fit:cover" src="<?= Escape::e($product['image_path']); ?>" alt="">
                <?php else: ?>
                    <div class="p-5 text-center text-muted">Aucune image</div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-12 col-lg-7">
            <h1 class="h4"><?= Escape::e($product['name'] ?? ''); ?></h1>
            <div class="text-muted mb-2"><?= Escape::e($product['category'] ?? ''); ?></div>
            <div class="h5 mb-3"><?= number_format((float) ($product['price'] ?? 0), 0, ',', ' ') ?> F</div>
            <p><?= Escape::e($product['description'] ?? ''); ?></p>

            <form method="post" action="/cart/add" class="d-flex gap-2 align-items-end">
                <input type="hidden" name="_csrf" value="<?= Escape::e(Csrf::token()); ?>">
                <input type="hidden" name="product_id" value="<?= (int) $product['id']; ?>">
                <div>
                    <label class="form-label">Quantité</label>
                    <input class="form-control" type="number" name="qty" value="1" min="1" max="99">
                </div>
                <button class="btn btn-primary">Ajouter au panier</button>
                <a class="btn btn-outline-secondary" href="/">Retour</a>
            </form>
        </div>
    </div>
<?php endif; ?>

