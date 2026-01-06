<?php 
namespace App\Models;
use CodeIgniter\Model;

class FolderModel extends Model
{
    protected $table = 'folders';
    protected $primaryKey = 'id';
    
    // [UPDATED] Enable timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = ['parent_id', 'name', 'department_id', 'is_archived'];
}