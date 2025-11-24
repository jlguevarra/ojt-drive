<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\FileModel; 

class FileHandler extends BaseController
{
    public function upload()
    {
        $session = session();
        
        // 1. Validation
        $input = $this->validate([
            'userfile' => 'uploaded[userfile]|max_size[userfile,2048]|ext_in[userfile,png,jpg,pdf,docx,xlsx]'
        ]);

        if (!$input) {
            // Validation failed
            return redirect()->back()->with('error', 'Invalid file or file too large.');
        } else {
            // 2. Handle File Upload
            $img = $this->request->getFile('userfile');
            
            if($img->isValid() && !$img->hasMoved()){
                // Generate a random name to prevent overwrite
                $newName = $img->getRandomName(); 
                $originalName = $img->getClientName();
                
                // Move to public/uploads
                $img->move('uploads/', $newName);

                // 3. Save to Database
                $db = \Config\Database::connect();
                $builder = $db->table('files');
                
                $data = [
                    'user_id'   => $session->get('id'), // Who uploaded it?
                    'filename'  => $originalName,      // Display name
                    'file_path' => $newName,           // System name
                    'file_size' => $img->getSizeByUnit('kb') . ' KB'
                ];
                
                $builder->insert($data);

                return redirect()->back()->with('success', 'File uploaded successfully!');
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