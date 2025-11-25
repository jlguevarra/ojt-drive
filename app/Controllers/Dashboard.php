<?php namespace App\Controllers;

use App\Models\UserModel; // <--- THIS WAS MISSING AND CAUSED THE ERROR

class Dashboard extends BaseController {
    
    public function admin() {
        $session = session();
        if($session->get('role') == 'faculty'){
             return redirect()->to('/faculty/dashboard');
        }
        
        $db = \Config\Database::connect();
        $builder = $db->table('files');

        // SEARCH LOGIC
        $search = $this->request->getGet('q'); 
        if(!empty($search)){
            $builder->like('filename', $search); 
        }

        $data['files'] = $builder->orderBy('created_at', 'DESC')->get()->getResultArray();
        $data['search_term'] = $search; 

        return view('admin_dashboard', $data);
    }

    public function faculty() {
        $session = session();
        $db = \Config\Database::connect();
        $builder = $db->table('files');

        $search = $this->request->getGet('q');
        if(!empty($search)){
            $builder->like('filename', $search);
        }

        $data['files'] = $builder->orderBy('created_at', 'DESC')->get()->getResultArray();
        $data['search_term'] = $search;

        return view('faculty_dashboard', $data);
    }

    // --- USER MANAGEMENT (ADMIN ONLY) ---

    public function users() {
        $session = session();
        
        // STRICT SECURITY: Only 'admin' allowed (Blocks Program Chair)
        if($session->get('role') !== 'admin'){
             return redirect()->to('/admin/dashboard')->with('error', 'Access Denied: Admins Only.');
        }

        $db = \Config\Database::connect();
        $myId = $session->get('id');
        $query = $db->query("SELECT * FROM users WHERE id != $myId ORDER BY created_at DESC");
        
        $data['users'] = $query->getResultArray();

        return view('manage_users', $data);
    }

    // CREATE
    public function createUser() {
        // STRICT SECURITY
        if(session()->get('role') !== 'admin') return redirect()->back();

        $model = new UserModel();
        
        if (!$this->validate([
            'username' => 'required',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role' => 'required'
        ])) {
            return redirect()->back()->with('error', 'Error: Email already exists or invalid input.');
        }

        $model->save([
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
        ]);

        return redirect()->back()->with('success', 'User created successfully.');
    }

    // UPDATE
    public function updateUser() {
        // STRICT SECURITY
        if(session()->get('role') !== 'admin') return redirect()->back();

        $model = new UserModel();
        $id = $this->request->getPost('user_id');
        
        $data = [
            'username' => $this->request->getPost('username'),
            'role'     => $this->request->getPost('role'),
            'email'    => $this->request->getPost('email'),
        ];

        // Only update password if admin typed a new one
        $newPass = $this->request->getPost('password');
        if(!empty($newPass)){
            $data['password'] = password_hash($newPass, PASSWORD_DEFAULT);
        }

        $model->update($id, $data);

        return redirect()->back()->with('success', 'User details updated.');
    }

    // DELETE
    public function deleteUser($id) {
        // STRICT SECURITY (Updated from your old Faculty check)
        if(session()->get('role') !== 'admin') return redirect()->back()->with('error', 'Unauthorized');

        $db = \Config\Database::connect();
        
        // Delete their files first
        $db->table('files')->where('user_id', $id)->delete();
        
        // Delete the user
        $db->table('users')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'User removed successfully.');
    }
}