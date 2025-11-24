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

        // 1. Validation Rules
        $rules = [
            'username' => 'required|min_length[3]',
        ];

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

        // 3. Handle Password Change
        if($this->request->getPost('password') != ''){
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // 4. Update Database
        $model->update($id, $data);

        // 5. Update Session Data (so the name changes instantly in the header)
        $session->set('username', $data['username']);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}