<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\FolderModel; 

class Dashboard extends BaseController {
        
    // --- DASHBOARD: ADMIN & CHAIR ---
    public function admin() {
        $session = session();
        $role = $session->get('role');

        if($role == 'faculty'){ return redirect()->to('/faculty/dashboard'); }
        
        $db = \Config\Database::connect();
        $folderModel = new FolderModel();
        $userModel = new UserModel();
        
        // Get Current User Details (to check their department)
        $currentUser = $userModel->find($session->get('id'));
        $userDeptId = $currentUser['department_id'] ?? null;

        // --- A. FOLDER LOGIC ---
        $currentFolderId = $this->request->getGet('folder_id');
        $currentFolderId = !empty($currentFolderId) ? $currentFolderId : null;

        // Start Query for Folders
        $folderBuilder = $folderModel->where('parent_id', $currentFolderId);

        // [MODIFIED] Join with Departments to get the Code (e.g. SCITE)
        $folderBuilder->select('folders.*, departments.code as dept_code');
        $folderBuilder->join('departments', 'departments.id = folders.department_id', 'left');

        // [RESTRICTION 1] If Program Chair -> SHOW ONLY OWN DEPT FOLDERS
        if($role === 'program_chair' && $userDeptId) {
            $folderBuilder->where('folders.department_id', $userDeptId);
        }

        // [RESTRICTION 2] If Admin selects a Dept from Dropdown -> FILTER FOLDERS
        $filterDept = $this->request->getGet('dept');
        if($role === 'admin' && !empty($filterDept)) {
            $folderBuilder->where('folders.department_id', $filterDept);
        }

        $data['folders'] = $folderBuilder->findAll();

        // Breadcrumbs Logic
        $breadcrumbs = [];
        if ($currentFolderId) {
            $tempId = $currentFolderId;
            while ($tempId) {
                $folder = $folderModel->find($tempId);
                if ($folder) {
                    array_unshift($breadcrumbs, ['id' => $folder['id'], 'name' => $folder['name']]);
                    $tempId = $folder['parent_id'];
                } else { break; }
            }
        }
        $data['breadcrumbs'] = $breadcrumbs;
        $data['current_folder_id'] = $currentFolderId;


        // --- B. FILE LOGIC ---
        $fileBuilder = $db->table('files');
        $fileBuilder->select('files.*, departments.code as dept_code');
        $fileBuilder->join('departments', 'departments.id = files.department_id', 'left');

        // Filter by Current Folder
        if($currentFolderId){
            $fileBuilder->where('files.folder_id', $currentFolderId);
        } else {
            $fileBuilder->where('files.folder_id', NULL);
        }

        // [RESTRICTION 1] Program Chair -> SHOW ONLY OWN DEPT FILES
        if($role === 'program_chair') {
            if($userDeptId) {
                $fileBuilder->where('files.department_id', $userDeptId);
            } else {
                $fileBuilder->where('files.id', -1); 
            }
        }

        // [RESTRICTION 2] Admin Filter
        if($role === 'admin' && !empty($filterDept)) {
            $fileBuilder->where('files.department_id', $filterDept);
        }

        // Search Logic
        $search = $this->request->getGet('q');
        if(!empty($search)){ $fileBuilder->like('filename', $search); }

        $data['files'] = $fileBuilder->orderBy('files.created_at', 'DESC')->get()->getResultArray();
        $data['search_term'] = $search;
        
        // Admin Dropdown Data
        if($role === 'admin') {
            $data['departments'] = $db->table('departments')->get()->getResultArray();
            $data['selected_dept'] = $filterDept;
        }

        return view('admin_dashboard', $data);
    }

    // --- DASHBOARD: FACULTY ---
    public function faculty() {
        $session = session();
        $db = \Config\Database::connect();
        $userModel = new \App\Models\UserModel();
        $folderModel = new \App\Models\FolderModel(); 

        $user = $userModel->find($session->get('id'));
        $userDeptId = $user['department_id'] ?? null;

        if(empty($userDeptId)) {
            return view('faculty_dashboard', ['files' => [], 'folders' => []]);
        }

        // --- A. FOLDER LOGIC ---
        $currentFolderId = $this->request->getGet('folder_id');
        $currentFolderId = !empty($currentFolderId) ? $currentFolderId : null;

        $data['folders'] = $folderModel->where('parent_id', $currentFolderId)
                                       ->where('department_id', $userDeptId)
                                       ->findAll();

        $breadcrumbs = [];
        if ($currentFolderId) {
            $tempId = $currentFolderId;
            while ($tempId) {
                $folder = $folderModel->find($tempId);
                if ($folder) {
                    array_unshift($breadcrumbs, ['id' => $folder['id'], 'name' => $folder['name']]);
                    $tempId = $folder['parent_id'];
                } else { break; }
            }
        }
        $data['breadcrumbs'] = $breadcrumbs;
        $data['current_folder_id'] = $currentFolderId;

        // --- B. FILE LOGIC ---
        $builder = $db->table('files');
        $builder->where('department_id', $userDeptId);

        if($currentFolderId){
            $builder->where('folder_id', $currentFolderId);
        } else {
            $builder->where('folder_id', NULL);
        }

        $search = $this->request->getGet('q');
        if(!empty($search)){ $builder->like('filename', $search); }

        $data['files'] = $builder->orderBy('created_at', 'DESC')->get()->getResultArray();
        $data['search_term'] = $search;
        
        return view('faculty_dashboard', $data);
    }

    // --- USER MANAGEMENT ---
    public function users() {
        $session = session();
        if($session->get('role') !== 'admin') return redirect()->to('/admin/dashboard');

        $db = \Config\Database::connect();
        $myId = $session->get('id');
        
        $users = $db->table('users')
                    ->select('users.*, departments.code as dept_code')
                    ->join('departments', 'departments.id = users.department_id', 'left')
                    ->where('users.id !=', $myId)
                    ->orderBy('users.created_at', 'DESC')
                    ->get()->getResultArray();
        
        $departments = $db->table('departments')->get()->getResultArray();

        $data['users'] = $users;
        $data['departments'] = $departments;

        return view('manage_users', $data);
    }

    public function createUser() {
        if(session()->get('role') !== 'admin') return redirect()->back();
        $model = new UserModel();
        
        $rules = [
            'username' => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role'     => 'required'
        ];

        $role = $this->request->getPost('role');
        if ($role === 'program_chair' || $role === 'faculty') {
            $rules['department_id'] = 'required'; 
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', implode(" ", $this->validator->getErrors()));
        }

        $model->save([
            'username'      => $this->request->getPost('username'),
            'email'         => $this->request->getPost('email'),
            'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'          => $role,
            'department_id' => $this->request->getPost('department_id') ?: null,
        ]);

        return redirect()->back()->with('success', 'User created successfully.');
    }

    public function updateUser() {
        if(session()->get('role') !== 'admin') return redirect()->back();
        $model = new UserModel();
        $id = $this->request->getPost('user_id');
        
        $data = [
            'username'      => $this->request->getPost('username'),
            'role'          => $this->request->getPost('role'),
            'email'         => $this->request->getPost('email'),
            'department_id' => $this->request->getPost('department_id') ?: null,
        ];

        if($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $model->update($id, $data);
        return redirect()->back()->with('success', 'User updated.');
    }

    public function deleteUser($id) {
        if(session()->get('role') !== 'admin') return redirect()->back();
        $db = \Config\Database::connect();
        $db->table('files')->where('user_id', $id)->delete();
        $db->table('users')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'User deleted.');
    }

    public function logs() {
        if(session()->get('role') !== 'admin') return redirect()->to('/admin/dashboard');
        $model = new \App\Models\LogModel();
        $data['logs'] = $model->orderBy('created_at', 'DESC')->findAll();
        return view('activity_logs', $data);
    }
}