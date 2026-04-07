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
}