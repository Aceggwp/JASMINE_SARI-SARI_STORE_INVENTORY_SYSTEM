<?php

function log_activity($action, $description = null)
{
    $userId = session()->get('user_id');
    if (!$userId) {
        return; // No user logged in, skip logging
    }

    $db = \Config\Database::connect();
    $builder = $db->table('activity_logs');
    
    $builder->insert([
        'user_id'     => $userId,
        'action'      => $action,
        'description' => $description,
        'ip_address'  => \Config\Services::request()->getIPAddress(),
        'user_agent'  => \Config\Services::request()->getUserAgent()->getAgentString(),
        'created_at'  => date('Y-m-d H:i:s')
    ]);
}