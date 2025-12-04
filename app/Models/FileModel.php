<?php 
namespace App\Models;
use CodeIgniter\Model;

class FileModel extends Model
{
    protected $table = 'files';
    protected $primaryKey = 'id';
    
    // We REMOVED 'folder' from this list.
    // We ADDED 'folder_id' and 'department_id'.
    protected $allowedFields = [
        'user_id', 
        'department_id', 
        'folder_id', 
        'filename', 
        'file_path', 
        'file_size', 
        'created_at',
        'is_archived'
    ];
}