<?php namespace App\Controllers;

use App\Models\DepartmentModel;

class Departments extends BaseController {
    
    // Helper function to check permission
    private function checkAccess() {
        $role = session()->get('role');
        return ($role === 'admin' || $role === 'program_chair');
    }

    public function index() {
        if(!$this->checkAccess()) return redirect()->to('admin/dashboard');

        $model = new DepartmentModel();
        $data['departments'] = $model->orderBy('id', 'DESC')->findAll();
        
        return view('manage_departments', $data);
    }

    public function create() {
        if(!$this->checkAccess()) return redirect()->back();
        
        $model = new DepartmentModel();
        $model->save([
            'code' => $this->request->getPost('code'),
            'name' => $this->request->getPost('name')
        ]);

        return redirect()->back()->with('success', 'Department added successfully.');
    }

    public function update() {
        if(!$this->checkAccess()) return redirect()->back();

        $model = new DepartmentModel();
        $id = $this->request->getPost('id');
        
        $model->update($id, [
            'code' => $this->request->getPost('code'),
            'name' => $this->request->getPost('name')
        ]);

        return redirect()->back()->with('success', 'Department updated successfully.');
    }

    public function delete($id) {
        if(!$this->checkAccess()) return redirect()->back();

        $model = new DepartmentModel();
        $model->delete($id);

        return redirect()->back()->with('success', 'Department deleted.');
    }
}