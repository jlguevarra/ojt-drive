<?php namespace App\Controllers;
use App\Models\UserModel;

// This handles the Login Logic and Role Redirection
class Auth extends BaseController {
    
    public function index() {
        return view('login');
    }

    public function login() {
        $session = session();
        $model = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        
        $data = $model->where('email', $email)->first();
        
        if($data){
            $pass = $data['password'];
            // verify_password would go here (using password_verify)
            // For simplicity in this example, assuming plain match or verifying hash
            if(password_verify($password, $pass)){ 
                $ses_data = [
                    'id'       => $data['id'],
                    'username' => $data['username'],
                    'email'    => $data['email'],
                    'role'     => $data['role'],
                    'logged_in'=> TRUE
                ];
                $session->set($ses_data);
                
                // ROLE BASED REDIRECTION
                // Admin and Chair go to same dashboard
                if($data['role'] == 'admin' || $data['role'] == 'program_chair'){
                    return redirect()->to('/admin/dashboard');
                } else {
                    return redirect()->to('/faculty/dashboard');
                }
            } else {
                $session->setFlashdata('msg', 'Wrong Password');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Email not Found');
            return redirect()->to('/login');
        }
    }
    
    public function logout() {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function register() {
        helper(['form']);
        return view('register');
    }

    public function store() {
        helper(['form']);
        
        // 1. Remove 'role' from validation rules (since it's not in the form anymore)
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]',
            'email'    => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]|max_length[200]'
        ];

        if($this->validate($rules)){
            $model = new UserModel();
            
            $data = [
                'username' => $this->request->getVar('username'),
                'email'    => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                
                // 2. HARDCODE THE ROLE HERE
                // Everyone who registers via the public form is 'faculty' by default.
                'role'     => 'faculty', 
            ];
            
            $model->save($data);
            
            return redirect()->to('/login')->with('msg_success', 'Account created! You can now login.');
        } else {
            $data['validation'] = $this->validator;
            return view('register', $data);
        }
    }
}
