<?php

namespace App\Controllers;

use App\Models\UserModel;

class AdminAuth extends BaseController
{
    public function login()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/admin_login');
    }

    public function attempt()
    {
        $session = session();
        $model = new UserModel();
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        $user = $model->where('username', $username)
                      ->where('is_active', 1)
                      ->first();
        
        if ($user && password_verify($password, $user['password'])) {
            $session->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'full_name' => $user['full_name'],
                'role' => $user['role'],
                'is_logged_in' => true
            ]);
            log_activity('Login', "User {$user['username']} logged in");
            return redirect()->to('/dashboard');
        }
        return redirect()->to('/admin')->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin');
    }
}