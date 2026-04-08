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
        
        // Find user by username or email
        $user = $model->where('username', $username)
                      ->orWhere('email', $username)
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
            // Optional: log failed attempt
            return redirect()->to('/login')->with('error', 'Invalid username or password');
        }
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
        $model = new UserModel();
        
        // Validation rules
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
        
        $hashedPassword = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        
        $data = [
            'username'   => trim($this->request->getPost('username')),
            'email'      => trim($this->request->getPost('email')),
            'full_name'  => trim($this->request->getPost('full_name')),
            'password'   => $hashedPassword,
            'role'       => 'staff',
            'is_active'  => 1
        ];
        
        // Debug: log the data (remove after testing)
        // log_message('debug', 'Registration data: ' . print_r($data, true));
        
        if ($model->insert($data)) {
            // Verify user was actually inserted
            $newUser = $model->where('username', $data['username'])->first();
            if ($newUser && password_verify($this->request->getPost('password'), $newUser['password'])) {
                log_activity('User Registered', "New user registered: {$data['username']}");
                return redirect()->to('/login')->with('success', 'Registration successful! Please login.');
            } else {
                // Something went wrong with password hashing
                return redirect()->back()->withInput()->with('error', 'Registration failed due to internal error. Please try again.');
            }
        }
        
        return redirect()->back()->withInput()->with('error', 'Registration failed. Username or email may already exist.');
    }
    
    public function logout()
    {
        log_activity('Logout', "User " . session()->get('username') . " logged out");
        session()->destroy();
        return redirect()->to('/login');
    }
}