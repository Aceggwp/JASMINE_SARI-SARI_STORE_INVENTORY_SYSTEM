<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;

class Logs extends BaseController
{
    public function index()
    {
        $model = new ActivityLogModel();
        $data['logs'] = $model->select('activity_logs.*, users.full_name as user_name')
                              ->join('users', 'users.id = activity_logs.user_id', 'left')
                              ->orderBy('activity_logs.id', 'DESC')
                              ->paginate(20);
        $data['pager'] = $model->pager;
        return view('logs/index', $data);
    }
}