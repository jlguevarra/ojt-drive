<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\FolderModel; 
use App\Models\FileModel; 

class FileHandler extends BaseController
{
    // --- PRIVATE HELPER: Generate Unique Name ---
    private function getUniqueName($name, $parentId, $type, $deptId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table(($type === 'folder') ? 'folders' : 'files');
        
        $nameCol = ($type === 'folder') ? 'name' : 'filename';
        $parentCol = ($type === 'folder') ? 'parent_id' : 'folder_id';

        // Separate Name and Extension
        $nameWithoutExt = $name;
        $ext = '';

        if ($type === 'file') {
            $info = pathinfo($name);
            $nameWithoutExt = $info['filename'];
            if (isset($info['extension'])) {
                $ext = '.' . $info['extension'];
            }
        }

        $counter = 0;
        
        while (true) {
            // Construct candidate name: "Name" or "Name (1)" or "Name (1).txt"
            $suffix = ($counter === 0) ? '' : " ($counter)";
            $candidateName = $nameWithoutExt . $suffix . $ext;

            // Check Database
            $builder->resetQuery();
            $builder->where($nameCol, $candidateName);
            $builder->where('is_archived', 0); // Only check against active items
            
            if (empty($parentId)) {
                $builder->where("$parentCol IS NULL");
                // For root items, strictly filter by department to prevent cross-dept collision if shared DB
                if(!empty($deptId)) {
                    $builder->where('department_id', $deptId);
                }
            } else {
                $builder->where($parentCol, $parentId);
            }

            if ($builder->countAllResults() === 0) {
                return $candidateName;
            }
            $counter++;
        }
    }

    // --- 1. Create Folder ---
    public function create_folder()
    {
        $session = session();
        helper('log'); 

        if($session->get('role') == 'faculty') { 
            return redirect()->back()->with('error', 'Unauthorized: Faculty cannot create folders.'); 
        }

        $folderModel = new FolderModel();
        $userModel = new UserModel();

        // Get User's Department
        $user = $userModel->find($session->get('id'));
        $deptId = $user['department_id'] ?? null; 

        $parentId = $this->request->getPost('parent_id');
        $parentId = !empty($parentId) ? $parentId : null;
        
        $rawFolderName = $this->request->getPost('folder_name');

        // [UPDATED] Get Unique Folder Name
        $finalFolderName = $this->getUniqueName($rawFolderName, $parentId, 'folder', $deptId);

        $data = [
            'name'          => $finalFolderName,
            'parent_id'     => $parentId,
            'department_id' => $deptId
        ];

        $folderModel->save($data);

        // Logging
        $location = !empty($parentId) ? "Folder ID: $parentId" : "Root Directory";
        save_log('Create Folder', "Created folder '$finalFolderName' in $location");

        return redirect()->back()->with('success', "Folder '$finalFolderName' created successfully");
    }

    // --- 2. Upload Single File ---
    public function upload()
    {
        $session = session();
        helper('log'); 
        
        if($session->get('role') == 'faculty') { 
            return redirect()->back()->with('error', 'Unauthorized: Faculty cannot upload files.'); 
        }

        $input = $this->validate([
            'userfile' => 'uploaded[userfile]|max_size[userfile,10240]|ext_in[userfile,png,jpg,jpeg,pdf,docx,xlsx,pptx,txt]'
        ]);

        if (!$input) {
            return redirect()->back()->with('error', 'Invalid file type or size (Max 10MB).');
        } else {
            $img = $this->request->getFile('userfile');
            
            if($img->isValid() && !$img->hasMoved()){
                $newName = $img->getRandomName(); // Disk name (safe)
                $originalName = $img->getClientName(); // Display name

                $img->move('uploads/', $newName);

                $userModel = new UserModel();
                $currentUser = $userModel->find($session->get('id'));
                $deptId = $currentUser['department_id'] ?? null; 

                $folderId = $this->request->getPost('folder_id');
                $folderId = !empty($folderId) ? $folderId : null;

                // [UPDATED] Get Unique Filename
                $finalDisplayName = $this->getUniqueName($originalName, $folderId, 'file', $deptId);

                $fileModel = new FileModel();
                
                $data = [
                    'user_id'       => $session->get('id'),
                    'department_id' => $deptId, 
                    'filename'      => $finalDisplayName, // Save unique name
                    'file_path'     => $newName,
                    'file_size'     => $img->getSizeByUnit('kb') . ' KB',
                    'folder_id'     => $folderId
                ];
                
                $fileModel->save($data);
                
                // Logging
                $location = !empty($folderId) ? "Folder ID: $folderId" : "Root Directory";
                save_log('Upload', "Uploaded file '$finalDisplayName' to $location");
                
                return redirect()->back()->with('success', "File '$finalDisplayName' uploaded successfully.");
            }
        }
        return redirect()->back()->with('error', 'File upload failed.');
    }

    // --- 3. Upload Folder (Bulk Upload) ---
    public function upload_folder()
    {
        $session = session();
        helper('log'); 

        if($session->get('role') == 'faculty') { 
            return redirect()->back()->with('error', 'Unauthorized: Faculty cannot upload folders.'); 
        }

        $files = $this->request->getFileMultiple('folder_files');
        if (!$files) {
            return redirect()->back()->with('error', 'No files selected.');
        }

        $userModel = new UserModel();
        $currentUser = $userModel->find($session->get('id'));
        $deptId = $currentUser['department_id'] ?? null;
        
        $currentViewFolderId = $this->request->getPost('folder_id');
        $currentViewFolderId = !empty($currentViewFolderId) ? $currentViewFolderId : null;

        $rawFolderName = $this->request->getPost('folder_name');
        $targetFolderId = $currentViewFolderId;
        $finalFolderName = $rawFolderName;

        // [UPDATED] Create Container Folder with Unique Name
        if (!empty($rawFolderName)) {
            $folderModel = new FolderModel();
            
            // Get unique name for the folder itself (e.g. "Docs (1)")
            $finalFolderName = $this->getUniqueName($rawFolderName, $currentViewFolderId, 'folder', $deptId);

            $newFolderData = [
                'name'          => $finalFolderName,
                'parent_id'     => $currentViewFolderId,
                'department_id' => $deptId
            ];
            
            $targetFolderId = $folderModel->insert($newFolderData);
            
            if($targetFolderId) {
                save_log('Create Folder', "Auto-created folder '$finalFolderName' from upload");
            } else {
                $targetFolderId = $currentViewFolderId; // Fallback
            }
        }

        $fileModel = new FileModel();
        $count = 0;
        $allowedExtensions = ['png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'pptx', 'txt'];

        foreach ($files as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                
                $ext = strtolower($file->getExtension());
                
                if(in_array($ext, $allowedExtensions)) {
                    $newName = $file->getRandomName();
                    $originalName = $file->getClientName();
                    
                    $file->move('uploads/', $newName);

                    // [UPDATED] Ensure Unique Filename inside the new folder
                    // This handles renaming "A.txt" to "A (1).txt" if duplicate exists in the list
                    $finalFileName = $this->getUniqueName($originalName, $targetFolderId, 'file', $deptId);

                    $data = [
                        'user_id'       => $session->get('id'),
                        'department_id' => $deptId,
                        'filename'      => $finalFileName,
                        'file_path'     => $newName,
                        'file_size'     => $file->getSizeByUnit('kb') . ' KB',
                        'folder_id'     => $targetFolderId
                    ];
                    
                    $fileModel->save($data);
                    $count++;
                }
            }
        }

        if ($count > 0) {
            return redirect()->back()->with('success', "Uploaded $count files into '$finalFolderName'.");
        } else {
            return redirect()->back()->with('error', 'No valid files found.');
        }
    }

    // --- 4. ARCHIVE FOLDER ---
    public function delete_folder($id)
    {
        $session = session();
        helper('log'); 

        if($session->get('role') == 'faculty') { 
            return redirect()->back()->with('error', 'Unauthorized'); 
        }

        $folderModel = new FolderModel();
        $folder = $folderModel->find($id);
        $folderName = $folder['name'] ?? 'Unknown Folder';

        $folderModel->update($id, ['is_archived' => 1]);

        save_log('Archive', "Archived folder '$folderName' (ID: $id)");

        return redirect()->back()->with('success', 'Folder moved to archive.');
    }

    // --- 5. ARCHIVE FILE ---
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