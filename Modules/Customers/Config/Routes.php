<?php
namespace Modules\Config;

// Create a new instance of our RouteCollection class.
$routes = \Config\Services::routes();

$routes->add('/customers', "\Customers\Controllers\Customers::customers");

$routes->group('customers', ['namespace' => '\Customers\Controllers'], function ($routes) {

    // Routes for customer
    $routes->get('', 'Customers::customers', ['as' => 'customers.index']);
    $routes->get('add', 'Customers::addCustomers', ['as' => 'customers.add']);
    $routes->post('store', 'Customers::storeCustomers', ['as' => 'customers.store']);
    $routes->get('edit/(:num)', 'Customers::editCustomers/$1', ['as' => 'customers.edit']);
    $routes->post('update/(:num)', 'Customers::updateCustomers/$1', ['as' => 'customers.update']);
    $routes->get('delete/(:num)', 'Customers::deleteCustomers/$1', ['as' => 'customers.delete']);
    $routes->post('update_status', 'Customers::updateCustomersStatus', ['as' => 'customers.update_status']);
    $routes->get('get_states', 'Customers::getStates', ['as' => 'customers.get_states']);
    $routes->get('get_cities', 'Customers::getCities', ['as' => 'customers.get_cities']);

    // Routes for customer transactions
    $routes->get('balances', 'Customers::customerBalances', ['as' => 'customers.balances']);
    $routes->get('transactions/(:num)', 'Customers::transactions/$1', ['as' => 'customers.transactions']);
    $routes->get('add_transaction/(:num)', 'Customers::addTransactions/$1', ['as' => 'customers.add_transaction']);
    $routes->post('store_transaction/(:num)', 'Customers::storeTransactions/$1', ['as' => 'customers.store_transaction']);
    $routes->get('edit_transaction/(:num)', 'Customers::editTransactions/$1', ['as' => 'customers.edit_transaction']);
    $routes->post('update_transaction/(:num)', 'Customers::updateTransactions/$1', ['as' => 'customers.update_transaction']);
    $routes->get('delete_transaction/(:num)', 'Customers::deleteTransactions/$1', ['as' => 'customers.delete_transaction']);
    // Add more routes as needed
});
