<?php namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = 'users';
    protected $primaryKey = 'id';
    
    // CRITICAL FIX: Added 'department_id' here
    protected $allowedFields = [
        'username', 
        'email', 
        'password', 
        'role', 
        'department_id'
    ];
    
    // Helper to check if user is admin or chair
    public function isAdminOrChair($role) {
        return in_array($role, ['admin', 'program_chair']);
    }
}