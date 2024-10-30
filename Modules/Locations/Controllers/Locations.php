<?php
namespace Locations\Controllers;

use App\Controllers\AdminBaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\RolePermissionModel;
use Locations\Models\CountriesModel;
use Locations\Models\StatesModel;
use Locations\Models\CitiesModel;

class Locations extends AdminBaseController {

    public $title = 'Locations Management';
    public $menu = 'locations';

    //City Function
    public function cities()
    {
        $listCities = (new CitiesModel())
            ->select('cities.*, states.state_name, countries.country_name')
            ->join('states', 'states.id = cities.state_id')
            ->join('countries', 'countries.id = states.country_id')
            ->findAll();
        $this->updatePageData(['submenu' => 'City List']);
        return view('Locations\Views\locations\cities\list', compact('listCities'));
    }

    public function addCities()
    {
        if (!$this->hasPermission('cities_add')) {
            return redirect()->to(route_to('cities.index'))->with('error', 'Permission Denied');
        }
        $countryModel = new CountriesModel();
        $stateModel = new StatesModel();
        $countries = $countryModel->findAll();
        $states = $stateModel->findAll();
    
        $this->updatePageData(['submenu' => 'Add New City']);
        return view('Locations\Views\locations\cities\add', compact('countries', 'states'));
    }

    public function storeCities()
    {
        if (!$this->hasPermission('cities_add')) {
            return redirect()->to(route_to('cities.index'))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'city_name' => 'required',
            'city_status' => 'required|in_list[active,inactive]',
            'state_id' => 'required|integer',
            'country_id' => 'required|integer',
        ];
    
        if (!$this->validate($validationRules)) {
            $countryModel = new CountriesModel();
            $stateModel = new StatesModel();
            $countries = $countryModel->findAll();
            $states = $stateModel->findAll();
    
            return view('Locations\Views\locations\cities\add', [
                'validation' => $this->validator,
                'countries' => $countries,
                'states' => $states
            ]);
        }
    
        $data = [
            'city_name' => $this->request->getPost('city_name'),
            'city_status' => $this->request->getPost('city_status'),
            'state_id' => $this->request->getPost('state_id'),
            'country_id' => $this->request->getPost('country_id'),
        ];
    
        (new CitiesModel())->insert($data);
    
        return redirect()->to(route_to('cities.index'))->with('notifySuccess', 'City Added Successfully');
    }
    

    public function editCities($id)
    {
        if (!$this->hasPermission('cities_edit')) {
            return redirect()->to(route_to('cities.index'))->with('error', 'Permission Denied');
        }
        
        $cityModel = new CitiesModel();
        $city = $cityModel->find($id);
    
        $countryModel = new CountriesModel();
        $stateModel = new StatesModel();
        $countries = $countryModel->findAll();
        $states = $stateModel->findAll();
    
        $this->updatePageData(['submenu' => 'Edit Cities']);
        return view('Locations\Views\locations\cities\edit', compact('city', 'countries', 'states'));
    }
    

    public function updateCities($id)
    {
        if (!$this->hasPermission('cities_edit')) {
            return redirect()->to(route_to('cities.index'))->with('error', 'Permission Denied');
        }
        
        $validationRules = [
            'city_name' => 'required',
            'city_status' => 'required|in_list[active,inactive]',
            'state_id' => 'required|integer',
            'country_id' => 'required|integer',
        ];
    
        if (!$this->validate($validationRules)) {
            $countryModel = new CountriesModel();
            $stateModel = new StatesModel();
            $countries = $countryModel->findAll();
            $states = $stateModel->findAll();
            
            return view('Locations\Views\locations\cities\edit', [
                'validation' => $this->validator,
                'city' => (new CitiesModel())->find($id),
                'countries' => $countries,
                'states' => $states
            ]);
        }
    
        $data = [
            'city_name' => $this->request->getPost('city_name'),
            'city_status' => $this->request->getPost('city_status'),
            'state_id' => $this->request->getPost('state_id'),
            'country_id' => $this->request->getPost('country_id'),
        ];
    
        (new CitiesModel())->update($id, $data);
    
        return redirect()->to(route_to('cities.index'))->with('notifySuccess', 'City Updated Successfully');
    }
    

    public function deleteCities($id)
    {
        if (!$this->hasPermission('cities_delete')) {
            return redirect()->to(route_to('cities.index'))->with('error', 'Permission Denied');
        }
        (new CitiesModel())->delete($id);

        return redirect()->to(route_to('cities.index'))->with('notifySuccess', 'City Deleted Successfully');
    }

    public function updateCitiesStatus()
    {
        $cityId = $this->request->getPost('id');
        $newStatus = $this->request->getPost('city_status');
    
        try {
            if (empty($cityId) || !is_numeric($cityId) || empty($newStatus)) {
                throw new \Exception('Invalid input data');
            }
            $model = new CitiesModel();
            $model->update($cityId, ['city_status' => $newStatus]);

            return $this->response->setJSON(['success' => true, 'message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            log_message('error', 'Failed to update status: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'An error occurred while updating status']);
        }
    }

    //State Function
    public function states()
    {
        $listStates = (new StatesModel())
            ->select('states.*, countries.country_name')
            ->join('countries', 'countries.id = states.country_id')
            ->findAll();
        
        $this->updatePageData(['submenu' => 'State List']);
        return view('Locations\Views\locations\states\list', compact('listStates'));
    }
    
    public function addStates()
    {
        if (!$this->hasPermission('states_add')) {
            return redirect()->to(route_to('states.index'))->with('error', 'Permission Denied');
        }
        
        // Load countries data
        $countryModel = new CountriesModel();
        $countries = $countryModel->findAll();

        $this->updatePageData(['submenu' => 'Add New State']);
        
        // Pass countries data to the view
        return view('Locations\Views\locations\states\add', ['countries' => $countries]);
    }

    public function storeStates()
    {
        if (!$this->hasPermission('states_add')) {
            return redirect()->to(route_to('states.index'))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'country_id' => 'required|integer',
            'state_name' => 'required',
            'state_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($validationRules)) {
            $countryModel = new CountriesModel();
            $countries = $countryModel->findAll();
            return view('Locations\Views\locations\states\add', ['validation' => $this->validator, 'countries' => $countries]);
        }

        $data = [
            'country_id' => $this->request->getPost('country_id'),
            'state_name' => $this->request->getPost('state_name'),
            'state_status' => $this->request->getPost('state_status'),
        ];

        (new StatesModel())->insert($data);

        return redirect()->to(route_to('states.index'))->with('notifySuccess', 'State Added Successfully');
    }

    public function editStates($id)
    {
        if (!$this->hasPermission('states_edit')) {
            return redirect()->to(route_to('states.index'))->with('error', 'Permission Denied');
        }
    
        $state = (new StatesModel())->find($id);
        $countryModel = new CountriesModel();
        $countries = $countryModel->findAll();
    
        $this->updatePageData(['submenu' => 'Edit States']);
        return view('Locations\Views\locations\states\edit', compact('state', 'countries'));
    }

    public function updateStates($id)
    {
        if (!$this->hasPermission('states_edit')) {
            return redirect()->to(route_to('states.index'))->with('error', 'Permission Denied');
        }
    
        $validationRules = [
            'country_id' => 'required|integer',
            'state_name' => 'required',
            'state_status' => 'required|in_list[active,inactive]',
        ];
    
        if (!$this->validate($validationRules)) {
            $countryModel = new CountriesModel();
            $countries = $countryModel->findAll();
            return view('Locations\Views\locations\states\edit', [
                'validation' => $this->validator,
                'state' => (new StatesModel())->find($id),
                'countries' => $countries
            ]);
        }
    
        $data = [
            'country_id' => $this->request->getPost('country_id'),
            'state_name' => $this->request->getPost('state_name'),
            'state_status' => $this->request->getPost('state_status'),
        ];
    
        (new StatesModel())->update($id, $data);
    
        return redirect()->to(route_to('states.index'))->with('notifySuccess', 'State Updated Successfully');
    }
    

    public function deleteStates($id)
    {
        if (!$this->hasPermission('states_delete')) {
            return redirect()->to(route_to('states.index'))->with('error', 'Permission Denied');
        }
        (new StatesModel())->delete($id);

        return redirect()->to(route_to('states.index'))->with('notifySuccess', 'State Deleted Successfully');
    }

    public function updateStatesStatus()
    {
        $stateId = $this->request->getPost('id');
        $newStatus = $this->request->getPost('state_status');
    
        try {
            if (empty($stateId) || !is_numeric($stateId) || empty($newStatus)) {
                throw new \Exception('Invalid input data');
            }
            $model = new StatesModel();
            $model->update($stateId, ['state_status' => $newStatus]);

            return $this->response->setJSON(['success' => true, 'message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            log_message('error', 'Failed to update status: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'An error occurred while updating status']);
        }
    }

    //Country Function
    public function countries()
    {
        $listCountries = (new CountriesModel())->findAll();
        $this->updatePageData(['submenu' => 'Countries List']);
        return view('Locations\Views\locations\countries\list', compact('listCountries'));
    }

    public function addCountries()
    {
        if (!$this->hasPermission('countries_add')) {
            return redirect()->to(route_to('countries.index'))->with('error', 'Permission Denied');
        }
        $this->updatePageData(['submenu' => 'Add New Country']);
        return view('Locations\Views\locations\countries\add');
    }

    public function storeCountries()
    {
        if (!$this->hasPermission('countries_add')) {
            return redirect()->to(route_to('countries.index'))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'country_name' => 'required',
            'country_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Locations\Views\locations\countries\add', ['validation' => $this->validator]);
        }

        $data = [
            'country_name' => $this->request->getPost('country_name'),
            'country_status' => $this->request->getPost('country_status'),
        ];

        (new CountriesModel())->insert($data);

        return redirect()->to(route_to('countries.index'))->with('notifySuccess', 'Country Added Successfully');
    }

    public function editCountries($id)
    {
        if (!$this->hasPermission('countries_edit')) {
            return redirect()->to(route_to('countries.index'))->with('error', 'Permission Denied');
        }
        $country = (new CountriesModel())->find($id);
        $this->updatePageData(['submenu' => 'Edit Countries']);
        return view('Locations\Views\locations\countries\edit', compact('country'));
    }

    public function updateCountries($id)
    {
        if (!$this->hasPermission('countries_edit')) {
            return redirect()->to(route_to('countries.index'))->with('error', 'Permission Denied');
        }
        $validationRules = [
            'country_name' => 'required',
            'country_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($validationRules)) {
            return view('Locations\Views\location\countries\edit', ['validation' => $this->validator, 'country' => (new CountriesModel())->find($id)]);
        }

        $data = [
            'country_name' => $this->request->getPost('country_name'),
            'country_status' => $this->request->getPost('country_status'),
        ];

        (new CountriesModel())->update($id, $data);

        return redirect()->to(route_to('countries.index'))->with('notifySuccess', 'Country Updated Successfully');
    }

    public function deleteCountries($id)
    {
        if (!$this->hasPermission('countries_delete')) {
            return redirect()->to(route_to('countries.index'))->with('error', 'Permission Denied');
        }
        (new CountriesModel())->delete($id);

        return redirect()->to(route_to('countries.index'))->with('notifySuccess', 'Country Deleted Successfully');
    }

    public function updateCountriesStatus()
    {
        $countryId = $this->request->getPost('id');
        $newStatus = $this->request->getPost('country_status');
    
        try {
            if (empty($countryId) || !is_numeric($countryId) || empty($newStatus)) {
                throw new \Exception('Invalid input data');
            }
            $model = new CountriesModel();
            $model->update($countryId, ['country_status' => $newStatus]);

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
        'cities_list',  
        'cities_add',
        'cities_edit',
        'cities_delete',
        'states_list',  
        'states_add',
        'states_edit',
        'states_delete',
        'countries_list',  
        'countries_add',
        'countries_edit',
        'countries_delete',
    ];

    return in_array($permission, $allowedPermissions);
}

}