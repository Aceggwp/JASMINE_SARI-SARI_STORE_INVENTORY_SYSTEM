<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table = 'activity_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'action', 'description', 'ip_address', 'user_agent'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
}