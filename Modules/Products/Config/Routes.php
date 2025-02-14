<?php
namespace Modules\Config;

// Create a new instance of our RouteCollection class.
$routes = \Config\Services::routes();

$routes->group('product-management', ['namespace' => '\Products\Controllers'], function ($routes) {
    
    // Products
    $routes->group('products', ['namespace' => 'Products\Controllers'], function ($routes) {
        $routes->get('', 'Products::products', ['as' => 'products.index']);
        $routes->get('add', 'Products::addProducts', ['as' => 'products.add']);
        $routes->post('store', 'Products::storeProducts', ['as' => 'products.store']);
        $routes->get('edit/(:num)', 'Products::editProducts/$1', ['as' => 'products.edit']);
        $routes->post('update/(:num)', 'Products::updateProducts/$1', ['as' => 'products.update']);
        $routes->get('delete/(:num)', 'Products::deleteProducts/$1', ['as' => 'products.delete']);
        $routes->post('update_status', 'Products::updateProductsStatus', ['as' => 'products.update_status']);
        $routes->get('get_sub_categories', 'Products::getSubCategories', ['as' => 'products.get_sub_categories']);
        $routes->get('get_variation_values', 'Products::getVariationValues', ['as' => 'products.get_variation_values']);
        $routes->post('get_tax_rate', 'Products::getTaxRate', ['as' => 'products.get_tax_rate']);
        $routes->get('single/(:num)', 'Products::getProductsDetails/$1', ['as' => 'products.single_product_details']);
        $routes->get('variation/(:num)', 'Products::getProductVariations/$1', ['as' => 'products.variation_product_details']);
    });
    
    // Brands
    $routes->group('brands', ['namespace' => '\Products\Controllers'], function ($routes) {
        $routes->get('', 'Brands::brands', ['as' => 'brands.index']);
        $routes->get('add', 'Brands::addBrands', ['as' => 'brands.add']);
        $routes->post('store', 'Brands::storeBrands', ['as' => 'brands.store']);
        $routes->get('edit/(:num)', 'Brands::editBrands/$1', ['as' => 'brands.edit']);
        $routes->post('update/(:num)', 'Brands::updateBrands/$1', ['as' => 'brands.update']);
        $routes->get('delete/(:num)', 'Brands::deleteBrands/$1', ['as' => 'brands.delete']);
        $routes->post('update_status', 'Brands::updateBrandsStatus', ['as' => 'brands.update_status']);
        // Add other brand-related actions as needed
    });

    // Units
    $routes->group('units', ['namespace' => '\Products\Controllers'], function ($routes) {
        $routes->get('', 'Units::units', ['as' => 'units.index']);
        $routes->get('add', 'Units::addUnits', ['as' => 'units.add']);
        $routes->post('store', 'Units::storeUnits', ['as' => 'units.store']);
        $routes->get('edit/(:num)', 'Units::editUnits/$1', ['as' => 'units.edit']);
        $routes->post('update/(:num)', 'Units::updateUnits/$1', ['as' => 'units.update']);
        $routes->get('delete/(:num)', 'Units::deleteUnits/$1', ['as' => 'units.delete']);
        $routes->post('update_status', 'Units::updateUnitsStatus', ['as' => 'units.update_status']);
        // Add other brand-related actions as needed
    });

    // Categories
    $routes->group('categories', ['namespace' => '\Products\Controllers'], function ($routes) {
        $routes->get('', 'Categories::categories', ['as' => 'categories.index']);
        $routes->get('add', 'Categories::addCategories', ['as' => 'categories.add']);
        $routes->post('store', 'Categories::storeCategories', ['as' => 'categories.store']);
        $routes->get('edit/(:num)', 'Categories::editCategories/$1', ['as' => 'categories.edit']);
        $routes->post('update/(:num)', 'Categories::updateCategories/$1', ['as' => 'categories.update']);
        $routes->get('delete/(:num)', 'Categories::deleteCategories/$1', ['as' => 'categories.delete']);
        $routes->post('update_status', 'Categories::updateCategoriesStatus', ['as' => 'categories.update_status']);
        // Add other category-related actions as needed
    });

    // Sub-Categories
    $routes->group('sub-categories', ['namespace' => '\Products\Controllers'], function ($routes) {
        $routes->get('', 'SubCategories::subCategories', ['as' => 'sub-categories.index']);
        $routes->get('add', 'SubCategories::addSubCategories', ['as' => 'sub-categories.add']);
        $routes->post('store', 'SubCategories::storeSubCategories', ['as' => 'sub-categories.store']);
        $routes->get('edit/(:num)', 'SubCategories::editSubCategories/$1', ['as' => 'sub-categories.edit']);
        $routes->post('update/(:num)', 'SubCategories::updateSubCategories/$1', ['as' => 'sub-categories.update']);
        $routes->get('delete/(:num)', 'SubCategories::deleteSubCategories/$1', ['as' => 'sub-categories.delete']);
        $routes->post('update_status', 'SubCategories::updateSubCategoriesStatus', ['as' => 'sub-categories.update_status']);
        // Add other sub-category-related actions as needed
    });

    // Tax Groups
    $routes->group('tax-groups', ['namespace' => '\Products\Controllers'], function ($routes) {
        $routes->get('', 'TaxGroups::taxGroups', ['as' => 'tax-groups.index']);
        $routes->get('add', 'TaxGroups::addTaxGroups', ['as' => 'tax-groups.add']);
        $routes->post('store', 'TaxGroups::storeTaxGroups', ['as' => 'tax-groups.store']);
        $routes->get('edit/(:num)', 'TaxGroups::editTaxGroups/$1', ['as' => 'tax-groups.edit']);
        $routes->post('update/(:num)', 'TaxGroups::updateTaxGroups/$1', ['as' => 'tax-groups.update']);
        $routes->get('delete/(:num)', 'TaxGroups::deleteTaxGroups/$1', ['as' => 'tax-groups.delete']);
        $routes->post('update_status', 'TaxGroups::updateTaxGroupsStatus', ['as' => 'tax-groups.update_status']);
        // Add other tax group-related actions as needed
    });

    // Tax Rates
    $routes->group('tax-rates', ['namespace' => '\Products\Controllers'], function ($routes) {
        $routes->get('', 'TaxRates::taxRates', ['as' => 'tax-rates.index']);
        $routes->get('add/(:num)', 'TaxRates::addTaxRates/$1', ['as' => 'tax-rates.add']);
        // $routes->get('add', 'TaxRates::addTaxRates', ['as' => 'tax-rates.add']);
        $routes->post('store', 'TaxRates::storeTaxRates', ['as' => 'tax-rates.store']);
        $routes->get('edit/(:num)', 'TaxRates::editTaxRates/$1', ['as' => 'tax-rates.edit']);
        // $routes->get('edit/(:num)', 'TaxRates::editTaxRates/$1', ['as' => 'tax-rates.edit']);
        $routes->post('update/(:num)', 'TaxRates::updateTaxRates/$1', ['as' => 'tax-rates.update']);
        $routes->get('delete/(:num)', 'TaxRates::deleteTaxRates/$1', ['as' => 'tax-rates.delete']);
        $routes->post('update_status', 'TaxRates::updateTaxRatesStatus', ['as' => 'tax-rates.update_status']);
        $routes->get('group/(:num)', 'TaxRates::taxRates/$1', ['as' => 'tax-rates.group']);
        // Add other tax rate-related actions as needed
    });

    // Product Variations
    $routes->group('variations', ['namespace' => '\Products\Controllers'], function ($routes) {
        $routes->get('', 'Variations::variations', ['as' => 'variations.index']);
        $routes->get('add', 'Variations::addVariations', ['as' => 'variations.add']);
        $routes->post('store', 'Variations::storeVariations', ['as' => 'variations.store']);
        $routes->get('edit/(:num)', 'Variations::editVariations/$1', ['as' => 'variations.edit']);
        $routes->post('update/(:num)', 'Variations::updateVariations/$1', ['as' => 'variations.update']);
        $routes->get('delete/(:num)', 'Variations::deleteVariations/$1', ['as' => 'variations.delete']);
        $routes->post('update_status', 'Variations::updateVariationsStatus', ['as' => 'variations.update_status']);
        // Add other variation-related actions as needed
    });

    // Routes for variation values
    $routes->group('variation-values', ['namespace' => '\Products\Controllers'], function ($routes) {
        $routes->get('', 'VariationValues::variationValues', ['as' => 'variation-values.index']);
        $routes->get('add/(:num)', 'VariationValues::addVariationValues/$1', ['as' => 'variation-values.add']);
        $routes->post('store/(:num)', 'VariationValues::storeVariationValues/$1', ['as' => 'variation-values.store']);
        $routes->get('list/(:num)/edit/(:num)', 'VariationValues::editVariationValues/$1/$2', ['as' => 'variation-values.edit']);
        $routes->post('list/(:num)/update/(:num)', 'VariationValues::updateVariationValues/$1/$2', ['as' => 'variation-values.update']);
        $routes->get('delete/(:num)/(:num)', 'VariationValues::deleteVariationValues/$1/$2', ['as' => 'variation-values.delete']);
        $routes->post('update_status', 'VariationValues::updateVariationValuesStatus', ['as' => 'variation-values.update_status']);
        $routes->get('list/(:num)', 'VariationValues::variationValues/$1', ['as' => 'variation-values.list']);
        // Add other variation value related actions as needed
    });

});