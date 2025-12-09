<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\FolderModel; 
use App\Models\FileModel; 

class Dashboard extends BaseController {
        
    public function admin() {
        $session = session();
        $role = $session->get('role');

        if($role == 'faculty'){ return redirect()->to('/faculty/dashboard'); }
        
        $db = \Config\Database::connect();
        $folderModel = new FolderModel();
        $userModel = new UserModel();
        
        $currentUser = $userModel->find($session->get('id'));
        $userDeptId = $currentUser['department_id'] ?? null;

        // --- A. FOLDERS ---
        $currentFolderId = $this->request->getGet('folder_id');
        $currentFolderId = !empty($currentFolderId) ? $currentFolderId : null;

        // [FIXED] Ambiguous column error by adding 'folders.' prefix
        $folderBuilder = $folderModel->where('parent_id', $currentFolderId)
                                     ->where('folders.is_archived', 0); 

        $folderBuilder->select('folders.*, departments.code as dept_code');
        $folderBuilder->join('departments', 'departments.id = folders.department_id', 'left');

        if($role === 'program_chair' && $userDeptId) {
            $folderBuilder->where('folders.department_id', $userDeptId);
        }

        $filterDept = $this->request->getGet('dept');
        if($role === 'admin' && !empty($filterDept)) {
            $folderBuilder->where('folders.department_id', $filterDept);
        }

        $data['folders'] = $folderBuilder->findAll();

        // Breadcrumbs
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

        // --- B. FILES ---
        $fileBuilder = $db->table('files');
        $fileBuilder->select('files.*, departments.code as dept_code');
        $fileBuilder->join('departments', 'departments.id = files.department_id', 'left');
        
        // [FIXED] Added 'files.' prefix
        $fileBuilder->where('files.is_archived', 0); 

        if($currentFolderId){
            $fileBuilder->where('files.folder_id', $currentFolderId);
        } else {
            $fileBuilder->where('files.folder_id', NULL);
        }

        if($role === 'program_chair') {
            if($userDeptId) {
                $fileBuilder->where('files.department_id', $userDeptId);
            } else {
                $fileBuilder->where('files.id', -1); 
            }
        }

        if($role === 'admin' && !empty($filterDept)) {
            $fileBuilder->where('files.department_id', $filterDept);
        }

        $search = $this->request->getGet('q');
        if(!empty($search)){ $fileBuilder->like('filename', $search); }

        $data['files'] = $fileBuilder->orderBy('files.created_at', 'DESC')->get()->getResultArray();
        $data['search_term'] = $search;
        
        if($role === 'admin') {
            // [FIXED] Filter archived departments in Dashboard dropdown too
            $data['departments'] = $db->table('departments')
                                      ->where('is_archived', 0)
                                      ->get()->getResultArray();
            $data['selected_dept'] = $filterDept;
        }

        return view('admin_dashboard', $data);
    }

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

        $currentFolderId = $this->request->getGet('folder_id');
        $currentFolderId = !empty($currentFolderId) ? $currentFolderId : null;

        $data['folders'] = $folderModel->where('parent_id', $currentFolderId)
                                       ->where('department_id', $userDeptId)
                                       ->where('folders.is_archived', 0) 
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

        $builder = $db->table('files');
        $builder->where('department_id', $userDeptId);
        $builder->where('files.is_archived', 0); 

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
                    ->where('users.is_archived', 0) 
                    ->orderBy('users.created_at', 'DESC')
                    ->get()->getResultArray();
        
        // [FIXED] Filter archived departments from the dropdown
        $departments = $db->table('departments')
                          ->where('is_archived', 0)
                          ->get()->getResultArray();

        $data['users'] = $users;
        $data['departments'] = $departments;

        return view('manage_users', $data);
    }

    public function createUser() {
        if(session()->get('role') !== 'admin') return redirect()->back();
        
        helper('log'); 
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
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');

        $model->save([
            'username'      => $username,
            'email'         => $this->request->getPost('email'),
            'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'          => $role,
            'department_id' => $this->request->getPost('department_id') ?: null,
        ]);

        save_log('Create User', "Created user: $username ($role)");

        return redirect()->back()->with('success', 'User created successfully.');
    }

    public function updateUser() {
        if(session()->get('role') !== 'admin') return redirect()->back();
        
        helper('log');
        $model = new UserModel();
        $id = $this->request->getPost('user_id');
        $username = $this->request->getPost('username');

        $data = [
            'username'      => $username,
            'role'          => $this->request->getPost('role'),
            'email'         => $this->request->getPost('email'),
            'department_id' => $this->request->getPost('department_id') ?: null,
        ];

        if($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $model->update($id, $data);

        save_log('Update User', "Updated user: $username (ID: $id)");

        return redirect()->back()->with('success', 'User updated.');
    }

    public function deleteUser($id) {
        if(session()->get('role') !== 'admin') return redirect()->back();
        
        helper('log');
        $db = \Config\Database::connect();
        
        $user = $db->table('users')->where('id', $id)->get()->getRowArray();
        
        if($user) {
            $db->table('users')->where('id', $id)->update(['is_archived' => 1]);
            save_log('Archive User', "Archived user: " . $user['username']);
            return redirect()->back()->with('success', 'User moved to archive.');
        }
        
        return redirect()->back()->with('error', 'User not found.');
    }

    public function logs() {
        if(session()->get('role') !== 'admin') return redirect()->to('/admin/dashboard');
        $model = new \App\Models\LogModel();
        $data['logs'] = $model->orderBy('created_at', 'DESC')->findAll();
        return view('activity_logs', $data);
    }
}