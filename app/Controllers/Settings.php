<?php namespace App\Controllers;

use App\Models\UserModel;

class Settings extends BaseController
{
    public function index()
    {
        return view('settings');
    }

    public function update()
    {
        $session = session();
        $model = new UserModel();
        $id = $session->get('id');
        $role = $session->get('role'); // Get the current user's role

        // 1. Validation Rules
        $rules = [
            'username' => 'required|min_length[3]',
        ];

        // Allow Admin to update email
        if ($role == 'admin') {
            // Required, valid email, and unique in users table (ignoring current user's ID)
            $rules['email'] = "required|valid_email|is_unique[users.email,id,$id]";
        }

        // Only validate password if the user typed one in
        if($this->request->getPost('password') != ''){
            $rules['password'] = 'min_length[6]';
            $rules['confpassword'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Prepare Data
        $data = [
            'username' => $this->request->getPost('username'),
        ];

        // Add email to data if user is admin
        if ($role == 'admin') {
            $data['email'] = $this->request->getPost('email');
        }

        // 3. Handle Password Change
        if($this->request->getPost('password') != ''){
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // 4. Update Database
        $model->update($id, $data);

        // 5. Update Session Data
        $session->set('username', $data['username']);
        
        // Update session email if changed by admin
        if ($role == 'admin') {
            $session->set('email', $data['email']);
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}