<?php
namespace Suppliers\Controllers;

use App\Controllers\AdminBaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\RolePermissionModel;
use Suppliers\Models\SuppliersModel;
use Locations\Models\CountriesModel;
use Locations\Models\StatesModel;
use Locations\Models\CitiesModel;
use Suppliers\Models\SuppliersTransactionsModel;

class Suppliers extends AdminBaseController
{

    public $title = 'Suppliers Management';
    public $menu = 'suppliers';

    public function suppliers()
    {
        $listSuppliers = (new SuppliersModel())
            ->select('suppliers.*,,cities.city_name, states.state_name, countries.country_name')
            ->join('cities', 'cities.id = suppliers.city_id')
            ->join('states', 'states.id = suppliers.state_id')
            ->join('countries', 'countries.id = suppliers.country_id')
            ->findAll();

        $this->updatePageData(['submenu' => 'Supplier List']);
        return view('Suppliers\Views\list', compact('listSuppliers'));
    }

    public function addSuppliers()
    {
        if (!$this->hasPermission('suppliers_add')) {
            return redirect()->to(route_to('suppliers.index'))->with('error', 'Permission Denied');
        }
        $countryModel = new CountriesModel();
        $stateModel = new StatesModel();
        $cityModel = new CitiesModel();

        $activeEntities = [
            'countries' => $countryModel->findAll(),
            'states' => $stateModel->findAll(),
            'cities' => $cityModel->findAll()
        ];

        $this->updatePageData(['submenu' => 'Add Suppliers']);
        return view('Suppliers\Views\add', $activeEntities);
    }

    public function storeSuppliers()
    {
        if (!$this->hasPermission('suppliers_add')) {
            return redirect()->to(route_to('suppliers.index'))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'supplier_name' => 'required',
            'supplier_contact_person' => 'required',
            'supplier_email' => 'required',
            'supplier_phone' => 'required|exact_length[10]',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'supplier_status' => 'required|in_list[active,inactive]',
        ];

        $validationMessages = [
            'supplier_phone.exact_length' => 'The mobile number must be exactly 10 digits.',
        ];

        if (!$this->validate($validationRules, $validationMessages)) {
            return view('Suppliers\Views\add', ['validation' => $this->validator]);
        }

        $data = [
            'supplier_name' => $this->request->getPost('supplier_name'),
            'supplier_contact_person' => $this->request->getPost('supplier_contact_person'),
            'supplier_email' => $this->request->getPost('supplier_email'),
            'supplier_phone' => $this->request->getPost('supplier_phone'),
            'supplier_address' => $this->request->getPost('supplier_address'),
            'supplier_pincode' => $this->request->getPost('supplier_pincode'),
            'supplier_notes' => $this->request->getPost('supplier_notes'),
            'country_id' => $this->request->getPost('country_id'),
            'state_id' => $this->request->getPost('state_id'),
            'city_id' => $this->request->getPost('city_id'),
            'supplier_status' => $this->request->getPost('supplier_status'),
        ];

        (new SuppliersModel())->insert($data);

        return redirect()->to(route_to('suppliers.index'))->with('notifySuccess', 'Supplier Added Successfully');
    }

    public function editSuppliers($id)
    {
        if (!$this->hasPermission('suppliers_edit')) {
            return redirect()->to(route_to('suppliers.index'))->with('error', 'Permission Denied');
        }

        $supplierModel = new SuppliersModel();
        $supplier = $supplierModel->find($id);

        if (!$supplier) {
            return redirect()->to(route_to('suppliers.index'))->with('error', 'Supplier not found');
        }

        $countryModel = new CountriesModel();
        $stateModel = new StatesModel();
        $cityModel = new CitiesModel();

        $userCountryId = $supplier->country_id;
        $userStateId = $supplier->state_id;
        $userCityId = $supplier->city_id;

        $countries = $countryModel->where('country_status', 'active')->findAll();
        $states = $stateModel->where(['country_id' => $userCountryId, 'state_status' => 'active'])->findAll();
        $cities = $cityModel->where(['state_id' => $userStateId, 'city_status' => 'active'])->findAll();

        $activeEntities = [
            'supplier' => $supplier,
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities,
        ];

        $this->updatePageData(['submenu' => 'Edit Supplier']);
        return view('Suppliers\Views\edit', $activeEntities);
    }

    public function updateSuppliers($id)
    {
        if (!$this->hasPermission('suppliers_edit')) {
            return redirect()->to(route_to('suppliers.index'))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'supplier_name' => 'required',
            'supplier_contact_person' => 'required',
            'supplier_email' => 'required',
            'supplier_phone' => 'required|exact_length[10]',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'supplier_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Suppliers\Views\edit', ['validation' => $this->validator, 'supplier' => (new SuppliersModel())->find($id)]);
        }

        $data = [
            'supplier_name' => $this->request->getPost('supplier_name'),
            'supplier_contact_person' => $this->request->getPost('supplier_contact_person'),
            'supplier_email' => $this->request->getPost('supplier_email'),
            'supplier_phone' => $this->request->getPost('supplier_phone'),
            'supplier_address' => $this->request->getPost('supplier_address'),
            'supplier_pincode' => $this->request->getPost('supplier_pincode'),
            'supplier_notes' => $this->request->getPost('supplier_notes'),
            'country_id' => $this->request->getPost('country_id'),
            'state_id' => $this->request->getPost('state_id'),
            'city_id' => $this->request->getPost('city_id'),
            'supplier_status' => $this->request->getPost('supplier_status'),
        ];

        (new SuppliersModel())->update($id, $data);

        return redirect()->to(route_to('suppliers.index'))->with('notifySuccess', 'Supplier Updated Successfully');
    }

    public function deleteSuppliers($id)
    {
        if (!$this->hasPermission('suppliers_delete')) {
            return redirect()->to(route_to('suppliers.index'))->with('error', 'Permission Denied');
        }
        (new SuppliersModel())->delete($id);

        return redirect()->to(route_to('suppliers.index'))->with('notifySuccess', 'Supplier Deleted Successfully');
    }

    public function updateSuppliersStatus()
    {
        $supplierId = $this->request->getPost('id');
        $newStatus = $this->request->getPost('supplier_status');

        try {
            if (empty($supplierId) || !is_numeric($supplierId) || empty($newStatus)) {
                throw new \Exception('Invalid input data');
            }
            $model = new SuppliersModel();
            $model->update($supplierId, ['supplier_status' => $newStatus]);

            return $this->response->setJSON(['success' => true, 'message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            log_message('error', 'Failed to update status: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'An error occurred while updating status']);
        }
    }

    public function getStates()
    {
        $countryId = $this->request->getGet('country_id');

        $stateModel = new StatesModel();
        $states = $stateModel->where('country_id', $countryId)->where('state_status', 'active')->findAll();
        return json_encode($states);
    }

    public function getCities()
    {
        $stateId = $this->request->getGet('state_id');
        $cityModel = new CitiesModel();
        $cities = $cityModel->where('state_id', $stateId)->where('city_status', 'active')->findAll();
        return json_encode($cities);
    }

    public function hasPermission($permission)
    {
        // Implement your permission checking logic here
        // Example: Check if the logged-in user has the specified permission
        // You can use your authentication and authorization logic or a library
        // For example, you might have a 'Roles' and 'Permissions' system in your database

        // Replace the logic below with your actual permission check
        $allowedPermissions = [
            'suppliers_list',
            'suppliers_add',
            'suppliers_edit',
            'suppliers_delete',
            'suppliers_transactions_add',

        ];

        return in_array($permission, $allowedPermissions);
    }
    public function addTransactions($id)
    {
        // Check if the user has permission to add supplier transactions
        if (!$this->hasPermission('suppliers_transactions_add')) {
            return redirect()->to(route_to('Suppliers.transactions', $id))
                ->with('error', 'Permission Denied');
        }

        // Load the supplier model
        $supplierModel = new SuppliersModel();

        // Find the supplier by ID
        $supplier = $supplierModel->find($id);

        // Check if the supplier exists
        if (!$supplier) {
            return redirect()->to(route_to('Suppliers.transactions', $id))
                ->with('error', 'Supplier not found');
        }

        // Prepare data to pass to the view
        $activeEntities = [
            'suppliersId' => $id,
            'suppliersName' => $supplier->supplier_name,
        ];

        // Update the page data
        $this->updatePageData(['submenu' => 'Add Transaction']);

        // Load the view with the data
        return view('Suppliers\Views\add_transactions', $activeEntities);
    }

    public function storeTransactions($id)
    {
        if (!$this->hasPermission('suppliers_transactions_add')) {
            //return redirect()->to(route_to('customers.transactions', $suppliersId))->with('error', 'Permission Denied');
        }

        $validationRules = [
            'transaction_type' => 'required|in_list[credit,debit]',
            'transaction_date' => 'required|valid_date',
            'transaction_amount' => 'required|numeric|greater_than[0]',
            'transaction_description' => 'max_length[255]',
            'transaction_reference_id' => 'max_length[255]',
        ];

        $validationMessages = [
            'transaction_type.in_list' => 'Invalid transaction type.',
            'transaction_date.valid_date' => 'Please provide a valid date.',
            'transaction_amount.greater_than' => 'The amount must be greater than 0.',
        ];

        if (!$this->validate($validationRules, $validationMessages)) {
            $SuppliersModel = new SuppliersModel();
            $suppliers = $SuppliersModel->find($id);

            $activeEntities = [
                'suppliersId' => $id,
                'customerName' => $suppliers->suppliers_name,
                'validation' => $this->validator,
            ];

            return view('Customers\Views\add_transactions', $activeEntities);
        }
        $data = [
            'suppliersId' => $id,
            'transaction_type' => $this->request->getPost('transaction_type'),
            'transaction_date' => $this->request->getPost('transaction_date'),
            'amount' => $this->request->getPost('transaction_amount'),
            'description' => $this->request->getPost('transaction_description'),
            'reference_id' => $this->request->getPost('transaction_reference_id'),
            'created_by' => logged('id'),
        ];

        $SuppliersTransactionsModel = new SuppliersTransactionsModel();
        $SuppliersTransactionsModel->insert($data);

        $this->updateCustomerBalance($id);

        return redirect()->to(route_to('suppliers.transactions', $id))->with('notifySuccess', 'Transaction Added Successfully');
    }

    private function updateCustomerBalance($id)
    {
        $SuppliersTransactionsModel = new SuppliersTransactionsModel();
        $transactions = $SuppliersTransactionsModel->where('supplier_id', $id)->orderBy('transaction_date', 'ASC')->findAll();
        $balance = 0;

        foreach ($transactions as $transaction) {
            if ($transaction->transaction_type == 'credit') {
                $balance += $transaction->amount;
            } elseif ($transaction->transaction_type == 'debit') {
                $balance -= $transaction->amount;
            }
            // Update each transaction's balance
            $SuppliersTransactionsModel->update($transaction->id, ['balance' => $balance]);
        }
    }

}