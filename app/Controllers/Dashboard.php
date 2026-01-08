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
        $fileModel = new FileModel();
        $userModel = new UserModel();
        
        $currentUser = $userModel->find($session->get('id'));
        $userDeptId = $currentUser['department_id'] ?? null;

        // --- 1. GET PARAMETERS ---
        $currentFolderId = $this->request->getGet('folder_id');
        $currentFolderId = !empty($currentFolderId) ? $currentFolderId : null;
        $search = $this->request->getGet('q');
        $filterDept = $this->request->getGet('dept');
        $sort = $this->request->getGet('sort') ?? 'date_desc'; // Default: Newest first

        // --- 2. FETCH FOLDERS ---
        $folderBuilder = $folderModel->select('folders.id, folders.name as name, folders.created_at, "folder" as type, NULL as file_size, departments.code as dept_code')
                                     ->join('departments', 'departments.id = folders.department_id', 'left')
                                     ->where('folders.is_archived', 0)
                                     ->where('folders.parent_id', $currentFolderId);

        if($role === 'program_chair' && $userDeptId) {
            $folderBuilder->where('folders.department_id', $userDeptId);
        }
        if($role === 'admin' && !empty($filterDept)) {
            $folderBuilder->where('folders.department_id', $filterDept);
        }
        if(!empty($search)){ 
            $folderBuilder->like('folders.name', $search);
        }
        
        $folders = $folderBuilder->findAll();

        // --- 3. FETCH FILES ---
        $fileBuilder = $fileModel->select('files.id, files.filename as name, files.created_at, "file" as type, files.file_size, departments.code as dept_code')
                                 ->join('departments', 'departments.id = files.department_id', 'left')
                                 ->where('files.is_archived', 0);

        if($currentFolderId){
            $fileBuilder->where('files.folder_id', $currentFolderId);
        } else {
            $fileBuilder->where('files.folder_id', NULL);
        }

        if($role === 'program_chair') {
            if($userDeptId) $fileBuilder->where('files.department_id', $userDeptId);
            else $fileBuilder->where('files.id', -1); 
        }
        if($role === 'admin' && !empty($filterDept)) {
            $fileBuilder->where('files.department_id', $filterDept);
        }
        if(!empty($search)){ 
            $fileBuilder->like('files.filename', $search);
        }

        $files = $fileBuilder->findAll();

        // --- 4. MERGE & SORT ---
        $items = array_merge($folders, $files);

        usort($items, function($a, $b) use ($sort) {
            $dateA = strtotime($a['created_at']);
            $dateB = strtotime($b['created_at']);
            $nameA = strtolower($a['name']);
            $nameB = strtolower($b['name']);

            switch ($sort) {
                case 'date_asc': return $dateA <=> $dateB;
                case 'name_asc': return $nameA <=> $nameB;
                case 'name_desc': return $nameB <=> $nameA;
                case 'date_desc': 
                default: return $dateB <=> $dateA;
            }
        });

        // --- 5. MANUAL PAGINATION ---
        $pager = \Config\Services::pager();
        $page = $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1;
        $perPage = 8;
        $total = count($items);
        $offset = ($page - 1) * $perPage;
        
        // Slice the array for the current page
        $data['items'] = array_slice($items, $offset, $perPage);
        $data['pager_links'] = $pager->makeLinks($page, $perPage, $total, 'default_full');
        
        // --- 6. METADATA ---
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
        $data['search_term'] = $search;
        $data['sort_by'] = $sort;

        if($role === 'admin') {
            $data['departments'] = $db->table('departments')->where('is_archived', 0)->get()->getResultArray();
            $data['selected_dept'] = $filterDept;
        }

        return view('admin_dashboard', $data);
    }

    public function faculty() {
        $session = session();
        $db = \Config\Database::connect();
        $userModel = new \App\Models\UserModel();
        $folderModel = new \App\Models\FolderModel(); 
        $fileModel = new \App\Models\FileModel();

        $user = $userModel->find($session->get('id'));
        $userDeptId = $user['department_id'] ?? null;

        if(empty($userDeptId)) {
            return view('faculty_dashboard', ['files' => [], 'folders' => []]);
        }

        $currentFolderId = $this->request->getGet('folder_id');
        $currentFolderId = !empty($currentFolderId) ? $currentFolderId : null;
        $search = $this->request->getGet('q');

        // Folders
        $folderBuilder = $folderModel->where('parent_id', $currentFolderId)
                                     ->where('department_id', $userDeptId)
                                     ->where('folders.is_archived', 0);
        
        if(!empty($search)){ $folderBuilder->like('name', $search); }

        $data['folders'] = $folderBuilder->paginate(10, 'folders');
        $data['pager_folders'] = $folderModel->pager;

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

        // Files
        $fileBuilder = $fileModel->where('department_id', $userDeptId)
                                 ->where('files.is_archived', 0); 

        if($currentFolderId){
            $fileBuilder->where('folder_id', $currentFolderId);
        } else {
            $fileBuilder->where('folder_id', NULL);
        }

        if(!empty($search)){ $fileBuilder->like('filename', $search); }

        $data['files'] = $fileBuilder->orderBy('created_at', 'DESC')->paginate(10, 'files');
        $data['pager_files'] = $fileModel->pager;
        
        $data['search_term'] = $search;
        
        return view('faculty_dashboard', $data);
    }

    // --- USER MANAGEMENT ---
    public function users() {
        $session = session();
        if($session->get('role') !== 'admin') return redirect()->to('/admin/dashboard');

        $db = \Config\Database::connect();
        $myId = $session->get('id');
        $userModel = new UserModel();
        
        $data['users'] = $userModel->select('users.*, departments.code as dept_code')
                                   ->join('departments', 'departments.id = users.department_id', 'left')
                                   ->where('users.id !=', $myId)
                                   ->where('users.is_archived', 0)
                                   ->orderBy('users.created_at', 'DESC')
                                   ->paginate(5); 
        
        $data['pager'] = $userModel->pager;

        $data['departments'] = $db->table('departments')
                                  ->where('is_archived', 0)
                                  ->get()->getResultArray();

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
        
        $data['logs'] = $model->orderBy('created_at', 'DESC')->paginate(15); 
        $data['pager'] = $model->pager;
        
        return view('activity_logs', $data);
    }
}