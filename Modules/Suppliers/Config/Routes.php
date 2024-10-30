<?php
namespace Modules\Config;

// Create a new instance of our RouteCollection class.
$routes = \Config\Services::routes();

$routes->add('/suppliers', "\Suppliers\Controllers\Suppliers::suppliers");

$routes->group('suppliers', ['namespace' => '\Suppliers\Controllers'], function ($routes) {
    $routes->get('', 'Suppliers::suppliers', ['as' => 'suppliers.index']);
    $routes->get('add', 'Suppliers::addSuppliers', ['as' => 'suppliers.add']);
    $routes->post('store', 'Suppliers::storeSuppliers', ['as' => 'suppliers.store']);
    $routes->get('edit/(:num)', 'Suppliers::editSuppliers/$1', ['as' => 'suppliers.edit']);
    $routes->post('update/(:num)', 'Suppliers::updateSuppliers/$1', ['as' => 'suppliers.update']);
    $routes->get('delete/(:num)', 'Suppliers::deleteSuppliers/$1', ['as' => 'suppliers.delete']);
    $routes->post('update_status', 'Suppliers::updateSuppliersStatus', ['as' => 'suppliers.update_status']);
    $routes->get('get_states', 'Suppliers::getStates', ['as' => 'suppliers.get_states']);
    $routes->get('get_cities', 'Suppliers::getCities', ['as' => 'suppliers.get_cities']);
});
