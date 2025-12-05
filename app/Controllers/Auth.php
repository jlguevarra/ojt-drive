<?php namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        helper(['form']);
        return view('login');
    }

    public function login()
    {
        $session = session();
        $model = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        
        $user = $model->where('email', $email)->first();
        
        if($user){
            // CHECK IF ARCHIVED
            if($user['is_archived'] == 1) {
                return redirect()->back()->with('error', 'Your account has been deactivated. Contact Admin.');
            }

            $pass = $user['password'];
            if(password_verify($password, $pass)){
                $ses_data = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'logged_in' => TRUE
                ];
                $session->set($ses_data);
                
                if($user['role'] == 'admin') return redirect()->to('/admin/dashboard');
                if($user['role'] == 'program_chair') return redirect()->to('/admin/dashboard');
                return redirect()->to('/faculty/dashboard');
            } else {
                // WRONG PASSWORD
                return redirect()->back()->with('error', 'Invalid email or password.');
            }
        } else {
            // USER NOT FOUND (Use same message as wrong password)
            return redirect()->back()->with('error', 'Invalid email or password.');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }

    public function register()
    {
        helper(['form']);
        return view('register');
    }

    public function store()
    {
        helper(['form']);
        $rules = [
            'username'          => 'required|min_length[2]|max_length[50]',
            'email'         => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.email]',
            'password'      => 'required|min_length[4]|max_length[50]',
            'confirmpassword'  => 'matches[password]'
        ];

        if($this->validate($rules)){
            $model = new UserModel();
            $data = [
                'username'     => $this->request->getVar('username'),
                'email'    => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'role'     => 'faculty' // Default role for registration
            ];
            $model->save($data);
            return redirect()->to('/login');
        }else{
            $data['validation'] = $this->validator;
            return view('register', $data);
        }
    }
}