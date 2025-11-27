<?php namespace App\Controllers;

use App\Models\UserModel;

class Dashboard extends BaseController {
    
    // --- DASHBOARD: ADMIN & CHAIR ---
    public function admin() {
        $session = session();
        $role = $session->get('role');

        // Redirect Faculty away
        if($role == 'faculty'){ return redirect()->to('/faculty/dashboard'); }
        
        $db = \Config\Database::connect();
        $builder = $db->table('files');

        // 1. ISOLATION LOGIC
        if($role === 'program_chair') {
            // Program Chair: MUST filter by their Department
            $userModel = new UserModel();
            $user = $userModel->find($session->get('id'));
            
            if(!empty($user['department_id'])) {
                $builder->where('department_id', $user['department_id']);
            } else {
                // Safety: If Chair has no dept, show NOTHING (prevents leaking info)
                $builder->where('id', -1); 
            }
        }
        // Admin: No 'where' clause needed. They see everything.

        // 2. SEARCH & FILTER
        $search = $this->request->getGet('q');
        if(!empty($search)){ $builder->like('filename', $search); }

        $data['files'] = $builder->orderBy('created_at', 'DESC')->get()->getResultArray();
        $data['search_term'] = $search;

        return view('admin_dashboard', $data);
    }

    // --- DASHBOARD: FACULTY ---
    public function faculty() {
        $session = session();
        $db = \Config\Database::connect();
        $builder = $db->table('files');

        // Faculty: MUST filter by their Department
        $userModel = new UserModel();
        $user = $userModel->find($session->get('id'));
        
        if(!empty($user['department_id'])) {
            $builder->where('department_id', $user['department_id']);
        } else {
            $builder->where('id', -1); // Show nothing if no dept assigned
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
        
        // 1. Define Rules
        $rules = [
            'username' => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role'     => 'required'
        ];

        // 2. CONDITIONAL RULE: If Chair or Faculty, Department is REQUIRED
        $role = $this->request->getPost('role');
        if ($role === 'program_chair' || $role === 'faculty') {
            $rules['department_id'] = 'required'; // Must select a value
        }

        if (!$this->validate($rules)) {
            // Return specific errors so you know WHY it failed
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
}