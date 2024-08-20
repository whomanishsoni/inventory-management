<?php
namespace Products\Controllers;

use App\Controllers\AdminBaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\RolePermissionModel;
use Products\Models\TaxGroupsModel;
use Products\Models\TaxRatesModel;

class TaxRates extends AdminBaseController {

    public $title = 'Tax Rates';
    public $menu = 'tax-rates';

    public function taxRates($groupId)
    {
        $listTaxRates = (new TaxRatesModel())->where('group_id', $groupId)->findAll();
        $this->updatePageData(['submenu' => 'Tax Rates List']);
        return view('Products\Views\tax-rates\list', [
            'listTaxRates' => $listTaxRates,
            'groupId' => $groupId
        ]);
    }

    public function addTaxRates($groupId)
    {
        if (!$this->hasPermission('tax_rates_add')) {
            return redirect()->to(route_to('tax-rates.group', $groupId))->with('error', 'Permission Denied');
        }

        $this->updatePageData(['submenu' => 'Add New Tax Rate']);
        return view('Products\Views\tax-rates\add', ['groupId' => $groupId]);
    }

    public function storeTaxRates()
    {
        if (!$this->hasPermission('tax_rates_add')) {
            return redirect()->to(route_to('tax-rates.group', $taxRate->group_id))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'group_id' => 'required',
            'tax_name' => 'required',
            'tax_rate' => 'required|numeric',
            'tax_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Products\Views\tax-rates\add', ['validation' => $this->validator]);
        }

        $data = [
            'group_id' => $this->request->getPost('group_id'),
            'tax_name' => $this->request->getPost('tax_name'),
            'tax_rate' => $this->request->getPost('tax_rate'),
            'tax_status' => $this->request->getPost('tax_status'),
        ];

        (new TaxRatesModel())->insert($data);

        return redirect()->to(route_to('tax-rates.group', $data['group_id']))->with('notifySuccess', 'Tax Rate Added Successfully');
    }

    public function editTaxRates($id)
    {
        $taxRate = (new TaxRatesModel())->find($id);

        if (!$this->hasPermission('tax_rates_edit')) {
            return redirect()->to(route_to('tax-rates.group', $taxRate->group_id))->with('error', 'Permission Denied');
        }

        $this->updatePageData(['submenu' => 'Edit Tax Rate']);
        return view('Products\Views\tax-rates\edit', ['taxRate' => $taxRate]);
    }

    public function updateTaxRates($id)
    {
        $taxRate = (new TaxRatesModel())->find($id);

        if (!$this->hasPermission('tax_rates_edit')) {
            return redirect()->to(route_to('tax-rates.group', $taxRate->group_id))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'tax_name' => 'required',
            'tax_rate' => 'required',
            'tax_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Products\Views\tax-rates\edit', ['validation' => $this->validator, 'taxRate' => (new TaxRatesModel())->find($id)]);
        }

        $data = [
            'tax_name' => $this->request->getPost('tax_name'),
            'tax_rate' => $this->request->getPost('tax_rate'),
            'tax_status' => $this->request->getPost('tax_status'),
        ];

        (new TaxRatesModel())->update($id, $data);

        return redirect()->to(route_to('tax-rates.group', $taxRate->group_id))->with('notifySuccess', 'Tax Rate Updated Successfully');
    }

    public function deleteTaxRates($id)
    {
        $taxRate = (new TaxRatesModel())->find($id);

        if (!$this->hasPermission('tax_rates_delete')) {
            return redirect()->to(route_to('tax-rates.group', $taxRate->group_id))->with('error', 'Permission Denied');
        }
        (new TaxRatesModel())->delete($id);

        return redirect()->to(route_to('tax-rates.group', $taxRate->group_id))->with('notifySuccess', 'Tax Rate Deleted Successfully');
    }

    public function updateTaxRatesStatus()
    {
        $taxRateId = $this->request->getPost('id');
        $newStatus = $this->request->getPost('tax_status');
    
        try {
            if (empty($taxRateId) || !is_numeric($taxRateId) || empty($newStatus)) {
                throw new \Exception('Invalid input data');
            }
            $model = new TaxRatesModel();
            $model->update($taxRateId, ['tax_status' => $newStatus]);

            return $this->response->setJSON(['success' => true, 'message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            log_message('error', 'Failed to update status: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'An error occurred while updating status']);
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
        'tax_rates_list',  
        'tax_rates_add',
        'tax_rates_edit',
        'tax_rates_delete',
    ];

    return in_array($permission, $allowedPermissions);
}

}