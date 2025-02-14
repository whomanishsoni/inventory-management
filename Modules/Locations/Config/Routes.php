<?php
namespace Modules\Config;

// Create a new instance of our RouteCollection class.

$routes = \Config\Services::routes();

$routes->group('locations', ['namespace' => '\Locations\Controllers'], function ($routes) {
    // Country Routes
    $routes->get('countries', 'Locations::countries', ['as' => 'countries.index']);
    $routes->get('countries/add', 'Locations::addCountries', ['as' => 'countries.add']);
    $routes->post('countries/store', 'Locations::storeCountries', ['as' => 'countries.store']);
    $routes->get('countries/edit/(:num)', 'Locations::editCountries/$1', ['as' => 'countries.edit']);
    $routes->post('countries/update/(:num)', 'Locations::updateCountries/$1', ['as' => 'countries.update']);
    $routes->get('countries/delete/(:num)', 'Locations::deleteCountries/$1', ['as' => 'countries.delete']);
    $routes->post('countries/update_status', 'Locations::updateCountriesStatus', ['as' => 'countries.update_status']);

    // State Routes
    $routes->get('states', 'Locations::states', ['as' => 'states.index']);
    $routes->get('states/add', 'Locations::addStates', ['as' => 'states.add']);
    $routes->post('states/store', 'Locations::storeStates', ['as' => 'states.store']);
    $routes->get('states/edit/(:num)', 'Locations::editStates/$1', ['as' => 'states.edit']);
    $routes->post('states/update/(:num)', 'Locations::updateStates/$1', ['as' => 'states.update']);
    $routes->get('states/delete/(:num)', 'Locations::deleteStates/$1', ['as' => 'states.delete']);
    $routes->post('states/update_status', 'Locations::updateStatesStatus', ['as' => 'states.update_status']);

    // City Routes
    $routes->get('cities', 'Locations::cities', ['as' => 'cities.index']);
    $routes->get('cities/add', 'Locations::addCities', ['as' => 'cities.add']);
    $routes->post('cities/store', 'Locations::storeCities', ['as' => 'cities.store']);
    $routes->get('cities/edit/(:num)', 'Locations::editCities/$1', ['as' => 'cities.edit']);
    $routes->post('cities/update/(:num)', 'Locations::updateCities/$1', ['as' => 'cities.update']);
    $routes->get('cities/delete/(:num)', 'Locations::deleteCities/$1', ['as' => 'cities.delete']);
    $routes->post('cities/update_status', 'Locations::updateCitiesStatus', ['as' => 'cities.update_status']);
});

