<?php
namespace Products\Controllers;

use App\Controllers\AdminBaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\RolePermissionModel;
use Products\Models\CategoriesModel;

class Categories extends AdminBaseController {

    public $title = 'Categories';
    public $menu = 'categories';

    public function categories()
    {
        $listCategories = (new CategoriesModel())->findAll();
        $this->updatePageData(['submenu' => 'Categories List']);
        return view('Products\Views\categories\list', compact('listCategories'));
    }

    public function addCategories()
    {
        if (!$this->hasPermission('categories_add')) {
            return redirect()->to(route_to('categories.index'))->with('error', 'Permission Denied');
        }
        $this->updatePageData(['submenu' => 'Add New Category']);
        return view('Products\Views\categories\add');
    }

    public function storeCategories()
    {
        if (!$this->hasPermission('categories_add')) {
            return redirect()->to(route_to('categories.index'))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'category_name' => 'required',
            'category_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Products\Views\categories\add', ['validation' => $this->validator]);
        }

        $data = [
            'category_name' => $this->request->getPost('category_name'),
            'category_description' => $this->request->getPost('category_description'),
            'category_status' => $this->request->getPost('category_status'),
        ];

        (new CategoriesModel())->insert($data);

        return redirect()->to(route_to('categories.index'))->with('notifySuccess', 'Category Added Successfully');
    }

    public function editCategories($id)
    {
        if (!$this->hasPermission('categories_edit')) {
            return redirect()->to(route_to('categories.index'))->with('error', 'Permission Denied');
        }
        $category = (new CategoriesModel())->find($id);
        $this->updatePageData(['submenu' => 'Edit Category']);
        return view('Products\Views\categories\edit', compact('category'));
    }

    public function updateCategories($id)
    {
        if (!$this->hasPermission('categories_edit')) {
            return redirect()->to(route_to('categories.index'))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'category_name' => 'required',
            'category_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Products\Views\categories\edit', ['validation' => $this->validator, 'category' => (new CategoriesModel())->find($id)]);
        }

        $data = [
            'category_name' => $this->request->getPost('category_name'),
            'category_description' => $this->request->getPost('category_description'),
            'category_status' => $this->request->getPost('category_status'),
        ];

        (new CategoriesModel())->update($id, $data);

        return redirect()->to(route_to('categories.index'))->with('notifySuccess', 'Category Updated Successfully');
    }

    public function deleteCategories($id)
    {
        if (!$this->hasPermission('categories_delete')) {
            return redirect()->to(route_to('categories.index'))->with('error', 'Permission Denied');
        }
        (new CategoriesModel())->delete($id);

        return redirect()->to(route_to('categories.index'))->with('notifySuccess', 'Category Deleted Successfully');
    }

    public function updateCategoriesStatus()
    {
        $categoryId = $this->request->getPost('id');
        $newStatus = $this->request->getPost('category_status');
    
        try {
            if (empty($categoryId) || !is_numeric($categoryId) || empty($newStatus)) {
                throw new \Exception('Invalid input data');
            }
            $model = new CategoriesModel();
            $model->update($categoryId, ['category_status' => $newStatus]);

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
        'categories_list',  
        'categories_add',
        'categories_edit',
        'categories_delete',
    ];

    return in_array($permission, $allowedPermissions);
}

}