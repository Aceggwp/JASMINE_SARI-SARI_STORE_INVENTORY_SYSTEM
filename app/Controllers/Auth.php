<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }
    
    public function attempt()
    {
        $session = session();
        $model = new UserModel();
        
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        
        $user = $model->where('username', $username)
                      ->where('is_active', 1)
                      ->first();
        
        if ($user && password_verify($password, $user['password'])) {
            $sessionData = [
                'user_id' => $user['id'],
                'username' => $user['username'],
                'full_name' => $user['full_name'],
                'role' => $user['role'],
                'is_logged_in' => true
            ];
            $session->set($sessionData);
            log_activity('Login', "User {$user['username']} logged in");
            return redirect()->to('/dashboard');
        } else {
            return redirect()->to('/login')->with('error', 'Invalid username or password');
        }
    }
    
    public function logout()
    {
        log_activity('Logout', "User " . session()->get('username') . " logged out");
        session()->destroy();
        return redirect()->to('/login');
    }

    public function register()
{
    if (session()->get('is_logged_in')) {
        return redirect()->to('/dashboard');
    }
    return view('auth/register');
}

public function doRegister()
{
    $model = new \App\Models\UserModel();
    
    $rules = [
        'username' => 'required|min_length[3]|is_unique[users.username]',
        'email'    => 'required|valid_email|is_unique[users.email]',
        'full_name'=> 'required|min_length[3]',
        'password' => 'required|min_length[6]',
        'confirm_password' => 'required|matches[password]'
    ];
    
    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }
    
    $data = [
        'username'   => $this->request->getPost('username'),
        'email'      => $this->request->getPost('email'),
        'full_name'  => $this->request->getPost('full_name'),
        'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'role'       => 'staff',   // default role
        'is_active'  => 1
    ];
    
    if ($model->insert($data)) {
        log_activity('User Registered', "New user registered: {$data['username']}");
        return redirect()->to('/login')->with('success', 'Registration successful. Please login.');
    }
    
    return redirect()->back()->with('error', 'Registration failed. Please try again.');
}
}