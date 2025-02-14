<?php
namespace Products\Controllers;

use App\Controllers\AdminBaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\RolePermissionModel;
use Products\Models\VariationsModel;

class Variations extends AdminBaseController {

    public $title = 'Variations';
    public $menu = 'variations';

    public function variations()
    {
        $listVariations= (new VariationsModel())->findAll();
        $this->updatePageData(['submenu' => 'variation List']);
        return view('Products\Views\variations\list', compact('listVariations'));
    }
    
    public function addVariations()
    {
        if (!$this->hasPermission('variations_add')) {
            return redirect()->to(route_to('variations.index'))->with('error', 'Permission Denied');
        }
        $this->updatePageData(['submenu' => 'Add New Variation']);
        return view('Products\Views\variations\add');
    }

    public function storeVariations()
    {
        if (!$this->hasPermission('variations_add')) {
            return redirect()->to(route_to('variations.index'))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'variation_name' => 'required',
            'variation_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Products\Views\variations\add', ['validation' => $this->validator]);
        }

        $data = [
            'variation_name' => $this->request->getPost('variation_name'),
            'variation_status' => $this->request->getPost('variation_status'),
        ];

        (new VariationsModel())->insert($data);

        return redirect()->to(route_to('variations.index'))->with('notifySuccess', 'Variation Added Successfully');
    }
    
    public function editVariations($id)
    {
        if (!$this->hasPermission('variations_edit')) {
            return redirect()->to(route_to('variations.index'))->with('error', 'Permission Denied');
        }
        $variation = (new VariationsModel())->find($id);
        $this->updatePageData(['submenu' => 'Edit Variation']);
        return view('Products\Views\variations\edit', compact('variation'));
    }

    public function updateVariations($id)
    {
        if (!$this->hasPermission('variations_edit')) {
            return redirect()->to(route_to('variations.index'))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'variation_name' => 'required',
            'variation_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Products\Views\variations\edit', ['validation' => $this->validator, 'city' => (new CitiesModel())->find($id)]);
        }

        $data = [
            'variation_name' => $this->request->getPost('variation_name'),
            'variation_status' => $this->request->getPost('variation_status'),
        ];

        (new VariationsModel())->update($id, $data);

        return redirect()->to(route_to('variations.index'))->with('notifySuccess', 'Variation Updated Successfully');
    }
    

    public function deleteVariations($id)
    {
        if (!$this->hasPermission('variations_delete')) {
            return redirect()->to(route_to('variations.index'))->with('error', 'Permission Denied');
        }
        (new VariationsModel())->delete($id);

        return redirect()->to(route_to('variations.index'))->with('notifySuccess', 'Variation Deleted Successfully');
    }

    public function updateVariationsStatus()
    {
        $variationId = $this->request->getPost('id');
        $newStatus = $this->request->getPost('variation_status');
    
        try {
            if (empty($variationId) || !is_numeric($variationId) || empty($newStatus)) {
                throw new \Exception('Invalid input data');
            }
            $model = new VariationsModel();
            $model->update($variationId, ['variation_status' => $newStatus]);

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
        'variations_list',  
        'variations_add',
        'variations_edit',
        'variations_delete',
    ];

    return in_array($permission, $allowedPermissions);
}

}