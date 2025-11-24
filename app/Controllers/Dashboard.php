<?php namespace App\Controllers;

class Dashboard extends BaseController {
    
    public function admin() {
        $session = session();
        if($session->get('role') == 'faculty'){
             return redirect()->to('/faculty/dashboard');
        }
        
        $db = \Config\Database::connect();
        $builder = $db->table('files');

        // SEARCH LOGIC
        $search = $this->request->getGet('q'); // Get the search term from URL
        if(!empty($search)){
            $builder->like('filename', $search); // Filter by name
        }

        // Get results
        $data['files'] = $builder->orderBy('created_at', 'DESC')->get()->getResultArray();
        $data['search_term'] = $search; // Pass this back to the view

        return view('admin_dashboard', $data);
    }

    public function faculty() {
        $session = session();
        
        $db = \Config\Database::connect();
        $builder = $db->table('files');

        // SEARCH LOGIC (Same for Faculty)
        $search = $this->request->getGet('q');
        if(!empty($search)){
            $builder->like('filename', $search);
        }

        $data['files'] = $builder->orderBy('created_at', 'DESC')->get()->getResultArray();
        $data['search_term'] = $search;

        return view('faculty_dashboard', $data);
    }

    public function users() {
        $session = session();
        
        // 1. Security: Only Admin/Chair can see this
        if($session->get('role') == 'faculty'){
             return redirect()->to('/faculty/dashboard')->with('error', 'Unauthorized access');
        }

        // 2. Fetch all users
        $db = \Config\Database::connect();
        // We select everything EXCEPT the current logged-in user (so you don't delete yourself)
        $myId = $session->get('id');
        $query = $db->query("SELECT * FROM users WHERE id != $myId ORDER BY created_at DESC");
        
        $data['users'] = $query->getResultArray();

        return view('manage_users', $data);
    }

    public function deleteUser($id) {
        $session = session();
        
        // Security Check
        if($session->get('role') == 'faculty'){
             return redirect()->back();
        }

        $db = \Config\Database::connect();
        
        // Optional: Delete their files first to keep DB clean
        $db->table('files')->where('user_id', $id)->delete();
        
        // Delete the user
        $db->table('users')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'User removed successfully.');
    }
}