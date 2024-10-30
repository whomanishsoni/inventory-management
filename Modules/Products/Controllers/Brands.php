<?php
namespace Products\Controllers;

use App\Controllers\AdminBaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\RolePermissionModel;
use Products\Models\BrandsModel;

class Brands extends AdminBaseController {

    public $title = 'Brands';
    public $menu = 'brands';

    public function brands()
    {
        $listBrands = (new BrandsModel())->findAll();
        $this->updatePageData(['submenu' => 'Brands List']);
        return view('Products\Views\brands\list', compact('listBrands'));
    }

    public function addBrands()
    {
        if (!$this->hasPermission('brands_add')) {
            return redirect()->to(route_to('brands.index'))->with('error', 'Permission Denied');
        }
        $this->updatePageData(['submenu' => 'Add New Brand']);
        return view('Products\Views\brands\add');
    }

    public function storeBrands()
    {
        if (!$this->hasPermission('brands_add')) {
            return redirect()->to(route_to('brands.index'))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'brand_name' => 'required',
            'brand_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Products\Views\brands\add', ['validation' => $this->validator]);
        }

        $data = [
            'brand_name' => $this->request->getPost('brand_name'),
            'brand_status' => $this->request->getPost('brand_status'),
        ];

        (new BrandsModel())->insert($data);

        return redirect()->to(route_to('brands.index'))->with('notifySuccess', 'Brand Added Successfully');
    }

    public function editBrands($id)
    {
        if (!$this->hasPermission('brands_edit')) {
            return redirect()->to(route_to('brands.index'))->with('error', 'Permission Denied');
        }
        $brand = (new BrandsModel())->find($id);
        $this->updatePageData(['submenu' => 'Edit Brands']);
        return view('Products\Views\brands\edit', compact('brand'));
    }

    public function updateBrands($id)
    {
        if (!$this->hasPermission('brands_edit')) {
            return redirect()->to(route_to('brands.index'))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'brand_name' => 'required',
            'brand_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Products\Views\brands\edit', ['validation' => $this->validator, 'brand' => (new BrandsModel())->find($id)]);
        }

        $data = [
            'brand_name' => $this->request->getPost('brand_name'),
            'brand_status' => $this->request->getPost('brand_status'),
        ];

        (new BrandsModel())->update($id, $data);

        return redirect()->to(route_to('brands.index'))->with('notifySuccess', 'Brand Updated Successfully');
    }

    public function deleteBrands($id)
    {
        if (!$this->hasPermission('brands_delete')) {
            return redirect()->to(route_to('brands.index'))->with('error', 'Permission Denied');
        }
        (new BrandsModel())->delete($id);

        return redirect()->to(route_to('brands.index'))->with('notifySuccess', 'Brand Deleted Successfully');
    }

    public function updateBrandsStatus()
    {
        $brandId = $this->request->getPost('id');
        $newStatus = $this->request->getPost('brand_status');
    
        try {
            if (empty($brandId) || !is_numeric($brandId) || empty($newStatus)) {
                throw new \Exception('Invalid input data');
            }
            $model = new BrandsModel();
            $model->update($brandId, ['brand_status' => $newStatus]);

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
        'brands_list',  
        'brands_add',
        'brands_edit',
        'brands_delete',
    ];

    return in_array($permission, $allowedPermissions);
}

}