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
        ->select('products.*, brands.brand_name , units.unit_name , categories.category_name , sub_categories.sub_category_name')
        ->findAll();

        $this->updatePageData(['submenu' => 'Product List']);
        return view('Products\Views\products\list', compact('listProducts'));
    }

    private function generateSKU()
    {
        $prefix = 'SKU';
        $sku_code = $prefix . date('YmdHis') . rand(1000, 9999);
        return $sku_code;
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
    
        $validationRules = [
            'product_name' => 'required',
            'brand_id' => 'required',
            'unit_id' => 'required',
            'category_id' => 'required',
            // 'buying_price' => 'required',
            // 'customer_price' => 'required',
            // 'tax_group_id' => 'required',
            'product_status' => 'required|in_list[active,inactive]',
        ];
    
        if (!$this->validate($validationRules)) {
            return view('Products\Views\products\add', ['validation' => $this->validator]);
        }
    
        // Insert product into products table
        $productModel = new ProductsModel();
        $productData = [
            'sku_code' => $this->request->getPost('sku_code'),
            'product_name' => $this->request->getPost('product_name'),
            'brand_id' => $this->request->getPost('brand_id'),
            'unit_id' => $this->request->getPost('unit_id'),
            'category_id' => $this->request->getPost('category_id'),
            'sub_category_id' => $this->request->getPost('sub_category_id'),
            'tax_group_id' => $this->request->getPost('tax_group_id'),
            'buying_price' => $this->request->getPost('buying_price'),
            'customer_price' => $this->request->getPost('customer_price'),
            'sale_price' => $this->request->getPost('sale_price'),
            'product_status' => $this->request->getPost('product_status'),
            'has_variation' => '0',
        ];
        // dd($productData); // Debug product data
        $productId = $productModel->insert($productData);
        // dd($productId); // Debug product ID
    
        // Check if a variation is selected
        $variationId = $this->request->getPost('variation_id');
        if ($variationId) {
            // Insert product variations into product_variations table
            $variationValues = $this->request->getPost('variation_values_id');
            $variationBuyingPrices = $this->request->getPost('variation_buying_price');
            $variationCustomerPrices = $this->request->getPost('variation_customer_price');
            $variationSalePrices = $this->request->getPost('variation_sale_price');
            $variationTaxGroupId = $this->request->getPost('variation_tax_group_id');
            // dd($variationValues, $variationBuyingPrices, $variationCustomerPrices, $variationSalePrices, $variationTaxGroupId);
            $productVariationsModel = new ProductVariationsModel();
            foreach ($variationValues as $key => $variationValue) {
                $variationData = [
                    'product_name' => $productData['product_name'],
                    'product_id' => $productId,
                    'variation_id' => $variationId,
                    'variation_value_id' => $variationValue,
                    'variation_buying_price' => $variationBuyingPrices[$key],
                    'variation_customer_price' => $variationCustomerPrices[$key],
                    'variation_sale_price' => $variationSalePrices[$key],
                    'variation_tax_group_id' => $variationTaxGroupId[$key],
                ];
                // dd($variationData);
                $productVariationsModel->insert($variationData);
            }
            $productModel->update($productId, ['has_variation' => '1']);
        }
    
        return redirect()->to(route_to('products.index'))->with('notifySuccess', 'Product Added Successfully');
    }

    public function editProducts($id)
    {
        if (!$this->hasPermission('products_edit')) {
            return redirect()->to(route_to('products.index'))->with('error', 'Permission Denied');
        }
    
        $productModel = new ProductsModel();
        $product = $productModel->find($id);
    
        if (!$product) {
            // Handle case where product with given ID is not found
            return redirect()->to(route_to('products.index'))->with('error', 'Product not found');
        }
    
        $brandModel = new BrandsModel();
        $unitModel = new UnitsModel();
        $categoryModel = new CategoriesModel();
        $variationModel = new VariationsModel();
        
        $activeEntities = [
            'product' => $product,
            'brands' => $brandModel->where('brand_status', 'active')->findAll(),
            'units' => $unitModel->where('unit_status', 'active')->findAll(),
            'categories' => $categoryModel->where('category_status', 'active')->findAll(),
            'variations' => $variationModel->where('variation_status', 'active')->findAll(),
        ];
        
        $this->updatePageData(['submenu' => 'Edit Product']);
        return view('Products\Views\products\edit', $activeEntities);
    }
    

    public function updateProducts($id)
    {
        if (!$this->hasPermission('products_edit')) {
            return redirect()->to(route_to('products.index'))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'product_name' => 'required',
            'product_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Products\Views\products\edit', ['validation' => $this->validator, 'product' => (new ProductsModel())->find($id)]);
        }

        $data = [
            'product_name' => $this->request->getPost('product_name'),
            'product_status' => $this->request->getPost('product_status'),
        ];

        (new ProductsModel())->update($id, $data);

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