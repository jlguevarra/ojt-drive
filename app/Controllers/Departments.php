<?php namespace App\Controllers;

class Departments extends BaseController {
    
    // LIST DEPARTMENTS
    public function index() {
        if(session()->get('role') !== 'admin') return redirect()->to('admin/dashboard');

        $db = \Config\Database::connect();
        $data['departments'] = $db->table('departments')->get()->getResultArray();
        
        return view('manage_departments', $data);
    }

    // CREATE
    public function create() {
        if(session()->get('role') !== 'admin') return redirect()->back();
        
        $db = \Config\Database::connect();
        $db->table('departments')->insert([
            'code' => $this->request->getPost('code'),
            'name' => $this->request->getPost('name')
        ]);

        return redirect()->back()->with('success', 'Department added.');
    }

    // UPDATE
    public function update() {
        if(session()->get('role') !== 'admin') return redirect()->back();

        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');
        
        $db->table('departments')->where('id', $id)->update([
            'code' => $this->request->getPost('code'),
            'name' => $this->request->getPost('name')
        ]);

        return redirect()->back()->with('success', 'Department updated.');
    }

    // DELETE
    public function delete($id) {
        if(session()->get('role') !== 'admin') return redirect()->back();

        $db = \Config\Database::connect();
        $db->table('departments')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Department deleted.');
    }
}