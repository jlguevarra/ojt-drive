<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\FileModel; 

class FileHandler extends BaseController
{
    public function upload()
    {
        $session = session();
        
        $input = $this->validate([
            'userfile' => 'uploaded[userfile]|max_size[userfile,10240]|ext_in[userfile,png,jpg,jpeg,pdf,docx,xlsx,pptx,txt]',
            'folder'   => 'required'
        ]);

        if (!$input) {
            return redirect()->back()->with('error', 'Invalid file or folder.');
        } else {
            $img = $this->request->getFile('userfile');
            
            if($img->isValid() && !$img->hasMoved()){
                $newName = $img->getRandomName(); 
                $originalName = $img->getClientName();
                $img->move('uploads/', $newName);

                // 1. Get Current User's Department
                $userModel = new UserModel();
                $currentUser = $userModel->find($session->get('id'));
                $deptId = $currentUser['department_id']; // This might be null if Admin

                $db = \Config\Database::connect();
                $builder = $db->table('files');
                
                $data = [
                    'user_id'       => $session->get('id'),
                    'department_id' => $deptId, // <--- CRITICAL: Tag the file to the department
                    'filename'      => $originalName,
                    'file_path'     => $newName,
                    'file_size'     => $img->getSizeByUnit('kb') . ' KB',
                    'folder'        => $this->request->getPost('folder')
                ];
                
                $builder->insert($data);

                return redirect()->back()->with('success', 'File uploaded successfully.');
            }
        }
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
        // Only Admin/Chair can delete (Check role)
        if(session()->get('role') == 'faculty') {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('files');
        
        // Get file path to delete from server
        $file = $builder->where('id', $id)->get()->getRow();
        
        if($file){
            // Delete record from DB
            $builder->where('id', $id)->delete();
            // Delete actual file from folder
            if(file_exists('uploads/' . $file->file_path)){
                unlink('uploads/' . $file->file_path);
            }
            return redirect()->back()->with('success', 'File deleted.');
        }
    }
}