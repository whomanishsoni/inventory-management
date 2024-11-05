<?php
namespace Sales\Controllers;

use App\Controllers\AdminBaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\RolePermissionModel;
use Sales\Models\SalesModel;
use Sales\Models\SaleItemsModel;
use Products\Models\ProductsModel;
use Products\Models\ProductVariationsModel;
use Products\Models\VariationValuesModel;
use Customers\Models\CustomersModel;
use CodeIgniter\API\ResponseTrait;

class Sales extends AdminBaseController
{

    public $title = 'Sales Management';
    public $menu = 'sales';

    public function sales()
    {
        $listSales = (new SalesModel())
            ->join('customers', 'customers.id = sales.customer_id')
            ->select('sales.*, customers.customer_name')
            ->findAll();

        $this->updatePageData(['submenu' => 'Sales List']);
        return view('Sales\Views\sales\list', compact('listSales'));
    }

    public function addSales()
    {
        if (!$this->hasPermission('sales_add')) {
            return redirect()->to(route_to('sales.index'))->with('error', 'Permission Denied');
        }
        $CustomersModel = new CustomersModel();

        $activeEntities = [
            'customers' => $CustomersModel->where('customer_status', 'active')->findAll(),
        ];

        $this->updatePageData(['submenu' => 'Add New Sale']);
        return view('Sales\Views\sales\add', $activeEntities);
    }

    public function storeSales()
    {
        if (!$this->hasPermission('sales_add')) {
            return redirect()->to(route_to('sales.index'))->with('error', 'Permission Denied');
        }

        // $validationRules = [
        //     'customer_id' => 'required|integer',
        //     'sales_date' => 'required|valid_date',
        //     'payment_status' => 'required|in_list[paid,unpaid,partial]',
        //     'sales_status' => 'required|in_list[received,pending]',
        //     'products.*.quantity' => 'required|integer|greater_than_equal_to[1]',
        //     'products.*.price' => 'required|numeric|greater_than_equal_to[0.01]',
        //     'total_amount' => 'required|numeric|greater_than_equal_to[0.01]',
        //     'paid_amount' => 'required|numeric|greater_than_equal_to[0]',
        //     'products.*.manufacture_date' => 'permit_empty|valid_date',
        //     'products.*.expiry_date' => 'permit_empty|valid_date',
        //     'remaining_amount' => 'required|numeric|greater_than_equal_to[0]',
        // ];

        // if (!$this->validate($validationRules)) {
        //     return view('Products\Views\purchases\add', ['validation' => $this->validator]);
        // }

        // Retrieve form data
        $CustomerId = $this->request->getPost('customer_id');
        $referenceNo = $this->request->getPost('reference_no');
        $purchaseDate = $this->request->getPost('purchase_date');
        $paymentStatus = $this->request->getPost('payment_status');
        $purchaseStatus = $this->request->getPost('purchase_status');
        $totalAmount = $this->request->getPost('total_amount');
        $paidAmount = $this->request->getPost('paid_amount');
        $remainingAmount = $this->request->getPost('remaining_amount');
        $products = $this->request->getPost('products');

        // Insert data into 'purchases' table
        $SalesModel = new SalesModel();
        $saleData = [
            'customer_id' => $CustomerId,
            'reference_no' => $referenceNo,
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'remaining_amount' => $remainingAmount,
            'purchase_date' => $purchaseDate,
            'payment_status' => $paymentStatus,
            'purchase_status' => $purchaseStatus,
        ];

        $salesId = $SalesModel->insert($saleData);

        $salesItemsModel = new SaleItemsModel();
        foreach ($products as $product) {
            $itemData = [
                'sale_id' => $salesId,
                // 'product_id' => $product['product_id'],
                // 'product_name' => $product['product_name'],
                // 'sku_code' => $product['sku_code'],
                // 'variation_id' => $product['variation_id'] ?? null,
                // 'variation_value_id' => $product['variation_value_id'] ?? null,
                // 'quantity' => $product['quantity'],
                // 'unit_price' => $product['price'],
                // 'total_price' => $product['quantity'] * $product['price'],
                // 'manufacture_date' => $product['manufacture_date'] ?? null,
                // 'expiry_date' => $product['expiry_date'] ?? null,
            ];
            // dd($itemData);
            $salesItemsModel->insert($itemData);
        }

        return redirect()->to(route_to('sales.index'))->with('notifySuccess', 'Purchase Added Successfully');
    }

    public function editSales($id)
    {
        if (!$this->hasPermission('sales_edit')) {
            return redirect()->to(route_to('sales.index'))->with('error', 'Permission Denied');
        }

        $SalesModel = new SalesModel();
        $sale = $SalesModel->select('sales.*, customers.customer_name')
            ->join('customers', 'customers.id = sales.customer_id')
            ->where('sales.id', $id)
            ->first();

        if (!$sale) {
            return redirect()->to(route_to('sales.index'))->with('error', 'Sales not found');
        }

        $CustomersModel = new CustomersModel();
        $customer = $CustomersModel->select('id, customer_name')
            ->where('customer_status', 'active')
            ->findAll();

        $SaleItemsModel = new SaleItemsModel();
        // Modified query to include items without variations
        $saleItems = $SaleItemsModel->select('sales_items.*, variations.variation_name, variation_values.variation_value')
            ->join('variations', 'variations.id = sales_items.variation_id', 'left') // Use 'left' join to include products without variations
            ->join('variation_values', 'variation_values.id = sales_items.variation_value_id', 'left') // Use 'left' join to include products without variation values
            ->where('sales_items.sale_id', $id)
            ->findAll();

        $data = [
            'sale' => $sale,
            'saleItems' => $saleItems,
            'customers' => $customer,
        ];

        $this->updatePageData(['submenu' => 'Edit Purchase']);
        return view('Sales\Views\sales\edit', $data);
    }
    public function updateSales($salesId)
    {

        if (!$this->hasPermission('sales_edit')) {
            return redirect()->to(route_to('purchases.index'))->with('error', 'Permission Denied');
        }

        // Validate incoming data
        // $validationRules = [
        //     'supplier_id' => 'required|integer',
        //     'reference_no' => 'required',
        //     'purchase_date' => 'required|valid_date',
        //     'payment_status' => 'required|in_list[paid,unpaid,partial]',
        //     'purchase_status' => 'required|in_list[received,pending]',
        //     'products.*.quantity' => 'required|integer|greater_than_equal_to[1]',
        //     'products.*.price' => 'required|numeric|greater_than_equal_to[0.01]',
        //     'total_amount' => 'required|numeric|greater_than_equal_to[0.01]',
        //     'paid_amount' => 'required|numeric|greater_than_equal_to[0]',
        //     'products.*.manufacture_date' => 'permit_empty|valid_date',
        //     'products.*.expiry_date' => 'permit_empty|valid_date',
        //     'remaining_amount' => 'required|numeric|greater_than_equal_to[0]',
        // ];

        // if (!$this->validate($validationRules)) {
        //     return view('Purchases\Views\purchases\edit', ['validation' => $this->validator]);
        // }

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

        // Update 'purchases' table
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

        // $purchasesModel->update($purchaseId, $purchaseData);

        // // Update 'purchase_items' table
        // $purchaseItemsModel = new PurchaseItemsModel();
        // $purchaseItemsModel->where('purchase_id', $purchaseId)->delete(); // Delete existing items

        // foreach ($products as $product) {
        //     $itemData = [
        //         'purchase_id' => $purchaseId,
        //         'product_name' => $product['product_name'] ?? null,
        //         'product_id' => $product['product_id'],
        //         'variation_id' => $product['variation_id'] ?? null,
        //         'variation_value_id' => $product['variation_value_id'] ?? null,
        //         'sku_code' => $product['sku_code'] ?? null,
        //         'category_id' => $product['category_id'] ?? null,
        //         'sub_category_id' => $product['sub_category_id'] ?? null,
        //         'unit_id' => $product['unit_id'] ?? null,
        //         'brand_id' => $product['brand_id'] ?? null,
        //         'quantity' => $product['quantity'],
        //         'unit_price' => $product['price'],
        //         'total_price' => $product['quantity'] * $product['price'],
        //         'manufacture_date' => $product['manufacture_date'] ?? null,
        //         'expiry_date' => $product['expiry_date'] ?? null,
        //     ];
        //     $purchaseItemsModel->insert($itemData);
        // }

        // Redirect with success message
        return redirect()->to(route_to('purchases.index'))->with('notifySuccess', 'Purchase Updated Successfully');
    }


    public function deleteSales($id)
    {
        if (!$this->hasPermission('sales_delete')) {
            return redirect()->to(route_to('sales.index'))->with('error', 'Permission Denied');
        }

        $SaleItemsModel = new SaleItemsModel();
        $SalesModel = new SalesModel();

        $sale = $SalesModel->find($id);
        if (!$sale) {
            return redirect()->to(route_to('sales.index'))->with('error', 'Sales not found');
        }

        $SaleItemsModel->where('sale_id', $id)->delete();

        $SalesModel->delete($id);

        return redirect()->to(route_to('sales.index'))->with('notifySuccess', 'Sales Deleted Successfully');
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

    public function generateSalesOrderNumber()
    {
        $SalesModel = new SalesModel();
        $lastSale = $SalesModel->orderBy('id', 'DESC')->first();

        $sequenceNumber = ($lastSale) ? $lastSale->id + 1 : 1;

        $referenceNo = 'SALE' . str_pad($sequenceNumber, 4, '0', STR_PAD_LEFT); // Example format: PO-0001


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
            'sales_list',
            'sales_add',
            'sales_edit',
            'sales_delete',
        ];

        return in_array($permission, $allowedPermissions);
    }

}