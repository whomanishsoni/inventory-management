<?php
namespace Products\Controllers;

use App\Controllers\AdminBaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\RolePermissionModel;
use Products\Models\CategoriesModel;
use Products\Models\SubCategoriesModel;

class SubCategories extends AdminBaseController {

    public $title = 'Sub Categories';
    public $menu = 'Sub-Categories';

    public function subCategories()
    {
        $listSubCategories = (new SubCategoriesModel())
        ->join('categories', 'categories.id = `sub_categories`.category_id')
        ->select('`sub_categories`.*, categories.category_name')
        ->findAll();
        $this->updatePageData(['submenu' => 'Sub-Categories List']);
        return view('Products\Views\sub-categories\list', compact('listSubCategories'));
    }

    public function addSubCategories()
    {
        if (!$this->hasPermission('sub_categories_add')) {
            return redirect()->to(route_to('sub-categories.index'))->with('error', 'Permission Denied');
        }

        $categoryModel = new CategoriesModel();
        $data['categories'] = $categoryModel->asArray()->findAll();

        $this->updatePageData(['submenu' => 'Add New Sub-Category']);
        return view('Products\Views\sub-categories\add', $data);
    }

    public function storeSubCategories()
    {
        if (!$this->hasPermission('sub_categories_add')) {
            return redirect()->to(route_to('sub-categories.index'))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'category_name' => 'required',
            'sub_category_name' => 'required',
            'sub_category_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Products\Views\sub-categories\add', ['validation' => $this->validator]);
        }

        $data = [
            'category_id' => $this->request->getPost('category_name'),
            'sub_category_name' => $this->request->getPost('sub_category_name'),
            'sub_category_description' => $this->request->getPost('sub_category_description'),
            'sub_category_status' => $this->request->getPost('sub_category_status'),
        ];

        (new SubCategoriesModel())->insert($data);

        return redirect()->to(route_to('sub-categories.index'))->with('notifySuccess', 'Sub Category Added Successfully');
    }

    public function editSubCategories($id)
    {
        if (!$this->hasPermission('sub_categories_edit')) {
            return redirect()->to(route_to('sub-categories.index'))->with('error', 'Permission Denied');
        }

        $subCategoryModel = new SubCategoriesModel();
        $categoriesModel = new CategoriesModel();

        $subCategory = $subCategoryModel->find($id);
        $categories = $categoriesModel->findAll();

        $this->updatePageData(['submenu' => 'Edit Sub-Category']);
        return view('Products\Views\sub-categories\edit', compact('subCategory', 'categories'));
    }

    public function updateSubCategories($id)
    {
        if (!$this->hasPermission('sub_categories_edit')) {
            return redirect()->to(route_to('sub-categories.index'))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'category_name' => 'required',
            'sub_category_name' => 'required',
            'sub_category_name' => 'required',
            'sub_category_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Products\Views\sub-categories\edit', ['validation' => $this->validator, 'subCategory' => (new SubCategoriesModel())->find($id)]);
        }

        $data = [
            'category_id' => $this->request->getPost('category_name'),
            'sub_category_name' => $this->request->getPost('sub_category_name'),
            'sub_category_description' => $this->request->getPost('sub_category_description'),
            'sub_category_status' => $this->request->getPost('sub_category_status'),
        ];

        (new SubCategoriesModel())->update($id, $data);

        return redirect()->to(route_to('sub-categories.index'))->with('notifySuccess', 'Sub-Category Updated Successfully');
    }

    public function deleteSubCategories($id)
    {
        if (!$this->hasPermission('sub_categories_delete')) {
            return redirect()->to(route_to('sub-categories.index'))->with('error', 'Permission Denied');
        }
        (new SubCategoriesModel())->delete($id);

        return redirect()->to(route_to('sub-categories.index'))->with('notifySuccess', 'Sub Category Deleted Successfully');
    }

    public function updateSubCategoriesStatus()
    {
        $sub_categoryId = $this->request->getPost('id');
        $newStatus = $this->request->getPost('sub_category_status');
    
        try {
            if (empty($sub_categoryId) || !is_numeric($sub_categoryId) || empty($newStatus)) {
                throw new \Exception('Invalid input data');
            }
            $model = new SubCategoriesModel();
            $model->update($sub_categoryId, ['sub_category_status' => $newStatus]);

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
        'sub_categories_list',  
        'sub_categories_add',
        'sub_categories_edit',
        'sub_categories_delete',
    ];

    return in_array($permission, $allowedPermissions);
}

}