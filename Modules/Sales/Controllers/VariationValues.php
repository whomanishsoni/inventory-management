<?php
namespace Products\Controllers;

use App\Controllers\AdminBaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\RolePermissionModel;
use Products\Models\VariationsModel;
use Products\Models\VariationValuesModel;

class VariationValues extends AdminBaseController {

    public $title = 'Variation Values';
    public $menu = 'variation values';

    public function variationValues($variationId)
    {
        $listVariationValues = (new VariationValuesModel())->where('variation_id', $variationId)->findAll();
        $this->updatePageData(['submenu' => 'variation values List']);
        return view('Products\Views\variation-values\list', compact('listVariationValues', 'variationId'));
    }
    
    public function addVariationValues($variationId)
    {
        if (!$this->hasPermission('variation_values_add')) {
            return redirect()->to(route_to('variation-values.list', $variationId))->with('error', 'Permission Denied');
        }
        $this->updatePageData(['submenu' => 'Add New Variation Value']);
        return view('Products\Views\variation-values\add', compact('variationId'));
    }

    public function storeVariationValues($variationId)
    {
        if (!$this->hasPermission('variation_values_add')) {
            return redirect()->to(route_to('variation-values.list', $variationId))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'variation_id' => 'required|numeric',
            'variation_value' => 'required',
            'variation_value_status' => 'required|in_list[active,inactive]',
        ];

        // if (!$this->validate($validationRules)) {
        //     return view('Products\Views\variation-values\add', [
        //         'validation' => $this->validator,
        //     ]);
        // }

        $data = [ 
            'variation_id' => $variationId, 
            'variation_value' => $this->request->getPost('variation_value'),
            'variation_value_status' => $this->request->getPost('variation_value_status'),
        ];

        (new VariationValuesModel())->insert($data);

        return redirect()->to(route_to('variation-values.list', $variationId))->with('notifySuccess', 'Variation Value Added Successfully');
    }
    
    public function editVariationValues($variationId, $id)
    {
        if (!$this->hasPermission('variation_values_edit')) {
            return redirect()->to(route_to('variation-values.list', $variationId))->with('error', 'Permission Denied');
        }
    
        $variationValue = (new VariationValuesModel())->find($id);
    
        if (!$variationValue) {
            return redirect()->to(route_to('variation-values.list', $variationId))->with('error', 'Variation Value not found');
        }
    
        $this->updatePageData(['submenu' => 'Edit Variation Value']);
        return view('Products\Views\variation-values\edit', compact('variationValue', 'variationId'));
    } 

    public function updateVariationValues($variationId, $id)
    {
        if (!$this->hasPermission('variation_values_edit')) {
            return redirect()->to(route_to('variation-values.list', $variationId))->with('error', 'Permission Denied');
        }
    
        $validationRules = [
            'variation_id' => 'required|numeric',
            'variation_value' => 'required',
            'variation_value_status' => 'required|in_list[active,inactive]',
        ];

        // if (!$this->validate($validationRules)) {
        //     return view('Products\Views\variation-values\edit', ['validation' => $this->validator, 'variationValue' => (new VariationValuesModel())->find($id)]);
        // }
    
        $data = [
            'variation_id' => $variationId, 
            'variation_value' => $this->request->getPost('variation_value'),
            'variation_value_status' => $this->request->getPost('variation_value_status'),
        ];
    
        (new VariationValuesModel())->update($id, $data);
    
        return redirect()->to(route_to('variation-values.list', $variationId))->with('notifySuccess', 'Variation Value Updated Successfully');
    }

    public function deleteVariationValues($variationId, $id)
    {
        if (!$this->hasPermission('variation_values_delete')) {
            return redirect()->to(route_to('variation-values.list', $variationId))->with('error', 'Permission Denied');
        }
    
        (new VariationValuesModel())->delete($id);
    
        return redirect()->to(route_to('variation-values.list', $variationId))->with('notifySuccess', 'Variation Deleted Successfully');
    }
    

    public function updateVariationValuesStatus()
    {
        $variationValuesId = $this->request->getPost('id');
        $newStatus = $this->request->getPost('variation_value_status');
    
        try {
            if (empty($variationValuesId) || !is_numeric($variationValuesId) || empty($newStatus)) {
                throw new \Exception('Invalid input data');
            }
            $model = new VariationValuesModel();
            $model->update($variationValuesId, ['variation_value_status' => $newStatus]);

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
        'variation_values_list',  
        'variation_values_add',
        'variation_values_edit',
        'variation_values_delete',
    ];

    return in_array($permission, $allowedPermissions);
}

}