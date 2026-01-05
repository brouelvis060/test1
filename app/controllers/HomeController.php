<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

final class HomeController extends Controller
{
    public function index(): void
    {
        $products = Product::allActive();
        $this->view('client/home', [
            'title' => 'Accueil',
            'products' => $products,
        ]);
    }

    public function product(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $product = $id ? Product::findById($id) : null;
        if (!$product || (int) ($product['is_active'] ?? 0) !== 1) {
            http_response_code(404);
        }

        $this->view('client/product', [
            'title' => 'Produit',
            'product' => $product,
        ]);
    }
}

