<?php
namespace Modules\Config;

// Create a new instance of our RouteCollection class.
$routes = \Config\Services::routes();

$routes->group('sales-management', ['namespace' => '\Sales\Controllers'], function ($routes) {

    // Products
    $routes->group('sales', ['namespace' => 'Sales\Controllers'], function ($routes) {
        $routes->get('', 'Sales::sales', ['as' => 'sales.index']);
        $routes->get('add', 'Sales::addSales', ['as' => 'sales.add']);
        $routes->post('store', 'Sales::storeSales', ['as' => 'sales.store']);
        $routes->get('edit/(:num)', 'Sales::editSales/$1', ['as' => 'sales.edit']);
        $routes->post('update/(:num)', 'Sales::updateSales/$1', ['as' => 'sales.update']);
        $routes->get('delete/(:num)', 'Sales::deleteSales/$1', ['as' => 'sales.delete']);
        $routes->post('update_status', 'Sales::updateSalesStatus', ['as' => 'sales.update_status']);
        $routes->get('generateSalesOrderNumber', 'Sales::generateSalesOrderNumber', ['as' => 'sales.generate_sales_order_number']);
        $routes->get('search', 'Sales::searchProducts', ['as' => 'sales.search']);
    });

});
