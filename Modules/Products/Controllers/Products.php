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

class Products extends AdminBaseController {

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
            ->select('products.*, brands.brand_name , units.unit_abbreviation , categories.category_name , sub_categories.sub_category_name')
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
    
        // Check if a single variation and its values are selected
        $variationId = $this->request->getPost('variation_id');
        if ($variationId) {
            $variationValues = $this->request->getPost('variation_values');
            $variationSkuCodes = $this->request->getPost('variation_sku_code');
            $variationProductNames = $this->request->getPost('variation_product_name');
            $variationBuyingPrices = $this->request->getPost('variation_buying_price');
            $variationCustomerPrices = $this->request->getPost('variation_customer_price');
            $variationSalePrices = $this->request->getPost('variation_sale_price');
            $variationTaxGroupIds = $this->request->getPost('variation_tax_group_id');
            $variationTaxAmounts = $this->request->getPost('variation_tax_amount');
    
            $totalVariationValues = count($variationValues);
            $productVariationsModel = new ProductVariationsModel();
    
            for ($i = 0; $i < $totalVariationValues; $i++) {
                // Check if all necessary fields are set for the current index
                if (!isset($variationSkuCodes[$i], $variationProductNames[$i], $variationBuyingPrices[$i], $variationCustomerPrices[$i], $variationSalePrices[$i], $variationTaxGroupIds[$i], $variationTaxAmounts[$i])) {
                    continue; // Skip this iteration if any field is missing
                }
    
                // Check if this variation already exists for the product
                $existingVariation = $productVariationsModel->where([
                    'product_id' => $productId,
                    'variation_value_id' => $variationValues[$i],
                    'variation_id' => $variationId
                ])->first();
    
                if (!$existingVariation) {
                    // Create each variation value entry if it does not already exist
                    $variationData = [
                        'product_id' => $productId,
                        'variation_sku_code' => strtolower($variationSkuCodes[$i]),
                        'variation_product_name' => strtolower($variationProductNames[$i]),
                        'variation_id' => $variationId,
                        'variation_value_id' => $variationValues[$i],
                        'variation_brand_id' => $this->request->getPost('brand_id'),
                        'variation_unit_id' => $this->request->getPost('unit_id'),
                        'variation_category_id' => $this->request->getPost('category_id'),
                        'variation_sub_category_id' => $this->request->getPost('sub_category_id'),
                        'variation_tax_group_id' => $variationTaxGroupIds[$i],
                        'variation_buying_price' => $variationBuyingPrices[$i],
                        'variation_customer_price' => $variationCustomerPrices[$i],
                        'variation_tax_amount' => $variationTaxAmounts[$i],
                        'variation_sale_price' => $variationSalePrices[$i],
                        'variation_product_status' => 'active',
                    ];
    
                    $productVariationsModel->insert($variationData);
                }
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

        // Fetch related variation values only for the specific product variations
        $variationValueIds = array_column($productVariations, 'variation_value_id');
        $specificVariationValues = $variationValuesModel->whereIn('id', $variationValueIds)->where('variation_value_status', 'active')->findAll();
    
        // Fetch detailed product variations
        $productVariations = $productVariationsModel
        ->join('brands', 'brands.id = product_variations.variation_brand_id')
        ->join('units', 'units.id = product_variations.variation_unit_id')
        ->join('categories', 'categories.id = product_variations.variation_category_id')
        ->join('sub_categories', 'sub_categories.id = product_variations.variation_sub_category_id', 'left')
        ->join('variations', 'variations.id = product_variations.variation_id')
        ->join('variation_values', 'variation_values.id = product_variations.variation_value_id')
        ->select('product_variations.*, variations.variation_name AS variation_name, variation_values.variation_value AS variation_value, brands.brand_name AS variation_brand_name, units.unit_abbreviation AS variation_unit_abbreviation, categories.category_name AS variation_category_name, sub_categories.sub_category_name AS variation_sub_category_name')
        ->where('product_variations.product_id', $id)
        ->findAll();

        // Fetch related data
        $activeEntities = [
            'product' => $product,
            'product_variations' => $productVariations,
            'brands' => $brandModel->where('brand_status', 'active')->findAll(),
            'units' => $unitModel->where('unit_status', 'active')->findAll(),
            'categories' => $categoryModel->where('category_status', 'active')->findAll(),
            'variations' => $variationModel->where('variation_status', 'active')->findAll(),
            'variation_values' => $specificVariationValues,
            'tax_groups' => $taxGroupModel->where('tax_group_status', 'active')->orderBy('tax_group_name', 'desc')->findAll(),
            'sub_categories' => $subCategoryModel->where('category_id', $product->category_id)->findAll(),
        ];

        // dd($activeEntities['product_variations']);
    
        $this->updatePageData(['submenu' => 'Edit Product']);
    
        return view('Products\Views\products\edit', $activeEntities);
    }
    
    // public function updateProducts($id)
    // {
    //     if (!$this->hasPermission('products_edit')) {
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
    //         return redirect()->back()->with('validation', $this->validator)->withInput();
    //     }
    
    //     // Prepare product data
    //     $productName = strtolower($this->request->getPost('product_name'));
    //     $productData = [
    //         'sku_code' => strtolower($this->request->getPost('sku_code')),
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
    //     ];
    
    //     $productModel = new ProductsModel();
    //     $productModel->update($id, $productData);
    
    //     // Check if variations are selected
    //     $variationIds = $this->request->getPost('variation_id');
    //     if ($variationIds) {
    //         $variationSkuCodes = $this->request->getPost('variation_sku_code');
    //         $variationProductNames = $this->request->getPost('variation_product_name');
    //         $variationValues = $this->request->getPost('variation_values');
    //         $variationBuyingPrices = $this->request->getPost('variation_buying_price');
    //         $variationCustomerPrices = $this->request->getPost('variation_customer_price');
    //         $variationSalePrices = $this->request->getPost('variation_sale_price');
    //         $variationTaxGroupIds = $this->request->getPost('variation_tax_group_id');
    //         $variationTaxAmounts = $this->request->getPost('variation_tax_amount');
    
    //         $productVariationsModel = new ProductVariationsModel();
    
    //         // First, delete the existing variations
    //         $productVariationsModel->where('product_id', $id)->delete();
    
    //         // Then, insert the new variations
    //         $totalVariationValues = count($variationValues);
    
    //         for ($i = 0; $i < $totalVariationValues; $i++) {
    //             // Create each variation entry
    //             $variationData = [
    //                 'product_id' => $id,
    //                 'variation_sku_code' => strtolower($variationSkuCodes[$i]),
    //                 'variation_product_name' => strtolower($variationProductNames[$i]),
    //                 'variation_id' => $variationIds[$i % count($variationIds)],
    //                 'variation_value_id' => $variationValues[$i],
    //                 'variation_brand_id' => $this->request->getPost('brand_id'),
    //                 'variation_unit_id' => $this->request->getPost('unit_id'),
    //                 'variation_category_id' => $this->request->getPost('category_id'),
    //                 'variation_sub_category_id' => $this->request->getPost('sub_category_id'),
    //                 'variation_tax_group_id' => $variationTaxGroupIds[$i],
    //                 'variation_buying_price' => $variationBuyingPrices[$i],
    //                 'variation_customer_price' => $variationCustomerPrices[$i],
    //                 'variation_tax_amount' => $variationTaxAmounts[$i],
    //                 'variation_sale_price' => $variationSalePrices[$i],
    //                 'product_variation_status' => 'active',
    //             ];
    
    //             $productVariationsModel->insert($variationData);
    //         }
    
    //         $productModel->update($id, ['has_variation' => '1']);
    //     } else {
    //         $productModel->update($id, ['has_variation' => '0']);
    //     }
    
    //     return redirect()->to(route_to('products.index'))->with('notifySuccess', 'Product Updated Successfully');
    // }  

    public function updateProducts($id)
{
    if (!$this->hasPermission('products_edit')) {
        return redirect()->to(route_to('products.index'))->with('error', 'Permission Denied');
    }

    // Initialize models
    $productModel = new ProductsModel();
    $productVariationsModel = new ProductVariationsModel();

    // Basic validation rules
    $validationRules = [
        'product_name' => 'required',
        'brand_id' => 'required|integer',
        'unit_id' => 'required|integer',
        'category_id' => 'required|integer',
        'sub_category_id' => 'permit_empty|integer',
        // 'product_status' => 'required|in_list[active,inactive]',
        'buying_price' => 'required|numeric',
        'customer_price' => 'required|numeric',
        'tax_amount' => 'required|numeric',
        'sale_price' => 'required|numeric',
    ];

    if (!$this->validate($validationRules)) {
        return redirect()->back()->with('validation', $this->validator)->withInput();
    }

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
    ];

    $productModel->update($id, $productData);

    $variationIds = $this->request->getPost('variation_id');

    if ($variationIds) {
        $variationSkuCodes = $this->request->getPost('variation_sku_code');
        $variationProductNames = $this->request->getPost('variation_product_name');
        $variationValues = $this->request->getPost('variation_values');
        $variationBuyingPrices = $this->request->getPost('variation_buying_price');
        $variationCustomerPrices = $this->request->getPost('variation_customer_price');
        $variationSalePrices = $this->request->getPost('variation_sale_price');
        $variationTaxGroupIds = $this->request->getPost('variation_tax_group_id');
        $variationTaxAmounts = $this->request->getPost('variation_tax_amount');
        $variationProductStatus = $this->request->getPost('variation_product_status');

        // Validate variations if they exist
        $totalVariationValues = count($variationValues);
        for ($i = 0; $i < $totalVariationValues; $i++) {
            if (empty($variationSkuCodes[$i]) || empty($variationProductNames[$i])) {
                return redirect()->back()->with('error', 'Variation SKU code and product name are required.')->withInput();
            }
        }

        // Delete existing variations first
        $productVariationsModel->where('product_id', $id)->delete();

        // Insert new variations
        for ($i = 0; $i < $totalVariationValues; $i++) {
            $variationData = [
                'product_id' => $id,
                'variation_sku_code' => strtolower($variationSkuCodes[$i]),
                'variation_product_name' => strtolower($variationProductNames[$i]),
                'variation_id' => $variationIds[$i % count($variationIds)],
                'variation_value_id' => $variationValues[$i],
                'variation_brand_id' => $this->request->getPost('brand_id'),
                'variation_unit_id' => $this->request->getPost('unit_id'),
                'variation_category_id' => $this->request->getPost('category_id'),
                'variation_sub_category_id' => $this->request->getPost('sub_category_id'),
                'variation_tax_group_id' => $variationTaxGroupIds[$i],
                'variation_buying_price' => $variationBuyingPrices[$i],
                'variation_customer_price' => $variationCustomerPrices[$i],
                'variation_tax_amount' => $variationTaxAmounts[$i],
                'variation_sale_price' => $variationSalePrices[$i],
                'variation_product_status' => $variationProductStatus[$i],
            ];

            $productVariationsModel->insert($variationData);
        }

        $productModel->update($id, ['has_variation' => '1']);
    } else {
        $productModel->update($id, ['has_variation' => '0']);
    }

    return redirect()->to(route_to('products.index'))->with('notifySuccess', 'Product Updated Successfully');
}



    public function deleteProducts($id)
    {
        if (!$this->hasPermission('products_delete')) {
            return redirect()->to(route_to('products.index'))->with('error', 'Permission Denied');
        }
        (new ProductsModel())->delete($id);

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