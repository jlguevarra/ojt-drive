<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\FolderModel; // 1. Load Folder Model

class FileHandler extends BaseController
{
    // --- 1. Create Folder (Now saves Department ID) ---
    public function create_folder()
    {
        $session = session();
        if($session->get('role') == 'faculty') { return redirect()->back()->with('error', 'Unauthorized'); }

        $folderModel = new FolderModel();
        $userModel = new UserModel();

        // Get User's Department
        $user = $userModel->find($session->get('id'));
        $deptId = $user['department_id'] ?? null; // If Admin has no dept, this is null (Global folder)

        $parentId = $this->request->getPost('parent_id');
        $parentId = !empty($parentId) ? $parentId : null;

        $data = [
            'name'          => $this->request->getPost('folder_name'),
            'parent_id'     => $parentId,
            'department_id' => $deptId // <--- THIS IS KEY
        ];

        $folderModel->save($data);
        return redirect()->back()->with('success', 'Folder created successfully');
    }

    // --- 2. Upload (Unchanged, just ensure Department ID logic is safe) ---
    public function upload()
    {
        $session = session();
        helper('log'); 
        
        $input = $this->validate([
            'userfile' => 'uploaded[userfile]|max_size[userfile,10240]|ext_in[userfile,png,jpg,jpeg,pdf,docx,xlsx,pptx,txt]'
        ]);

        if (!$input) {
            return redirect()->back()->with('error', 'Invalid file.');
        } else {
            $img = $this->request->getFile('userfile');
            
            if($img->isValid() && !$img->hasMoved()){
                $newName = $img->getRandomName(); 
                $originalName = $img->getClientName();
                $img->move('uploads/', $newName);

                $userModel = new UserModel();
                $currentUser = $userModel->find($session->get('id'));
                
                // Program Chair uploads get tagged with their Dept
                $deptId = $currentUser['department_id'] ?? null; 

                $folderId = $this->request->getPost('folder_id');
                $folderId = !empty($folderId) ? $folderId : null;

                $db = \Config\Database::connect();
                $builder = $db->table('files');
                
                $data = [
                    'user_id'       => $session->get('id'),
                    'department_id' => $deptId, 
                    'filename'      => $originalName,
                    'file_path'     => $newName,
                    'file_size'     => $img->getSizeByUnit('kb') . ' KB',
                    'folder_id'     => $folderId
                ];
                
                $builder->insert($data);
                
                $folderName = $folderId ? 'Folder ID: '.$folderId : 'Root';
                save_log('Upload', 'Uploaded file: ' . $originalName . ' to ' . $folderName);
                
                return redirect()->back()->with('success', 'File uploaded successfully.');
            }
        }
    }

    // --- 3. NEW: Delete Folder Function ---
    public function delete_folder($id)
    {
        // Only Admin/Chair
        if(session()->get('role') == 'faculty') { return redirect()->back()->with('error', 'Unauthorized'); }

        $folderModel = new FolderModel();
        
        // CodeIgniter Model delete() does not automatically cascade to DB foreign keys usually,
        // but if your DB table is set to ON DELETE CASCADE, contents will vanish.
        // If not, we should manually check, but for now:
        $folderModel->delete($id);

        return redirect()->back()->with('success', 'Folder deleted.');
    }

    public function download($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('files');
        $file = $builder->where('id', $id)->get()->getRow();

        if($file) {
            return $this->response->download('uploads/' . $file->file_path, null)->setFileName($file->filename);
        }
        
        return redirect()->back()->with('error', 'File not found.');
    }
    
    public function delete($id)
    {
        helper('log');
        if(session()->get('role') == 'faculty') {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('files');
        
        $file = $builder->where('id', $id)->get()->getRow();
        
        if($file){
            $builder->where('id', $id)->delete();
            save_log('Delete', 'Deleted a file (ID: '.$id.')');
            if(file_exists('uploads/' . $file->file_path)){
                unlink('uploads/' . $file->file_path);
            }
            return redirect()->back()->with('success', 'File deleted.');
        }
    }
    
     public function preview($id)
    {
        $db = \Config\Database::connect();
        $file = $db->table('files')->where('id', $id)->get()->getRow();

        if ($file) {
            $filePath = FCPATH . 'uploads/' . $file->file_path;
            
            if (file_exists($filePath)) {
                $mime = mime_content_type($filePath);
                header('Content-Type: ' . $mime);
                header('Content-Disposition: inline; filename="' . $file->filename . '"');
                header('Content-Transfer-Encoding: binary');
                header('Accept-Ranges: bytes');
                readfile($filePath);
                exit;
            }
        }
        return "File not found.";
    }
}