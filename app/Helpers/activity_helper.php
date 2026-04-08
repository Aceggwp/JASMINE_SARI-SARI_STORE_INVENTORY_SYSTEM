<?php

function log_activity($action, $description = null)
{
    $model = new \App\Models\ActivityLogModel();
    $model->insert([
        'user_id' => session()->get('user_id'),
        'action' => $action,
        'description' => $description,
        'ip_address' => \Config\Services::request()->getIPAddress(),
        'user_agent' => \Config\Services::request()->getUserAgent()->getAgentString()
    ]);
}