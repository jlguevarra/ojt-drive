<?php 
namespace App\Models;
use CodeIgniter\Model;

class FileModel extends Model
{
    protected $table = 'files';
    protected $primaryKey = 'id';
    
    // [UPDATED] Enable timestamps
    protected $useTimestamps = true; 
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'user_id', 
        'department_id', 
        'folder_id', 
        'filename', 
        'file_path', 
        'file_size', 
        // 'created_at' and 'updated_at' are handled automatically by $useTimestamps
        'is_archived'
    ];
}