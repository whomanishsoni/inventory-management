<?php
namespace Modules\Config;

// Create a new instance of our RouteCollection class.
$routes = \Config\Services::routes();

$routes->group('purchase-management', ['namespace' => '\Purchases\Controllers'], function ($routes) {
    
    // Products
    $routes->group('purchases', ['namespace' => 'Purchases\Controllers'], function ($routes) {
        $routes->get('', 'Purchases::purchases', ['as' => 'purchases.index']);
        $routes->get('add', 'Purchases::addPurchases', ['as' => 'purchases.add']);
        $routes->post('store', 'Purchases::storePurchases', ['as' => 'purchases.store']);
        $routes->get('edit/(:num)', 'Purchases::editPurchases/$1', ['as' => 'purchases.edit']);
        $routes->post('update/(:num)', 'Purchases::updatePurchases/$1', ['as' => 'purchases.update']);
        $routes->get('delete/(:num)', 'Purchases::deletePurchases/$1', ['as' => 'purchases.delete']);
        $routes->post('update_status', 'Purchases::updatePurchasesStatus', ['as' => 'purchases.update_status']);
        $routes->get('generatePurchaseOrderNumber', 'Purchases::generatePurchaseOrderNumber', ['as' => 'purchases.generate_purchase_order_number']);
        $routes->get('search', 'Purchases::searchProducts', ['as' => 'purchases.search']);
    });

});