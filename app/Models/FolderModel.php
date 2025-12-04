<?php 
namespace App\Models;
use CodeIgniter\Model;

class FolderModel extends Model
{
    protected $table = 'folders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['parent_id', 'name', 'department_id', 'created_at', 'is_archived'];
}   