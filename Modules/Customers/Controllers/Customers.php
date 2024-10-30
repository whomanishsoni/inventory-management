<?php
namespace Customers\Controllers;

use App\Controllers\AdminBaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\RolePermissionModel;
use App\Models\UserModel;
use Customers\Models\CustomersModel;
use Locations\Models\CountriesModel;
use Locations\Models\StatesModel;
use Locations\Models\CitiesModel;
use Customers\Models\CustomerTransactionsModel;

class Customers extends AdminBaseController
{

    public $title = 'Customers Management';
    public $menu = 'customers';

    public function customers()
    {
        // Retrieve search keyword from request
        $searchKeyword = $this->request->getGet('search') ?? '';

        // Get customers with their addresses based on the search keyword
        $customersModel = new CustomersModel();
        $listCustomers = $customersModel
            ->select('customers.*, cities.city_name, states.state_name, countries.country_name')
            ->join('cities', 'cities.id = customers.city_id')
            ->join('states', 'states.id = customers.state_id')
            ->join('countries', 'countries.id = customers.country_id')
            ->like('customers.customer_name', $searchKeyword) // Add more conditions as needed
            ->findAll();

        // Extract customer IDs from the filtered list
        $customerIds = array_column($listCustomers, 'id');

        // Get customer balances for the filtered customer IDs
        $customerTransactionsModel = new CustomerTransactionsModel();
        $customerBalances = $customerTransactionsModel
            ->select('customer_id, 
                    SUM(CASE WHEN transaction_type = "credit" THEN amount ELSE 0 END) - 
                    SUM(CASE WHEN transaction_type = "debit" THEN amount ELSE 0 END) as balance')
            ->whereIn('customer_id', $customerIds) // Filter by customer IDs
            ->groupBy('customer_id')
            ->findAll();

        // Map balances to customers by customer_id
        $balancesMap = [];
        $totalBalance = 0;
        foreach ($customerBalances as $balance) {
            $balancesMap[$balance->customer_id] = $balance->balance;
            $totalBalance += $balance->balance; // Calculate total balance
        }

        // Add balance information to each customer
        foreach ($listCustomers as &$customer) {
            $customerId = $customer->id;
            $customer->balance = isset($balancesMap[$customerId]) ? $balancesMap[$customerId] : 0;
        }

        $this->updatePageData(['submenu' => 'Customer List']);
        return view('Customers\Views\list', compact('listCustomers', 'totalBalance', 'searchKeyword'));
    }



    public function addCustomers()
    {
        if (!$this->hasPermission('customers_add')) {
            return redirect()->to(route_to('customers.index'))->with('error', 'Permission Denied');
        }
        $countryModel = new CountriesModel();
        $stateModel = new StatesModel();
        $cityModel = new CitiesModel();

        $activeEntities = [
            'countries' => $countryModel->findAll(),
            'states' => $stateModel->findAll(),
            'cities' => $cityModel->findAll()
        ];

        $this->updatePageData(['submenu' => 'Add Customers']);
        return view('Customers\Views\add', $activeEntities);
    }

    public function storeCustomers()
    {
        if (!$this->hasPermission('customers_add')) {
            return redirect()->to(route_to('customers.index'))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'customer_name' => 'required',
            'customer_email' => 'required',
            'customer_phone' => 'required|exact_length[10]',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'customer_status' => 'required|in_list[active,inactive]',
        ];

        $validationMessages = [
            'customer_phone.exact_length' => 'The mobile number must be exactly 10 digits.',
        ];

        if (!$this->validate($validationRules, $validationMessages)) {
            return view('Customers\Views\add', ['validation' => $this->validator]);
        }

        $data = [
            'customer_name' => $this->request->getPost('customer_name'),
            'customer_email' => $this->request->getPost('customer_email'),
            'customer_phone' => $this->request->getPost('customer_phone'),
            'customer_address' => $this->request->getPost('customer_address'),
            'customer_pincode' => $this->request->getPost('customer_pincode'),
            'country_id' => $this->request->getPost('country_id'),
            'state_id' => $this->request->getPost('state_id'),
            'city_id' => $this->request->getPost('city_id'),
            'customer_status' => $this->request->getPost('customer_status'),
        ];

        (new CustomersModel())->insert($data);

        return redirect()->to(route_to('customers.index'))->with('notifySuccess', 'Customer Added Successfully');
    }

    public function editCustomers($id)
    {
        if (!$this->hasPermission('customers_edit')) {
            return redirect()->to(route_to('customers.index'))->with('error', 'Permission Denied');
        }

        $customerModel = new CustomersModel();
        $customer = $customerModel->find($id);

        if (!$customer) {
            return redirect()->to(route_to('customers.index'))->with('error', 'Customer not found');
        }

        $countryModel = new CountriesModel();
        $stateModel = new StatesModel();
        $cityModel = new CitiesModel();

        $userCountryId = $customer->country_id;
        $userStateId = $customer->state_id;
        $userCityId = $customer->city_id;

        $countries = $countryModel->where('country_status', 'active')->findAll();
        $states = $stateModel->where(['country_id' => $userCountryId, 'state_status' => 'active'])->findAll();
        $cities = $cityModel->where(['state_id' => $userStateId, 'city_status' => 'active'])->findAll();

        $activeEntities = [
            'customer' => $customer,
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities,
        ];

        $this->updatePageData(['submenu' => 'Edit Customer']);
        return view('Customers\Views\edit', $activeEntities);
    }

    public function updateCustomers($id)
    {
        if (!$this->hasPermission('customers_edit')) {
            return redirect()->to(route_to('customers.index'))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'customer_name' => 'required',
            'customer_email' => 'required',
            'customer_phone' => 'required|exact_length[10]',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'customer_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Customers\Views\edit', ['validation' => $this->validator, 'customer' => (new CustomersModel())->find($id)]);
        }

        $data = [
            'customer_name' => $this->request->getPost('customer_name'),
            'customer_email' => $this->request->getPost('customer_email'),
            'customer_phone' => $this->request->getPost('customer_phone'),
            'customer_address' => $this->request->getPost('customer_address'),
            'customer_pincode' => $this->request->getPost('customer_pincode'),
            'country_id' => $this->request->getPost('country_id'),
            'state_id' => $this->request->getPost('state_id'),
            'city_id' => $this->request->getPost('city_id'),
            'customer_status' => $this->request->getPost('customer_status'),
        ];

        (new CustomersModel())->update($id, $data);

        return redirect()->to(route_to('customers.index'))->with('notifySuccess', 'Customer Updated Successfully');
    }

    public function deleteCustomers($id)
    {
        if (!$this->hasPermission('customers_delete')) {
            return redirect()->to(route_to('customers.index'))->with('error', 'Permission Denied');
        }
        (new CustomersModel())->delete($id);

        return redirect()->to(route_to('customers.index'))->with('notifySuccess', 'Customer Deleted Successfully');
    }

    public function updateCustomersStatus()
    {
        $customerId = $this->request->getPost('id');
        $newStatus = $this->request->getPost('customer_status');

        try {
            if (empty($customerId) || !is_numeric($customerId) || empty($newStatus)) {
                throw new \Exception('Invalid input data');
            }
            $model = new CustomersModel();
            $model->update($customerId, ['customer_status' => $newStatus]);

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

    public function customerBalances()
    {
        $customerTransactionsModel = new CustomerTransactionsModel();

        $customerBalances = $customerTransactionsModel
            ->select('customer_id, customers.customer_name, 
                      SUM(CASE WHEN transaction_type = "credit" THEN amount ELSE 0 END) - 
                      SUM(CASE WHEN transaction_type = "debit" THEN amount ELSE 0 END) as balance')
            ->join('customers', 'customers.id = customer_transactions.customer_id')
            ->groupBy('customer_id')
            ->findAll();

        $totalBalance = 0;
        foreach ($customerBalances as $customerBalance) {
            $totalBalance += $customerBalance->balance;
        }

        $this->updatePageData(['submenu' => 'Customer Balances List']);
        return view('Customers\Views\customer_balances', compact('customerBalances', 'totalBalance'));
    }

    public function transactions($customerId)
    {
        $user = (new UserModel())->getById(logged('id'));

        $customerTransactionsModel = new CustomerTransactionsModel();

        $listCustomerTransactions = $customerTransactionsModel
            ->select('customer_transactions.*, customers.customer_name, created_by.name as created_by, updated_by.name as updated_by')
            ->join('customers', 'customers.id = customer_transactions.customer_id')
            ->join('users as created_by', 'created_by.id = customer_transactions.created_by', 'left')
            ->join('users as updated_by', 'updated_by.id = customer_transactions.updated_by', 'left')
            ->where('customer_transactions.customer_id', $customerId)
            ->orderBy('customer_transactions.transaction_date', 'DESC')  // Change to order by transaction_date in descending order
            ->findAll();

        $totalAvailableBalance = 0;
        foreach ($listCustomerTransactions as $transaction) {
            if ($transaction->transaction_type == 'credit') {
                $totalAvailableBalance += $transaction->amount;
            } elseif ($transaction->transaction_type == 'debit') {
                $totalAvailableBalance -= $transaction->amount;
            }
        }

        $this->updatePageData(['submenu' => 'Customer Transactions List']);
        return view('Customers\Views\list_transactions', compact('listCustomerTransactions', 'totalAvailableBalance', 'customerId'));
    }

    public function addTransactions($customerId)
    {
        if (!$this->hasPermission('customer_transactions_add')) {
            return redirect()->to(route_to('customers.transactions', $customerId))->with('error', 'Permission Denied');
        }

        $customerModel = new CustomersModel();
        $customer = $customerModel->find($customerId);

        if (!$customer) {
            return redirect()->to(route_to('customers.transactions', $customerId))->with('error', 'Customer not found');
        }

        $activeEntities = [
            'customerId' => $customerId,
            'customerName' => $customer->customer_name,
        ];

        $this->updatePageData(['submenu' => 'Add Transaction']);
        return view('Customers\Views\add_transactions', $activeEntities);
    }

    public function storeTransactions($customerId)
    {
        if (!$this->hasPermission('customer_transactions_add')) {
            return redirect()->to(route_to('customers.transactions', $customerId))->with('error', 'Permission Denied');
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
            $customerModel = new CustomersModel();
            $customer = $customerModel->find($customerId);

            $activeEntities = [
                'customerId' => $customerId,
                'customerName' => $customer->customer_name,
                'validation' => $this->validator,
            ];

            return view('Customers\Views\add_transactions', $activeEntities);
        }

        $data = [
            'customer_id' => $customerId,
            'transaction_type' => $this->request->getPost('transaction_type'),
            'transaction_date' => $this->request->getPost('transaction_date'),
            'amount' => $this->request->getPost('transaction_amount'),
            'description' => $this->request->getPost('transaction_description'),
            'reference_id' => $this->request->getPost('transaction_reference_id'),
            'created_by' => logged('id'),
        ];

        $customerTransactionsModel = new CustomerTransactionsModel();
        $customerTransactionsModel->insert($data);

        $this->updateCustomerBalance($customerId);

        return redirect()->to(route_to('customers.transactions', $customerId))->with('notifySuccess', 'Transaction Added Successfully');
    }

    public function editTransactions($transactionId)
    {
        if (!$this->hasPermission('customer_transactions_edit')) {
            return redirect()->to(route_to('customers.transactions', $transactionId))->with('error', 'Permission Denied');
        }

        $customerTransactionsModel = new CustomerTransactionsModel();
        $transaction = $customerTransactionsModel->find($transactionId);

        if (!$transaction) {
            return redirect()->to(route_to('customers.transactions', $transactionId))->with('error', 'Transaction not found');
        }

        $customerModel = new CustomersModel();
        $customer = $customerModel->find($transaction->customer_id);

        if (!$customer) {
            return redirect()->to(route_to('customers.transactions', $transactionId))->with('error', 'Customer not found');
        }

        $activeEntities = [
            'transaction' => $transaction,
            'customerId' => $transaction->customer_id,
            'customerName' => $customer->customer_name,
        ];

        $this->updatePageData(['submenu' => 'Edit Transaction']);
        return view('Customers\Views\edit_transactions', $activeEntities);
    }

    public function updateTransactions($transactionId)
    {
        if (!$this->hasPermission('customer_transactions_edit')) {
            return redirect()->to(route_to('customers.transactions', $transactionId))->with('error', 'Permission Denied');
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
            $customerTransactionsModel = new CustomerTransactionsModel();
            $transaction = $customerTransactionsModel->find($transactionId);

            if (!$transaction) {
                return redirect()->to(route_to('customers.transactions', $transactionId))->with('error', 'Transaction not found');
            }

            $customerModel = new CustomersModel();
            $customer = $customerModel->find($transaction->customer_id);

            if (!$customer) {
                return redirect()->to(route_to('customers.transactions', $transactionId))->with('error', 'Customer not found');
            }

            $activeEntities = [
                'transaction' => $transaction,
                'customerId' => $transaction->customer_id,
                'customerName' => $customer->customer_name,
                'validation' => $this->validator,
            ];

            return view('Customers\Views\edit_transactions', $activeEntities);
        }

        $data = [
            'transaction_type' => $this->request->getPost('transaction_type'),
            'transaction_date' => $this->request->getPost('transaction_date'),
            'amount' => $this->request->getPost('transaction_amount'),
            'description' => $this->request->getPost('transaction_description'),
            'reference_id' => $this->request->getPost('transaction_reference_id'),
            'updated_by' => logged('id'),
        ];

        $customerTransactionsModel = new CustomerTransactionsModel();
        $customerTransactionsModel->update($transactionId, $data);

        $transaction = $customerTransactionsModel->find($transactionId);
        $this->updateCustomerBalance($transaction->customer_id);

        return redirect()->to(route_to('customers.transactions', $transaction->customer_id))->with('notifySuccess', 'Transaction Updated Successfully');
    }

    public function deleteTransactions($transactionId)
    {
        if (!$this->hasPermission('customer_transactions_delete')) {
            return redirect()->to(route_to('customers.transactions'))->with('error', 'Permission Denied');
        }

        $customerTransactionsModel = new CustomerTransactionsModel();
        $transaction = $customerTransactionsModel->find($transactionId);

        if (!$transaction) {
            return redirect()->to(route_to('customers.transactions'))->with('error', 'Transaction not found');
        }

        $customerId = $transaction->customer_id;

        $customerTransactionsModel->delete($transactionId);

        $this->updateCustomerBalance($customerId);

        return redirect()->to(route_to('customers.transactions', $customerId))->with('notifySuccess', 'Transaction Deleted Successfully');
    }

    private function updateCustomerBalance($customerId)
    {
        $customerTransactionsModel = new CustomerTransactionsModel();
        $transactions = $customerTransactionsModel->where('customer_id', $customerId)->orderBy('transaction_date', 'ASC')->findAll();
        $balance = 0;

        foreach ($transactions as $transaction) {
            if ($transaction->transaction_type == 'credit') {
                $balance += $transaction->amount;
            } elseif ($transaction->transaction_type == 'debit') {
                $balance -= $transaction->amount;
            }
            // Update each transaction's balance
            $customerTransactionsModel->update($transaction->id, ['balance' => $balance]);
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
            'customers_list',
            'customers_add',
            'customers_edit',
            'customers_delete',
            'customer_transactions_list',
            'customer_transactions_add',
            'customer_transactions_edit',
            'customer_transactions_delete',
        ];

        return in_array($permission, $allowedPermissions);
    }

}