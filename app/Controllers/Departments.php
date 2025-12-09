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
        // [CHANGED] Only fetch non-archived departments
        $data['departments'] = $model->where('is_archived', 0)->orderBy('id', 'DESC')->findAll();
        
        return view('manage_departments', $data);
    }

    public function create() {
        if(!$this->checkAccess()) return redirect()->back();
        
        helper('log'); // Load Helper
        $model = new DepartmentModel();
        $code = $this->request->getPost('code');

        $model->save([
            'code' => $code,
            'name' => $this->request->getPost('name')
        ]);

        // [LOGGING]
        save_log('Create Department', "Created department: $code");

        return redirect()->back()->with('success', 'Department added successfully.');
    }

    public function update() {
        if(!$this->checkAccess()) return redirect()->back();

        helper('log'); // Load Helper
        $model = new DepartmentModel();
        $id = $this->request->getPost('id');
        $code = $this->request->getPost('code');
        
        $model->update($id, [
            'code' => $code,
            'name' => $this->request->getPost('name')
        ]);

        // [LOGGING]
        save_log('Update Department', "Updated department ID: $id ($code)");

        return redirect()->back()->with('success', 'Department updated successfully.');
    }

// [CHANGED] Now Soft Deletes and Logs
    public function delete($id) {
        if(!$this->checkAccess()) return redirect()->back();

        helper('log'); // Load Helper
        $model = new DepartmentModel();
        $dept = $model->find($id); // Fetch info for the log

        // Soft Delete (Archive)
        $model->update($id, ['is_archived' => 1]);

        // [LOGGING]
        $deptName = $dept['code'] ?? 'Unknown';
        save_log('Archive Department', "Archived department: $deptName");

        return redirect()->back()->with('success', 'Department archived.');
    }
}