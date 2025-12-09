<?php namespace App\Controllers;

use App\Models\FileModel;
use App\Models\FolderModel;
use App\Models\UserModel;
use App\Models\DepartmentModel; // [NEW] Import Department Model

class Archive extends BaseController
{
    public function index()
    {
        if(session()->get('role') !== 'admin') return redirect()->back();
        
        $fileModel = new FileModel();
        $folderModel = new FolderModel();
        $userModel = new UserModel();
        $deptModel = new DepartmentModel(); // [NEW]

        $data['files'] = $fileModel->where('is_archived', 1)->findAll();
        $data['folders'] = $folderModel->where('is_archived', 1)->findAll();
        $data['users'] = $userModel->where('is_archived', 1)->findAll();
        // [NEW] Fetch archived departments
        $data['departments'] = $deptModel->where('is_archived', 1)->findAll(); 

        return view('archive_view', $data);
    }

    public function restore($type, $id)
    {
        if(session()->get('role') !== 'admin') return redirect()->back();
        helper('log');

        if ($type === 'file') {
            $model = new FileModel();
            $model->update($id, ['is_archived' => 0]);
            save_log('Restore', "Restored file ID: $id");
        } elseif ($type === 'folder') {
            $model = new FolderModel();
            $model->update($id, ['is_archived' => 0]);
            save_log('Restore', "Restored folder ID: $id");
        } elseif ($type === 'user') {
            $model = new UserModel();
            $model->update($id, ['is_archived' => 0]);
            save_log('Restore', "Restored user ID: $id");
        } elseif ($type === 'department') { // [NEW] Handle Department Restore
            $model = new DepartmentModel();
            $model->update($id, ['is_archived' => 0]);
            save_log('Restore', "Restored department ID: $id");
        }

        return redirect()->back()->with('success', ucfirst($type) . ' restored successfully.');
    }

    public function delete_permanent($type, $id)
    {
        if(session()->get('role') !== 'admin') return redirect()->back();
        helper('log');
        $db = \Config\Database::connect();

        if ($type === 'file') {
            $model = new FileModel();
            $file = $model->find($id);
            if ($file) {
                $model->delete($id, true); 
                if(file_exists('uploads/' . $file['file_path'])) {
                    unlink('uploads/' . $file['file_path']);
                }
                save_log('Permanent Delete', "Deleted file: " . $file['filename']);
            }
        } elseif ($type === 'folder') {
            $model = new FolderModel();
            $folder = $model->find($id);
            $model->delete($id, true);
            save_log('Permanent Delete', "Deleted folder: " . ($folder['name'] ?? 'Unknown'));
        } elseif ($type === 'user') {
            $model = new UserModel();
            $user = $model->find($id);
            $db->table('files')->where('user_id', $id)->delete();
            $model->delete($id, true);
            save_log('Permanent Delete', "Deleted user: " . ($user['username'] ?? 'Unknown'));
        } elseif ($type === 'department') { // [NEW] Handle Department Permanent Delete
            $model = new DepartmentModel();
            $dept = $model->find($id);
            
            // Optional: You might want to handle users attached to this department here
            // e.g., Set their department_id to null or delete them
            
            $model->delete($id, true);
            save_log('Permanent Delete', "Deleted department: " . ($dept['code'] ?? 'Unknown'));
        }

        return redirect()->back()->with('success', ucfirst($type) . ' permanently deleted.');
    }
}   