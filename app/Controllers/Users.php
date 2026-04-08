<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $data['users'] = $model->orderBy('id', 'DESC')->findAll();
        return view('users/index', $data);
    }
    
   public function create()
{
    $data['user'] = [];  // Ensure $user exists in view
    return view('users/form', $data);
}
    
    public function store()
    {
        $model = new UserModel();
        $data = [
            'username'  => $this->request->getPost('username'),
            'email'     => $this->request->getPost('email'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'full_name' => $this->request->getPost('full_name'),
            'role'      => $this->request->getPost('role'),
            'is_active' => $this->request->getPost('is_active') ?? 1
        ];
        
        if ($model->insert($data)) {
            log_activity('Create User', "Created user: {$data['username']}");
            return redirect()->to('/users')->with('success', 'User created successfully');
        }
        return redirect()->back()->with('errors', $model->errors());
    }
    
    public function edit($id)
{
    $model = new UserModel();
    $data['user'] = $model->find($id);
    if (!$data['user']) {
        return redirect()->to('/users')->with('error', 'User not found');
    }
    return view('users/form', $data);
}
    
    public function update($id)
{
    $model = new UserModel();
    $data = [
        'email'     => $this->request->getPost('email'),
        'full_name' => $this->request->getPost('full_name'),
        'role'      => $this->request->getPost('role'),
        'is_active' => $this->request->getPost('is_active') ?? 1
    ];
    
    $password = $this->request->getPost('password');
    if (!empty($password)) {
        $data['password'] = password_hash($password, PASSWORD_DEFAULT);
    }
    
    if ($model->update($id, $data)) {
        log_activity('Update User', "Updated user ID: {$id}");
        return redirect()->to('/users')->with('success', 'User updated successfully');
    }
    return redirect()->back()->with('errors', $model->errors());
}
    
    public function delete($id)
{
    $model = new UserModel();
    $user = $model->find($id);
    
    if (!$user) {
        return redirect()->to('/users')->with('error', 'User not found');
    }
    if ($user['id'] == session()->get('user_id')) {
        return redirect()->to('/users')->with('error', 'You cannot delete your own account');
    }
    
    if ($model->delete($id)) {
        log_activity('Delete User', "Deleted user: {$user['username']}");
        return redirect()->to('/users')->with('success', 'User deleted successfully');
    }
    return redirect()->to('/users')->with('error', 'Failed to delete user');
}

}