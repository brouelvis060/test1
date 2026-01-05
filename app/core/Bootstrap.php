<?php
declare(strict_types=1);

namespace App\Core;

use App\Helpers\Config;

final class Bootstrap
{
    public function run(): void
    {
        $this->loadAutoload();
        $this->loadConfig();

        $router = new Router();
        $this->registerRoutes($router);

        $router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $_SERVER['REQUEST_URI'] ?? '/');
    }

    private function loadAutoload(): void
    {
        require_once __DIR__ . '/Autoload.php';
        Autoload::register();
    }

    private function loadConfig(): void
    {
        Config::load(__DIR__ . '/../config/app.php', 'app');
        Config::load(__DIR__ . '/../config/database.php', 'db');
    }

    private function registerRoutes(Router $router): void
    {
        // Public
        $router->get('/', 'HomeController@index');
        $router->get('/product', 'HomeController@product'); // ?id=
        $router->get('/cart', 'CartController@index');
        $router->post('/cart/add', 'CartController@add');
        $router->post('/cart/remove', 'CartController@remove');
        $router->get('/checkout', 'CheckoutController@index');
        $router->post('/checkout', 'CheckoutController@placeOrder');

        // Auth
        $router->get('/login', 'AuthController@loginForm');
        $router->post('/login', 'AuthController@login');
        $router->get('/register', 'AuthController@registerForm');
        $router->post('/register', 'AuthController@register');
        $router->post('/logout', 'AuthController@logout');

        // Client
        $router->get('/client', 'ClientController@dashboard');
        $router->get('/client/orders', 'ClientController@orders');
        $router->get('/client/order', 'ClientController@order'); // ?id=
        $router->post('/client/profile/upload', 'ClientController@uploadProfilePhoto');
        $router->get('/client/addresses', 'ClientController@addresses');
        $router->post('/client/addresses/add', 'ClientController@addAddress');
        $router->post('/client/order/confirm-pickup', 'ClientController@confirmPickup');

        // Admin
        $router->get('/admin', 'AdminController@dashboard');
        $router->get('/admin/products', 'AdminProductController@index');
        $router->get('/admin/products/create', 'AdminProductController@createForm');
        $router->post('/admin/products/create', 'AdminProductController@create');
        $router->get('/admin/products/edit', 'AdminProductController@editForm'); // ?id=
        $router->post('/admin/products/edit', 'AdminProductController@update'); // ?id=
        $router->post('/admin/products/delete', 'AdminProductController@delete'); // ?id=
        $router->post('/admin/products/toggle', 'AdminProductController@toggle'); // ?id=

        $router->get('/admin/settings/site', 'AdminSettingsController@site');
        $router->post('/admin/settings/site', 'AdminSettingsController@saveSite');
        $router->get('/admin/settings/shipping', 'AdminSettingsController@shipping');
        $router->post('/admin/settings/shipping', 'AdminSettingsController@saveShipping');
        $router->get('/admin/settings/payments', 'AdminSettingsController@payments');
        $router->post('/admin/settings/payments', 'AdminSettingsController@savePayments');
        $router->get('/admin/settings/sms', 'AdminSettingsController@sms');
        $router->post('/admin/settings/sms', 'AdminSettingsController@saveSms');

        $router->get('/admin/orders', 'AdminOrderController@index');
        $router->get('/admin/order', 'AdminOrderController@show'); // ?id=
        $router->post('/admin/order/status', 'AdminOrderController@updateStatus'); // ?id=
        $router->post('/admin/order/upload-receipt', 'AdminOrderController@uploadReceipt'); // ?id=
    }
}

