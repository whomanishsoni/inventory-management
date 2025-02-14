<?php
namespace Purchases\Controllers;

use App\Controllers\AdminBaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\RolePermissionModel;
use Purchases\Models\PurchasesModel;
use Purchases\Models\PurchaseItemsModel;
use Products\Models\ProductsModel;
use Products\Models\ProductVariationsModel;
use Products\Models\VariationValuesModel;
use Suppliers\Models\SuppliersModel;
use CodeIgniter\API\ResponseTrait;

class Purchases extends AdminBaseController
{

    public $title = 'Purchases Management';
    public $menu = 'purchases';

    public function purchases()
    {
        $listPurchases = (new PurchasesModel())
            ->join('suppliers', 'suppliers.id = purchases.supplier_id')
            ->select('purchases.*, suppliers.supplier_name')
            ->findAll();

        $this->updatePageData(['submenu' => 'Purchases List']);
        return view('Purchases\Views\purchases\list', compact('listPurchases'));
    }

    public function addPurchases()
    {
        if (!$this->hasPermission('purchases_add')) {
            return redirect()->to(route_to('purchases.index'))->with('error', 'Permission Denied');
        }
        $supplierModel = new SuppliersModel();

        $activeEntities = [
            'suppliers' => $supplierModel->where('supplier_status', 'active')->findAll(),
        ];

        $this->updatePageData(['submenu' => 'Add New Purchase']);
        return view('Purchases\Views\purchases\add', $activeEntities);
    }

    public function storePurchases()
    {
        if (!$this->hasPermission('purchases_add')) {
            return redirect()->to(route_to('purchases.index'))->with('error', 'Permission Denied');
        }

        $validationRules = [
            'supplier_id' => 'required|integer',
            'purchase_date' => 'required|valid_date',
            'payment_status' => 'required|in_list[paid,unpaid,partial]',
            'purchase_status' => 'required|in_list[received,pending]',
            'products.*.quantity' => 'required|integer|greater_than_equal_to[1]',
            'products.*.price' => 'required|numeric|greater_than_equal_to[0.01]',
            'total_amount' => 'required|numeric|greater_than_equal_to[0.01]',
            'paid_amount' => 'required|numeric|greater_than_equal_to[0]',
            'products.*.manufacture_date' => 'permit_empty|valid_date',
            'products.*.expiry_date' => 'permit_empty|valid_date',
            'remaining_amount' => 'required|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Products\Views\purchases\add', ['validation' => $this->validator]);
        }

        // Retrieve form data
        $supplierId = $this->request->getPost('supplier_id');
        $referenceNo = $this->request->getPost('reference_no');
        $purchaseDate = $this->request->getPost('purchase_date');
        $paymentStatus = $this->request->getPost('payment_status');
        $purchaseStatus = $this->request->getPost('purchase_status');
        $totalAmount = $this->request->getPost('total_amount');
        $paidAmount = $this->request->getPost('paid_amount');
        $remainingAmount = $this->request->getPost('remaining_amount');
        $products = $this->request->getPost('products');

        // Insert data into 'purchases' table
        $purchasesModel = new PurchasesModel();
        $purchaseData = [
            'supplier_id' => $supplierId,
            'reference_no' => $referenceNo,
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'remaining_amount' => $remainingAmount,
            'purchase_date' => $purchaseDate,
            'payment_status' => $paymentStatus,
            'purchase_status' => $purchaseStatus,
        ];

        $purchaseId = $purchasesModel->insert($purchaseData);

        $purchaseItemsModel = new PurchaseItemsModel();
        foreach ($products as $product) {
            $itemData = [
                'purchase_id' => $purchaseId,
                'product_id' => $product['product_id'],
                'product_name' => $product['product_name'],
                'sku_code' => $product['sku_code'],
                'variation_id' => $product['variation_id'] ?? null,
                'variation_value_id' => $product['variation_value_id'] ?? null,
                'quantity' => $product['quantity'],
                'unit_price' => $product['price'],
                'total_price' => $product['quantity'] * $product['price'],
                'manufacture_date' => $product['manufacture_date'] ?? null,
                'expiry_date' => $product['expiry_date'] ?? null,
            ];

            $purchaseItemsModel->insert($itemData);
        }

        return redirect()->to(route_to('purchases.index'))->with('notifySuccess', 'Purchase Added Successfully');
    }

    public function editPurchases($id)
    {
        if (!$this->hasPermission('purchases_edit')) {
            return redirect()->to(route_to('purchases.index'))->with('error', 'Permission Denied');
        }

        $purchasesModel = new PurchasesModel();
        $purchase = $purchasesModel->select('purchases.*, suppliers.supplier_name')
            ->join('suppliers', 'suppliers.id = purchases.supplier_id')
            ->where('purchases.id', $id)
            ->first();

        if (!$purchase) {
            return redirect()->to(route_to('purchases.index'))->with('error', 'Purchase not found');
        }

        $supplierModel = new SuppliersModel();
        $suppliers = $supplierModel->select('id, supplier_name')
            ->where('supplier_status', 'active')
            ->findAll();

        $purchaseItemsModel = new PurchaseItemsModel();
        // Modified query to include items without variations
        $purchaseItems = $purchaseItemsModel->select('purchase_items.*, variations.variation_name, variation_values.variation_value')
            ->join('variations', 'variations.id = purchase_items.variation_id', 'left') // Use 'left' join to include products without variations
            ->join('variation_values', 'variation_values.id = purchase_items.variation_value_id', 'left') // Use 'left' join to include products without variation values
            ->where('purchase_items.purchase_id', $id)
            ->findAll();

        $data = [
            'purchase' => $purchase,
            'purchaseItems' => $purchaseItems,
            'suppliers' => $suppliers,
        ];

        $this->updatePageData(['submenu' => 'Edit Purchase']);
        return view('Purchases\Views\purchases\edit', $data);
    }  
    
    public function updatePurchases($purchaseId)
    {
        if (!$this->hasPermission('purchases_edit')) {
            return redirect()->to(route_to('purchases.index'))->with('error', 'Permission Denied');
        }

        // Validation rules
        $validationRules = [
            'supplier_id' => 'required|integer',
            'reference_no' => 'required',
            'purchase_date' => 'required|valid_date',
            'payment_status' => 'required|in_list[paid,unpaid,partial]',
            'purchase_status' => 'required|in_list[received,pending]',
            'products.*.quantity' => 'required|integer|greater_than_equal_to[1]',
            'products.*.price' => 'required|numeric|greater_than_equal_to[0.01]',
            'total_amount' => 'required|numeric|greater_than_equal_to[0.01]',
            'paid_amount' => 'required|numeric|greater_than_equal_to[0]',
            'products.*.manufacture_date' => 'permit_empty|valid_date',
            'products.*.expiry_date' => 'permit_empty|valid_date',
            'remaining_amount' => 'required|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Purchases\Views\purchases\edit', ['validation' => $this->validator]);
        }

        // Retrieve form data
        $supplierId = $this->request->getPost('supplier_id');
        $referenceNo = $this->request->getPost('reference_no');
        $purchaseDate = $this->request->getPost('purchase_date');
        $paymentStatus = $this->request->getPost('payment_status');
        $purchaseStatus = $this->request->getPost('purchase_status');
        $totalAmount = $this->request->getPost('total_amount');
        $paidAmount = $this->request->getPost('paid_amount');
        $remainingAmount = $this->request->getPost('remaining_amount');
        $products = $this->request->getPost('products');

        // Update the purchases table
        $purchasesModel = new PurchasesModel();
        $purchaseData = [
            'supplier_id' => $supplierId,
            'reference_no' => $referenceNo,
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'remaining_amount' => $remainingAmount,
            'purchase_date' => $purchaseDate,
            'payment_status' => $paymentStatus,
            'purchase_status' => $purchaseStatus,
        ];
        $purchasesModel->update($purchaseId, $purchaseData);

        // Update the purchase_items table
        $purchaseItemsModel = new PurchaseItemsModel();

        // Fetch existing items for this purchase
        $existingItems = $purchaseItemsModel->asArray()
                                            ->where('purchase_id', $purchaseId)
                                            ->findAll();
        $existingItemMap = [];
        foreach ($existingItems as $item) {
            $key = $item['product_id'] . '_' . ($item['variation_id'] ?? '') . '_' . ($item['variation_value_id'] ?? '');
            $existingItemMap[$key] = $item;
        }

        // Process the submitted products
        $processedKeys = [];
        foreach ($products as $product) {
            $key = $product['product_id'] . '_' . ($product['variation_id'] ?? '') . '_' . ($product['variation_value_id'] ?? '');
            $processedKeys[] = $key;

            $itemData = [
                'purchase_id' => $purchaseId,
                'product_name' => $product['product_name'] ?? null,
                'product_id' => $product['product_id'],
                'variation_id' => $product['variation_id'] ?? null,
                'variation_value_id' => $product['variation_value_id'] ?? null,
                'sku_code' => $product['sku_code'] ?? null,
                'category_id' => $product['category_id'] ?? null,
                'sub_category_id' => $product['sub_category_id'] ?? null,
                'unit_id' => $product['unit_id'] ?? null,
                'brand_id' => $product['brand_id'] ?? null,
                'quantity' => $product['quantity'],
                'unit_price' => $product['price'],
                'total_price' => $product['quantity'] * $product['price'],
                'manufacture_date' => $product['manufacture_date'] ?? null,
                'expiry_date' => $product['expiry_date'] ?? null,
            ];

            if (isset($existingItemMap[$key])) {
                // Update the existing item
                $itemData['id'] = $existingItemMap[$key]['id'];
                $purchaseItemsModel->save($itemData);
            } else {
                // Insert new item
                $purchaseItemsModel->save($itemData);
            }
        }

        // Delete items that are not in the current submission
        foreach ($existingItemMap as $key => $existingItem) {
            if (!in_array($key, $processedKeys)) {
                $purchaseItemsModel->delete($existingItem['id']);
            }
        }

        // Redirect with success message
        return redirect()->to(route_to('purchases.index'))->with('notifySuccess', 'Purchase Updated Successfully');
    }

    
    // public function updatePurchases($purchaseId)
    // {
    //     if (!$this->hasPermission('purchases_edit')) {
    //         return redirect()->to(route_to('purchases.index'))->with('error', 'Permission Denied');
    //     }

    //     // Validate incoming data
    //     $validationRules = [
    //         'supplier_id' => 'required|integer',
    //         'reference_no' => 'required',
    //         'purchase_date' => 'required|valid_date',
    //         'payment_status' => 'required|in_list[paid,unpaid,partial]',
    //         'purchase_status' => 'required|in_list[received,pending]',
    //         'products.*.quantity' => 'required|integer|greater_than_equal_to[1]',
    //         'products.*.price' => 'required|numeric|greater_than_equal_to[0.01]',
    //         'total_amount' => 'required|numeric|greater_than_equal_to[0.01]',
    //         'paid_amount' => 'required|numeric|greater_than_equal_to[0]',
    //         'products.*.manufacture_date' => 'permit_empty|valid_date',
    //         'products.*.expiry_date' => 'permit_empty|valid_date',
    //         'remaining_amount' => 'required|numeric|greater_than_equal_to[0]',
    //     ];

    //     if (!$this->validate($validationRules)) {
    //         return view('Purchases\Views\purchases\edit', ['validation' => $this->validator]);
    //     }

    //     // Retrieve form data
    //     $supplierId = $this->request->getPost('supplier_id');
    //     $referenceNo = $this->request->getPost('reference_no');
    //     $purchaseDate = $this->request->getPost('purchase_date');
    //     $paymentStatus = $this->request->getPost('payment_status');
    //     $purchaseStatus = $this->request->getPost('purchase_status');
    //     $totalAmount = $this->request->getPost('total_amount');
    //     $paidAmount = $this->request->getPost('paid_amount');
    //     $remainingAmount = $this->request->getPost('remaining_amount');
    //     $products = $this->request->getPost('products');

    //     // dd($products);
        
    //     // Debug: Check retrieved data
    //     // dd(compact('supplierId', 'referenceNo', 'purchaseDate', 'paymentStatus', 'purchaseStatus', 'totalAmount', 'paidAmount', 'remainingAmount', 'products'));

    //     // Update 'purchases' table
    //     $purchasesModel = new PurchasesModel();
    //     $purchaseData = [
    //         'supplier_id' => $supplierId,
    //         'reference_no' => $referenceNo,
    //         'total_amount' => $totalAmount,
    //         'paid_amount' => $paidAmount,
    //         'remaining_amount' => $remainingAmount,
    //         'purchase_date' => $purchaseDate,
    //         'payment_status' => $paymentStatus,
    //         'purchase_status' => $purchaseStatus,
    //     ];

    //     $result = $purchasesModel->update($purchaseId, $purchaseData);
    //     // dd($result);

    //     // Update 'purchase_items' table
    //     $purchaseItemsModel = new PurchaseItemsModel();
    //     $purchaseItemsModel->where('purchase_id', $purchaseId)->delete(); // Delete existing items
    //     foreach ($products as $product) {
    //         $itemData = [
    //             'purchase_id' => $purchaseId,
    //             'product_name' => $product['product_name'] ?? null,
    //             'product_id' => $product['product_id'],
    //             'variation_id' => $product['variation_id'] ?? null,
    //             'variation_value_id' => $product['variation_value_id'] ?? null,
    //             'sku_code' => $product['sku_code'] ?? null,
    //             'category_id' => $product['category_id'] ?? null,
    //             'sub_category_id' => $product['sub_category_id'] ?? null,
    //             'unit_id' => $product['unit_id'] ?? null,
    //             'brand_id' => $product['brand_id'] ?? null,
    //             'quantity' => $product['quantity'],
    //             'unit_price' => $product['price'],
    //             'total_price' => $product['quantity'] * $product['price'],
    //             'manufacture_date' => $product['manufacture_date'] ?? null,
    //             'expiry_date' => $product['expiry_date'] ?? null,
    //         ];
            
    //         // Attempt to update or insert the purchase item
    //         $purchaseItemsModel->save($itemData);  // This will update if the record exists, insert if it doesn't
    //     }

    //     // Redirect with success message
    //     return redirect()->to(route_to('purchases.index'))->with('notifySuccess', 'Purchase Updated Successfully');
    // }

    public function deletePurchases($id)
    {
        if (!$this->hasPermission('purchases_delete')) {
            return redirect()->to(route_to('purchases.index'))->with('error', 'Permission Denied');
        }

        $purchaseItemsModel = new PurchaseItemsModel();
        $purchasesModel = new PurchasesModel();

        $purchase = $purchasesModel->find($id);
        if (!$purchase) {
            return redirect()->to(route_to('purchases.index'))->with('error', 'Purchase not found');
        }

        $purchaseItemsModel->where('purchase_id', $id)->delete();

        $purchasesModel->delete($id);

        return redirect()->to(route_to('purchases.index'))->with('notifySuccess', 'Purchase Deleted Successfully');
    }


    public function updatePurchasesStatus()
    {
        $brandId = $this->request->getPost('id');
        $newStatus = $this->request->getPost('brand_status');

        try {
            if (empty($brandId) || !is_numeric($brandId) || empty($newStatus)) {
                throw new \Exception('Invalid input data');
            }
            $model = new PurchasesModel();
            $model->update($brandId, ['brand_status' => $newStatus]);

            return $this->response->setJSON(['success' => true, 'message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            log_message('error', 'Failed to update status: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'An error occurred while updating status']);
        }
    }

    public function generatePurchaseOrderNumber()
    {
        $purchasesModel = new PurchasesModel();
        $lastPurchase = $purchasesModel->orderBy('id', 'DESC')->first();

        $sequenceNumber = ($lastPurchase) ? $lastPurchase->id + 1 : 1;

        $referenceNo = 'REF' . str_pad($sequenceNumber, 4, '0', STR_PAD_LEFT); // Example format: PO-0001

        return $this->response->setJSON(['reference_no' => $referenceNo]);
    }

    use ResponseTrait;

    public function searchProducts()
    {
        $query = $this->request->getGet('query');

        if (!$query) {
            return $this->respond([]);
        }

        $productsModel = new ProductsModel();
        $productVariationsModel = new ProductVariationsModel();

        // Select necessary fields
        $productsModel->select('id, product_name, sku_code, has_variation, buying_price, customer_price, sale_price, created_at, updated_at');
        $productVariationsModel->select('id, product_id, variation_sku_code, variation_product_name, variation_id, variation_value_id, variation_brand_id, variation_unit_id, variation_buying_price, variation_customer_price, variation_sale_price, variation_product_status, created_at, updated_at');

        // Search products by product_name matching the query
        $products = $productsModel->like('product_name', $query)->findAll();

        $result = [];
        foreach ($products as $product) {
            if ($product->has_variation == 1) {
                // Get variations from product_variations table
                $variations = $productVariationsModel->where('product_id', $product->id)->findAll();
                foreach ($variations as $variation) {
                    // Ensure product_id is available in each variation
                    $variation->product_id = $product->id;
                    // Set has_variation to 1 for variations
                    $variation->has_variation = 1;
                    $result[] = $variation;
                }
            } else {
                // If product has no variations, add it directly to the result
                $product->has_variation = 0;
                $result[] = $product;
            }
        }

        return $this->respond($result);
    }


    public function hasPermission($permission)
    {
        // Implement your permission checking logic here
        // Example: Check if the logged-in user has the specified permission
        // You can use your authentication and authorization logic or a library
        // For example, you might have a 'Roles' and 'Permissions' system in your database

        // Replace the logic below with your actual permission check
        $allowedPermissions = [
            'purchases_list',
            'purchases_add',
            'purchases_edit',
            'purchases_delete',
        ];

        return in_array($permission, $allowedPermissions);
    }

}