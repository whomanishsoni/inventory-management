<?php
namespace Products\Controllers;

use App\Controllers\AdminBaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\RolePermissionModel;
use Products\Models\TaxGroupsModel;

class TaxGroups extends AdminBaseController {

    public $title = 'Tax Groups';
    public $menu = 'tax-groups';

    public function taxGroups()
    {
        $listGroups = (new TaxGroupsModel())->findAll();
        $this->updatePageData(['submenu' => 'Tax Groups List']);
        return view('Products\Views\tax-groups\list', compact('listGroups'));
    }

    public function addTaxGroups()
    {
        if (!$this->hasPermission('tax_groups_add')) {
            return redirect()->to(route_to('tax-groups.index'))->with('error', 'Permission Denied');
        }
        $this->updatePageData(['submenu' => 'Add New Tax Group']);
        return view('Products\Views\tax-groups\add');
    }

    public function storeTaxGroups()
    {
        if (!$this->hasPermission('tax_groups_add')) {
            return redirect()->to(route_to('tax-groups.index'))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'tax_group_name' => 'required',
            'tax_group_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Products\Views\tax-groups\add', ['validation' => $this->validator]);
        }

        $data = [
            'tax_group_name' => $this->request->getPost('tax_group_name'),
            'tax_group_status' => $this->request->getPost('tax_group_status'),
        ];

        (new TaxGroupsModel())->insert($data);

        return redirect()->to(route_to('tax-groups.index'))->with('notifySuccess', 'Tax Group Added Successfully');
    }

    public function editTaxGroups($id)
    {
        if (!$this->hasPermission('tax_groups_edit')) {
            return redirect()->to(route_to('tax-groups.index'))->with('error', 'Permission Denied');
        }
        $taxGroup = (new TaxGroupsModel())->find($id);
        $this->updatePageData(['submenu' => 'Edit Tax Group']);
        return view('Products\Views\tax-groups\edit', compact('taxGroup'));
    }

    public function updateTaxGroups($id)
    {
        if (!$this->hasPermission('tax_groups_edit')) {
            return redirect()->to(route_to('tax-groups.index'))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'tax_group_name' => 'required',
            'tax_group_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Products\Views\tax-groups\edit', ['validation' => $this->validator, 'taxGroup' => (new TaxGroupsModel())->find($id)]);
        }

        $data = [
            'tax_group_name' => $this->request->getPost('tax_group_name'),
            'tax_group_status' => $this->request->getPost('tax_group_status'),
        ];

        (new TaxGroupsModel())->update($id, $data);

        return redirect()->to(route_to('tax-groups.index'))->with('notifySuccess', 'Tax Group Updated Successfully');
    }

    public function deleteTaxGroups($id)
    {
        if (!$this->hasPermission('tax_groups_delete')) {
            return redirect()->to(route_to('tax-groups.index'))->with('error', 'Permission Denied');
        }
        (new TaxGroupsModel())->delete($id);

        return redirect()->to(route_to('tax-groups.index'))->with('notifySuccess', 'Tax Group Deleted Successfully');
    }

    public function updateTaxGroupsStatus()
    {
        $taxGroupId = $this->request->getPost('id');
        $newStatus = $this->request->getPost('tax_group_status');
    
        try {
            if (empty($taxGroupId) || !is_numeric($taxGroupId) || empty($newStatus)) {
                throw new \Exception('Invalid input data');
            }
            $model = new TaxGroupsModel();
            $model->update($taxGroupId, ['tax_group_status' => $newStatus]);

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
        'tax_groups_list',  
        'tax_groups_add',
        'tax_groups_edit',
        'tax_groups_delete',
    ];

    return in_array($permission, $allowedPermissions);
}

}