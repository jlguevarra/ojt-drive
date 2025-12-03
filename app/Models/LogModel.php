<?php namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model {
    protected $table = 'activity_logs';
    protected $allowedFields = ['user_id', 'user_name', 'role', 'action', 'details'];
}