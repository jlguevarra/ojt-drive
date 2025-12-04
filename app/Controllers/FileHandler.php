<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\FolderModel; 
use App\Models\FileModel; // 1. Load the new FileModel

class FileHandler extends BaseController
{
    // --- 1. Create Folder ---
    public function create_folder()
    {
        $session = session();
        helper('log'); 

        if($session->get('role') == 'faculty') { 
            return redirect()->back()->with('error', 'Unauthorized'); 
        }

        $folderModel = new FolderModel();
        $userModel = new UserModel();

        // Get User's Department
        $user = $userModel->find($session->get('id'));
        $deptId = $user['department_id'] ?? null; 

        $parentId = $this->request->getPost('parent_id');
        $parentId = !empty($parentId) ? $parentId : null;
        $folderName = $this->request->getPost('folder_name');

        $data = [
            'name'          => $folderName,
            'parent_id'     => $parentId,
            'department_id' => $deptId
        ];

        $folderModel->save($data);

        // Logging
        $location = !empty($parentId) ? "Folder ID: $parentId" : "Root Directory";
        save_log('Create Folder', "Created folder '$folderName' in $location");

        return redirect()->back()->with('success', 'Folder created successfully');
    }

    // --- 2. Upload File (Updated) ---
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
                $deptId = $currentUser['department_id'] ?? null; 

                $folderId = $this->request->getPost('folder_id');
                $folderId = !empty($folderId) ? $folderId : null;

                // [UPDATED] Use FileModel instead of Builder
                $fileModel = new FileModel();
                
                $data = [
                    'user_id'       => $session->get('id'),
                    'department_id' => $deptId, 
                    'filename'      => $originalName,
                    'file_path'     => $newName,
                    'file_size'     => $img->getSizeByUnit('kb') . ' KB',
                    'folder_id'     => $folderId
                    // REMOVED: 'folder' => ... (No longer needed)
                ];
                
                $fileModel->save($data);
                
                // Logging
                $location = !empty($folderId) ? "Folder ID: $folderId" : "Root Directory";
                save_log('Upload', "Uploaded file '$originalName' to $location");
                
                return redirect()->back()->with('success', 'File uploaded successfully.');
            }
        }
    }

    // --- 3. ARCHIVE FOLDER (Modified) ---
    public function delete_folder($id)
    {
        $session = session();
        helper('log'); 

        if($session->get('role') == 'faculty') { return redirect()->back()->with('error', 'Unauthorized'); }

        $folderModel = new FolderModel();
        $folder = $folderModel->find($id);
        $folderName = $folder['name'] ?? 'Unknown Folder';

        // Soft Delete: Set is_archived to 1
        $folderModel->update($id, ['is_archived' => 1]);

        save_log('Archive', "Archived folder '$folderName' (ID: $id)");

        return redirect()->back()->with('success', 'Folder moved to archive.');
    }

    // --- 4. ARCHIVE FILE (Modified) ---
    public function delete($id)
    {
        $session = session();
        helper('log');

        if($session->get('role') == 'faculty') {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $fileModel = new FileModel();
        $file = $fileModel->find($id);
        
        if($file){
            // Soft Delete: Set is_archived to 1
            $fileModel->update($id, ['is_archived' => 1]);
            
            save_log('Archive', "Archived file '{$file['filename']}'");

            return redirect()->back()->with('success', 'File moved to archive.');
        }
        return redirect()->back()->with('error', 'File not found.');
    }

    // --- Download ---
    public function download($id)
    {
        $fileModel = new FileModel();
        $file = $fileModel->find($id);

        if($file) {
            return $this->response->download('uploads/' . $file['file_path'], null)->setFileName($file['filename']);
        }
        
        return redirect()->back()->with('error', 'File not found.');
    }
    
    // --- Preview ---
    public function preview($id)
    {
        $fileModel = new FileModel();
        $file = $fileModel->find($id);

        if ($file) {
            $filePath = FCPATH . 'uploads/' . $file['file_path'];
            
            if (file_exists($filePath)) {
                $mime = mime_content_type($filePath);
                header('Content-Type: ' . $mime);
                header('Content-Disposition: inline; filename="' . $file['filename'] . '"');
                header('Content-Transfer-Encoding: binary');
                header('Accept-Ranges: bytes');
                readfile($filePath);
                exit;
            }
        }
        return "File not found.";
    }
}