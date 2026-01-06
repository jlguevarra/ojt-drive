<?php namespace App\Models;

use CodeIgniter\Model;

class DepartmentModel extends Model {
    protected $table = 'departments';
    protected $primaryKey = 'id';

    // Enable automatic timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = ['code', 'name', 'is_archived'];
}