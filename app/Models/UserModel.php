<?php namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = 'users';
    protected $primaryKey = 'id';
    
    // Enable automatic timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'username', 
        'email', 
        'password', 
        'role', 
        'department_id',
        'is_archived'
    ];
    
    // Helper to check if user is admin or chair
    public function isAdminOrChair($role) {
        return in_array($role, ['admin', 'program_chair']);
    }
}