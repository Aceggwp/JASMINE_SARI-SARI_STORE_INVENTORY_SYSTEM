<?php

namespace App\Controllers;

use App\Models\CategoryModel;

class Categories extends BaseController
{
    public function index()
    {
        $model = new CategoryModel();
        $data['categories'] = $model->orderBy('id', 'DESC')->findAll();
        return view('categories/index', $data);
    }
    
    public function create()
    {
        return view('categories/form');
    }
    
    public function store()
    {
        $model = new CategoryModel();
        $data = [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'status'      => $this->request->getPost('status') ?? 1
        ];
        
        if ($model->insert($data)) {
            log_activity('Create Category', "Created category: {$data['name']}");
            return redirect()->to('/categories')->with('success', 'Category created successfully');
        }
        return redirect()->back()->with('errors', $model->errors());
    }
    
    public function edit($id)
    {
        $model = new CategoryModel();
        $data['category'] = $model->find($id);
        if (!$data['category']) {
            return redirect()->to('/categories')->with('error', 'Category not found');
        }
        return view('categories/form', $data);
    }
    
  public function update($id)
{
    $model = new CategoryModel();
    $data = [
        'name'        => $this->request->getPost('name'),
        'description' => $this->request->getPost('description'),
        'status'      => $this->request->getPost('status') ?? 1
    ];
    
    if ($model->update($id, $data)) {
        log_activity('Update Category', "Updated category ID: {$id}");
        return redirect()->to('/categories')->with('success', 'Category updated successfully');
    }
    return redirect()->back()->with('errors', $model->errors());
}
    
    public function delete($id)
{
    $model = new CategoryModel();
    $category = $model->find($id);
    if ($category && $model->delete($id)) {
        log_activity('Delete Category', "Deleted category: {$category['name']}");
        return redirect()->to('/categories')->with('success', 'Category deleted successfully');
    }
    return redirect()->to('/categories')->with('error', 'Failed to delete category');
}
}