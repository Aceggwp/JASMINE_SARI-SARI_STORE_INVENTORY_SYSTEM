<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class CustomerAuth extends BaseController
{
    public function login()
    {
        if (session()->get('customer_logged_in')) {
            return redirect()->to('/shop');
        }
        return view('customer/login');
    }

    public function attempt()
    {
        $model = new CustomerModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $customer = $model->where('email', $email)
                          ->where('is_active', 1)
                          ->first();

        if ($customer && password_verify($password, $customer['password'])) {
            session()->set([
                'customer_id'    => $customer['id'],
                'customer_name'  => $customer['name'],
                'customer_email' => $customer['email'],
                'customer_logged_in' => true
            ]);
            return redirect()->to('/shop')->with('success', 'Welcome back, ' . $customer['name']);
        }
        return redirect()->back()->with('error', 'Invalid email or password');
    }

    public function register()
    {
        if (session()->get('customer_logged_in')) {
            return redirect()->to('/shop');
        }
        return view('customer/register');
    }

    public function doRegister()
    {
        $model = new CustomerModel();
        $rules = [
            'name'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[customers.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'is_active'=> 1
        ];

        if ($model->insert($data)) {
            return redirect()->to('/customer/login')->with('success', 'Registration successful. Please login.');
        }
        return redirect()->back()->with('error', 'Registration failed.');
    }

    public function logout()
    {
        session()->remove(['customer_id', 'customer_name', 'customer_email', 'customer_logged_in']);
        return redirect()->to('/customer/login')->with('success', 'Logged out successfully.');
    }
}