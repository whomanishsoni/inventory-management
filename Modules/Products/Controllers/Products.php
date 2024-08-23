<?php
namespace Products\Controllers;

use App\Controllers\AdminBaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\RolePermissionModel;
use Products\Models\ProductsModel;
use Products\Models\ProductVariationsModel;
use Products\Models\BrandsModel;
use Products\Models\UnitsModel;
use Products\Models\CategoriesModel;
use Products\Models\SubCategoriesModel;
use Products\Models\VariationsModel;
use Products\Models\VariationValuesModel;
use Products\Models\TaxGroupsModel;
use Products\Models\TaxRatesModel;

class Products extends AdminBaseController
{

    public $title = 'Products Management';
    public $menu = 'products';

    public function products()
    {
        $listProducts = (new ProductsModel())
            ->join('brands', 'brands.id = products.brand_id')
            ->join('units', 'units.id = products.unit_id')
            ->join('categories', 'categories.id = products.category_id')
            ->join('sub_categories', 'sub_categories.id = products.sub_category_id', 'left')
            ->select('products.*, brands.brand_name , units.unit_abbreviation , categories.category_name , sub_categories.sub_category_name')
            ->findAll();

        $this->updatePageData(['submenu' => 'Product List']);
        return view('Products\Views\products\list', compact('listProducts'));
    }

    public function getProductsDetails($id)
    {
        $productModel = new ProductsModel();
        $product = $productModel
            ->join('brands', 'brands.id = products.brand_id')
            ->join('units', 'units.id = products.unit_id')
            ->join('categories', 'categories.id = products.category_id')
            ->join('sub_categories', 'sub_categories.id = products.sub_category_id', 'left')
            ->join('tax_groups', 'tax_groups.id = products.tax_group_id', 'left')
            ->select('products.*, brands.brand_name, units.unit_abbreviation, categories.category_name, sub_categories.sub_category_name, tax_groups.tax_group_name')
            ->find($id);

        return view('Products\Views\products\single_product_details', compact('product'));
    }
    public function getProductVariations($id)
    {
        $productModel = new ProductsModel();
        $productVariationsModel = new ProductVariationsModel();

        $product = $productModel
            ->join('brands', 'brands.id = products.brand_id')
            ->join('units', 'units.id = products.unit_id')
            ->join('categories', 'categories.id = products.category_id')
            ->join('sub_categories', 'sub_categories.id = products.sub_category_id', 'left')
            ->select('products.*, brands.brand_name , units.unit_abbreviation , categories.category_name , sub_categories.sub_category_name')
            ->find($id);

        $variations = $productVariationsModel->join('brands', 'brands.id = product_variations.variation_brand_id')
            ->join('units', 'units.id = product_variations.variation_unit_id')
            ->join('categories', 'categories.id = product_variations.variation_category_id')
            ->join('sub_categories', 'sub_categories.id = product_variations.variation_sub_category_id', 'left')
            ->join('variations', 'variations.id = product_variations.variation_id')
            ->join('variation_values', 'variation_values.id = product_variations.variation_value_id')
            ->select('product_variations.*, variations.variation_name AS variation_name, variation_values.variation_value AS variation_value,brands.brand_name AS variation_brand_name, units.unit_abbreviation AS variation_unit_abbreviation, categories.category_name AS variation_category_name, sub_categories.sub_category_name AS variation_sub_category_name')
            ->where('product_variations.product_id', $id)
            ->findAll();

        return view('Products\Views\products\variation_product_details', compact('product', 'variations'));
    }

    public function addProducts()
    {
        if (!$this->hasPermission('products_add')) {
            return redirect()->to(route_to('products.index'))->with('error', 'Permission Denied');
        }

        $sku_code = $this->generateSKU();

        $brandModel = new BrandsModel();
        $unitModel = new UnitsModel();
        $categoryModel = new CategoriesModel();
        $variationModel = new VariationsModel();
        $taxGroupModel = new TaxGroupsModel();

        $activeEntities = [
            'brands' => $brandModel->where('brand_status', 'active')->findAll(),
            'units' => $unitModel->where('unit_status', 'active')->findAll(),
            'categories' => $categoryModel->where('category_status', 'active')->findAll(),
            'variations' => $variationModel->where('variation_status', 'active')->findAll(),
            'tax_groups' => $taxGroupModel->where('tax_group_status', 'active')->orderBy('tax_group_name', 'desc')->findAll(),
            'sku_code' => $sku_code,
        ];

        $this->updatePageData(['submenu' => 'Add New Product']);
        return view('Products\Views\products\add', $activeEntities);
    }

    public function storeProducts()
    {
        if (!$this->hasPermission('products_add')) {
            return redirect()->to(route_to('products.index'))->with('error', 'Permission Denied');
        }

        // Basic validation rules
        $validationRules = [
            'product_name' => 'required',
            'brand_id' => 'required',
            'unit_id' => 'required',
            'category_id' => 'required',
            'product_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Products\Views\products\add', ['validation' => $this->validator]);
        }

        // Prepare product data
        $productName = strtolower($this->request->getPost('product_name'));
        $productData = [
            'sku_code' => strtolower($this->request->getPost('sku_code')),
            'product_name' => $productName,
            'brand_id' => $this->request->getPost('brand_id'),
            'unit_id' => $this->request->getPost('unit_id'),
            'category_id' => $this->request->getPost('category_id'),
            'sub_category_id' => $this->request->getPost('sub_category_id'),
            'tax_group_id' => $this->request->getPost('tax_group_id'),
            'buying_price' => $this->request->getPost('buying_price'),
            'customer_price' => $this->request->getPost('customer_price'),
            'tax_amount' => $this->request->getPost('tax_amount'),
            'sale_price' => $this->request->getPost('sale_price'),
            'product_status' => $this->request->getPost('product_status'),
            'has_variation' => '0',
        ];

        $productModel = new ProductsModel();
        $productId = $productModel->insert($productData);

        // Check if variations are selected
        $variationIds = $this->request->getPost('variation_id') ?? null;

        if ($variationIds) {
            $variationSkuCodes = $this->request->getPost('variation_sku_code');
            $variationProductNames = $this->request->getPost('variation_product_name');
            $variationValues = $this->request->getPost('variation_values');
            $variationBuyingPrices = $this->request->getPost('variation_buying_price');
            $variationCustomerPrices = $this->request->getPost('variation_customer_price');
            $variationSalePrices = $this->request->getPost('variation_sale_price');
            $variationTaxGroupIds = $this->request->getPost('variation_tax_group_id');
            $variationTaxAmounts = $this->request->getPost('variation_tax_amount');
            $productVariationsModel = new ProductVariationsModel();

            // Ensure each variation is processed correctly
            $totalVariationValues = count($variationValues);

            // Check for mismatch in variation IDs and values

            if (is_array($variationIds) && count($variationIds) !== $totalVariationValues) {
                throw new \Exception('Mismatch in variation IDs and values');
            }

            for ($i = 0; $i < $totalVariationValues; $i++) {
                // Check if the variation ID is set
                if (isset($variationIds[$i])) {
                    $variationId = $variationIds[$i];
                }
                // Skip variations with missing essential fields
                if (
                    empty($variationSkuCodes[$i]) ||
                    empty($variationProductNames[$i]) ||
                    empty($variationValues[$i]) ||
                    empty($variationBuyingPrices[$i]) ||
                    empty($variationCustomerPrices[$i]) ||
                    empty($variationSalePrices[$i])
                ) {
                    continue; // Skip this iteration if any essential field is empty
                }
                $variationData = [
                    'product_id' => $productId,
                    'variation_sku_code' => isset($variationSkuCodes[$i]) ? $variationSkuCodes[$i] : '',
                    'variation_product_name' => isset($variationProductNames[$i]) ? $variationProductNames[$i] : '',
                    'variation_id' => $variationId,
                    'variation_value_id' => $variationValues[$i],
                    'variation_brand_id' => $this->request->getPost('brand_id'),
                    'variation_unit_id' => $this->request->getPost('unit_id'),
                    'variation_category_id' => $this->request->getPost('category_id'),
                    'variation_sub_category_id' => $this->request->getPost('sub_category_id'),
                    'variation_tax_group_id' => isset($variationTaxGroupIds[$i]) ? $variationTaxGroupIds[$i] : '',
                    'variation_buying_price' => isset($variationBuyingPrices[$i]) ? $variationBuyingPrices[$i] : '',
                    'variation_customer_price' => isset($variationCustomerPrices[$i]) ? $variationCustomerPrices[$i] : '',
                    'variation_tax_amount' => isset($variationTaxAmounts[$i]) ? $variationTaxAmounts[$i] : '',
                    'variation_sale_price' => isset($variationSalePrices[$i]) ? $variationSalePrices[$i] : '',
                    'product_variation_status' => 'active',
                ];

                $productVariationsModel->insert($variationData);
            }

            $productModel->update($productId, ['has_variation' => '1']);
        }

        return redirect()->to(route_to('products.index'))->with('notifySuccess', 'Product Added Successfully');
    }

    // public function storeProducts()
    // {
    //     if (!$this->hasPermission('products_add')) {
    //         return redirect()->to(route_to('products.index'))->with('error', 'Permission Denied');
    //     }

    //     // Basic validation rules
    //     $validationRules = [
    //         'product_name' => 'required',
    //         'brand_id' => 'required',
    //         'unit_id' => 'required',
    //         'category_id' => 'required',
    //         'product_status' => 'required|in_list[active,inactive]',
    //     ];

    //     if (!$this->validate($validationRules)) {
    //         return view('Products\Views\products\add', ['validation' => $this->validator]);
    //     }

    //     // Prepare product data
    //     $productName = strtolower($this->request->getPost('product_name'));
    //     $productData = [
    //         'sku_code' => $this->generateSKU(),
    //         'product_name' => $productName,
    //         'brand_id' => $this->request->getPost('brand_id'),
    //         'unit_id' => $this->request->getPost('unit_id'),
    //         'category_id' => $this->request->getPost('category_id'),
    //         'sub_category_id' => $this->request->getPost('sub_category_id'),
    //         'tax_group_id' => $this->request->getPost('tax_group_id'),
    //         'buying_price' => $this->request->getPost('buying_price'),
    //         'customer_price' => $this->request->getPost('customer_price'),
    //         'tax_amount' => $this->request->getPost('tax_amount'),
    //         'sale_price' => $this->request->getPost('sale_price'),
    //         'product_status' => $this->request->getPost('product_status'),
    //         'has_variation' => '0',
    //     ];

    //     $productModel = new ProductsModel();
    //     $productId = $productModel->insert($productData);

    //     // Check if a variation is selected
    //     $variationId = $this->request->getPost('variation_id');
    //     if ($variationId) {
    //         $variationValues = $this->request->getPost('variation_values_id');
    //         $variationBuyingPrices = $this->request->getPost('variation_buying_price');
    //         $variationCustomerPrices = $this->request->getPost('variation_customer_price');
    //         $variationSalePrices = $this->request->getPost('variation_sale_price');
    //         $variationTaxGroupId = $this->request->getPost('variation_tax_group_id');

    //         $productVariationsModel = new ProductVariationsModel();
    //         $variationValuesModel = new VariationValuesModel();

    //         foreach ($variationValues as $key => $variationValueId) {
    //             $variationValue = strtolower($variationValuesModel->find($variationValueId)->variation_value);
    //             $variationProductName = $productName . ' - ' . $variationValue;

    //             $variationData = [
    //                 'variation_sku_code' => $this->generateSKU(),
    //                 'variation_product_name' => $variationProductName,
    //                 'product_id' => $productId,
    //                 'variation_id' => $variationId,
    //                 'variation_value_id' => $variationValueId,
    //                 'variation_brand_id' => $this->request->getPost('brand_id'),
    //                 'variation_unit_id' => $this->request->getPost('unit_id'),
    //                 'variation_category_id' => $this->request->getPost('category_id'),
    //                 'variation_sub_category_id' => $this->request->getPost('sub_category_id'),
    //                 'variation_tax_group_id' => $variationTaxGroupId[$key],
    //                 'variation_buying_price' => $variationBuyingPrices[$key],
    //                 'variation_customer_price' => $variationCustomerPrices[$key],
    //                 'variation_sale_price' => $variationSalePrices[$key],
    //             ];

    //             $productVariationsModel->insert($variationData);
    //         }

    //         $productModel->update($productId, ['has_variation' => '1']);
    //     }

    //     return redirect()->to(route_to('products.index'))->with('notifySuccess', 'Product Added Successfully');
    // }

    public function editProducts($id)
    {
        if (!$this->hasPermission('products_edit')) {
            return redirect()->to(route_to('products.index'))->with('error', 'Permission Denied');
        }

        // Load the necessary models
        $productModel = new ProductsModel();
        $productVariationsModel = new ProductVariationsModel();
        $brandModel = new BrandsModel();
        $unitModel = new UnitsModel();
        $categoryModel = new CategoriesModel();
        $subCategoryModel = new SubCategoriesModel();
        $variationModel = new VariationsModel();
        $variationValuesModel = new VariationValuesModel();
        $taxGroupModel = new TaxGroupsModel();

        // Fetch product data
        $product = $productModel->find($id);

        if (!$product) {
            return redirect()->to(route_to('products.index'))->with('error', 'Product not found');
        }

        // Fetch product variations
        $productVariations = $productVariationsModel->where('product_id', $id)->findAll();

        // Fetch related data
        $activeEntities = [
            'product' => $product,
            'product_variations' => $productVariations,
            'brands' => $brandModel->where('brand_status', 'active')->findAll(),
            'units' => $unitModel->where('unit_status', 'active')->findAll(),
            'categories' => $categoryModel->where('category_status', 'active')->findAll(),
            'variations' => $variationModel->where('variation_status', 'active')->findAll(),
            'variation_values' => $variationValuesModel->where('variation_value_status', 'active')->findAll(),
            'tax_groups' => $taxGroupModel->where('tax_group_status', 'active')->orderBy('tax_group_name', 'desc')->findAll(),
            'sub_categories' => $subCategoryModel->where('category_id', $product->category_id)->findAll(),
        ];

        $this->updatePageData(['submenu' => 'Edit Product']);

        return view('Products\Views\products\edit', $activeEntities);
    }

    public function updateProducts($id)
    {
        // Get the product data from the request
        $productName = $this->request->getPost('product_name');
        $skuCode = $this->request->getPost('sku_code');
        $brandId = $this->request->getPost('brand_id');
        $unitId = $this->request->getPost('unit_id');
        $categoryId = $this->request->getPost('category_id');
        $subCategoryId = $this->request->getPost('sub_category_id');
        $taxGroupId = $this->request->getPost('tax_group_id');
        $buyingPrice = $this->request->getPost('buying_price');
        $customerPrice = $this->request->getPost('customer_price');
        $taxAmount = $this->request->getPost('tax_amount');
        $salePrice = $this->request->getPost('sale_price');
        $hasVariation = $this->request->getPost('has_variation');

        // Create an array of product data
        $productData = [
            'product_name' => $productName,
            'sku_code' => $skuCode,
            'brand_id' => $brandId,
            'unit_id' => $unitId,
            'category_id' => $categoryId,
            'sub_category_id' => $subCategoryId,
            'tax_group_id' => $taxGroupId,
            'buying_price' => $buyingPrice,
            'customer_price' => $customerPrice,
            'tax_amount' => $taxAmount,
            'sale_price' => $salePrice,
            'has_variation' => $hasVariation,
        ];

        // Update the product in the database
        $productModel = new ProductsModel();
        $productModel->update($id, $productData);

        // Check if variations are selected
        $variationIds = $this->request->getPost('variation_id') ?? null;

        if ($variationIds) {
            $variationSkuCodes = $this->request->getPost('variation_sku_code');
            $variationProductNames = $this->request->getPost('variation_product_name');
            $variationValues = $this->request->getPost('variation_values');
            $variationBuyingPrices = $this->request->getPost('variation_buying_price');
            $variationCustomerPrices = $this->request->getPost('variation_customer_price');
            $variationSalePrices = $this->request->getPost('variation_sale_price');
            $variationTaxGroupIds = $this->request->getPost('variation_tax_group_id');
            $variationTaxAmounts = $this->request->getPost('variation_tax_amount');

            $productVariationsModel = new ProductVariationsModel();
            $totalVariationValues = count($variationIds);
            if (is_array($variationIds) && count($variationIds) !== $totalVariationValues) {
                throw new \Exception('Mismatch in variation IDs and values');

            }
            for ($i = 0; $i < $totalVariationValues; $i++) {
                // Prepare variation data for the current index

                if (isset($variationIds[$i])) {
                    $variationId = $variationIds[$i];
                }
                $variationData = [
                    'product_id' => $id,
                    'variation_sku_code' => $variationSkuCodes[$i] ?? '',
                    'variation_product_name' => $variationProductNames[$i] ?? '',
                    'variation_brand_id' => $this->request->getPost('brand_id'),
                    'variation_unit_id' => $this->request->getPost('unit_id'),
                    'variation_category_id' => $this->request->getPost('category_id'),
                    'variation_sub_category_id' => $this->request->getPost('sub_category_id'),
                    'variation_tax_group_id' => $variationTaxGroupIds[$i] ?? '',
                    'variation_buying_price' => $variationBuyingPrices[$i] ?? '',
                    'variation_customer_price' => $variationCustomerPrices[$i] ?? '',
                    'variation_tax_amount' => $variationTaxAmounts[$i] ?? '',
                    'variation_sale_price' => $variationSalePrices[$i] ?? '',
                    'product_variation_status' => $this->request->getPost('product_variation_status')[$i] ?? 'active',
                ];

                //   dd($variationData);
                // Find existing variations that match the current variation ID and product ID
                $existingVariations = $productVariationsModel->where([
                    'product_id' => $id,
                    'variation_id' => $variationId,
                ])->find();
                //    dd($existingVariations);
                // Update or insert the variation data
                if (!empty($existingVariations)) {
                    foreach ($existingVariations as $existingVariation) {
                        $productVariationsModel->update($existingVariation->id, $variationData);
                    }
                } else {
                    $productVariationsModel->insert($variationData);
                }
            }

            // Update the product to indicate it has variations
            $productModel->update($id, ['has_variation' => '1']);
        }

        // Redirect after processing all variations
        return redirect()->to(route_to('products.index'))->with('notifySuccess', 'Product Updated Successfully');

    }


    public function deleteProducts($id)
    {
        if (!$this->hasPermission('products_delete')) {
            return redirect()->to(route_to('products.index'))->with('error', 'Permission Denied');
        }

        $productModel = new ProductsModel();
        $product = $productModel->find($id);

        if ($product->has_variation == 1) {
            $productVariationsModel = new ProductVariationsModel();
            $productVariationsModel->where('product_id', $id)->delete();
        }

        $productModel->delete($id);

        return redirect()->to(route_to('products.index'))->with('notifySuccess', 'Product Deleted Successfully');
    }
    public function updateProductsStatus()
    {
        $productId = $this->request->getPost('id');
        $newStatus = $this->request->getPost('product_status');

        try {
            if (empty($productId) || !is_numeric($productId) || empty($newStatus)) {
                throw new \Exception('Invalid input data');
            }
            $model = new ProductsModel();
            $model->update($productId, ['product_status' => $newStatus]);

            return $this->response->setJSON(['success' => true, 'message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            log_message('error', 'Failed to update status: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'An error occurred while updating status']);
        }
    }

    private function generateSKU()
    {
        $sku_code = rand(10000, 99999);
        return $sku_code;
    }

    public function getSubCategories()
    {
        $categoryId = $this->request->getGet('category_id');

        $subCategoriesModel = new SubCategoriesModel();
        $subCategories = $subCategoriesModel->where('category_id', $categoryId)
            ->where('sub_category_status', 'active')
            ->findAll();
        return $this->response->setJSON($subCategories);
    }

    public function getVariationValues()
    {
        $variationId = $this->request->getGet('variation_id');

        $variationValuesModel = new VariationValuesModel();
        $variationValues = $variationValuesModel->where('variation_id', $variationId)
            ->where('variation_value_status', 'active')
            ->findAll();
        return $this->response->setJSON($variationValues);
    }

    public function getTaxRate()
    {
        $taxGroupId = $this->request->getPost('tax_group_id');
        $taxRatesModel = new TaxRatesModel();
        $taxRates = $taxRatesModel->where('group_id', $taxGroupId)->findAll();

        if (!empty($taxRates)) {

            $salePrice = $this->request->getPost('customer_price');
            $totalTaxAmount = 0;

            foreach ($taxRates as $taxRate) {
                $taxAmount = ($salePrice * $taxRate->tax_rate) / 100;
                $totalTaxAmount += $taxAmount;
            }

            $totalTaxAmount = round($totalTaxAmount);

            return $this->response->setJSON(['total_tax_amount' => $totalTaxAmount]);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'No tax rates found']);
        }
    }

    public function hasPermission($permission)
    {
        // Implement your permission checking logic here
        // Example: Check if the logged-in user has the specified permission
        // You can use your authentication and authorization logic or a library
        // For example, you might have a 'Roles' and 'Permissions' system in your database

        // Replace the logic below with your actual permission check
        $allowedPermissions = [
            'products_list',
            'products_add',
            'products_edit',
            'products_delete',
        ];

        return in_array($permission, $allowedPermissions);
    }

}