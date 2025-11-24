<?php namespace App\Controllers;

class Dashboard extends BaseController {
    
    public function admin() {
        $session = session();
        if($session->get('role') == 'faculty'){
             return redirect()->to('/faculty/dashboard');
        }
        
        // Fetch all files
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM files ORDER BY created_at DESC");
        $data['files'] = $query->getResultArray();

        return view('admin_dashboard', $data);
    }

    public function faculty() {
        $session = session();
        
        // Fetch all files (Read Only)
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM files ORDER BY created_at DESC");
        $data['files'] = $query->getResultArray();

        // Note: You need to create a faculty_dashboard.php similar to admin
        // but REMOVE the upload form and REMOVE the delete button.
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