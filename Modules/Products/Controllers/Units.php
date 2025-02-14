<?php
namespace Products\Controllers;

use App\Controllers\AdminBaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\RolePermissionModel;
use Products\Models\UnitsModel;

class Units extends AdminBaseController {

    public $title = 'Units';
    public $menu = 'units';

    public function units()
    {
        $listUnits = (new UnitsModel())->findAll();
        $this->updatePageData(['submenu' => 'Units List']);
        return view('Products\Views\units\list', compact('listUnits'));
    }

    public function addUnits()
    {
        if (!$this->hasPermission('units_add')) {
            return redirect()->to(route_to('units.index'))->with('error', 'Permission Denied');
        }
        $this->updatePageData(['submenu' => 'Add New Unit']);
        return view('Products\Views\units\add');
    }

    public function storeUnits()
    {
        if (!$this->hasPermission('units_add')) {
            return redirect()->to(route_to('units.index'))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'unit_name' => 'required',
            'unit_abbreviation' => 'required',
            'unit_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Products\Views\units\add', ['validation' => $this->validator]);
        }

        $data = [
            'unit_name' => $this->request->getPost('unit_name'),
            'unit_abbreviation' => $this->request->getPost('unit_abbreviation'),
            'unit_status' => $this->request->getPost('unit_status'),
        ];

        (new UnitsModel())->insert($data);

        return redirect()->to(route_to('units.index'))->with('notifySuccess', 'Unit Added Successfully');
    }

    public function editUnits($id)
    {
        if (!$this->hasPermission('units_edit')) {
            return redirect()->to(route_to('units.index'))->with('error', 'Permission Denied');
        }
        $unit = (new UnitsModel())->find($id);
        $this->updatePageData(['submenu' => 'Edit Units']);
        return view('Products\Views\units\edit', compact('unit'));
    }

    public function updateUnits($id)
    {
        if (!$this->hasPermission('units_edit')) {
            return redirect()->to(route_to('units.index'))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'unit_name' => 'required',
            'unit_abbreviation' => 'required',
            'unit_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Products\Views\units\edit', ['validation' => $this->validator, 'unit' => (new UnitsModel())->find($id)]);
        }

        $data = [
            'unit_name' => $this->request->getPost('unit_name'),
            'unit_abbreviation' => $this->request->getPost('unit_abbreviation'),
            'unit_status' => $this->request->getPost('unit_status'),
        ];

        (new UnitsModel())->update($id, $data);

        return redirect()->to(route_to('units.index'))->with('notifySuccess', 'Unit Updated Successfully');
    }

    public function deleteUnits($id)
    {
        if (!$this->hasPermission('units_delete')) {
            return redirect()->to(route_to('units.index'))->with('error', 'Permission Denied');
        }
        (new UnitsModel())->delete($id);

        return redirect()->to(route_to('units.index'))->with('notifySuccess', 'Unit Deleted Successfully');
    }

    public function updateUnitsStatus()
    {
        $unitId = $this->request->getPost('id');
        $newStatus = $this->request->getPost('unit_status');
    
        try {
            if (empty($unitId) || !is_numeric($unitId) || empty($newStatus)) {
                throw new \Exception('Invalid input data');
            }
            $model = new UnitsModel();
            $model->update($unitId, ['unit_status' => $newStatus]);

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
        'units_list',  
        'units_add',
        'units_edit',
        'units_delete',
    ];

    return in_array($permission, $allowedPermissions);
}

}