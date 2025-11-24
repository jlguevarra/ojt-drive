<?php namespace App\Models;
use CodeIgniter\Model;

// User model to interact with users table
class UserModel extends Model {
    protected $table = 'users';
    protected $allowedFields = ['username', 'email', 'password', 'role'];
    
    // Helper to check if user is admin or chair
    public function isAdminOrChair($role) {
        return in_array($role, ['admin', 'program_chair']);
    }
}
