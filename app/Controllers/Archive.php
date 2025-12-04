<?php namespace App\Controllers;

use App\Models\FileModel;
use App\Models\FolderModel;

class Archive extends BaseController
{
    public function index()
    {
        if(session()->get('role') !== 'admin') return redirect()->back();
        
        $fileModel = new FileModel();
        $folderModel = new FolderModel();

        // Fetch only archived items
        $data['files'] = $fileModel->where('is_archived', 1)->findAll();
        $data['folders'] = $folderModel->where('is_archived', 1)->findAll();

        return view('archive_view', $data);
    }

    public function restore($type, $id)
    {
        if(session()->get('role') !== 'admin') return redirect()->back();
        helper('log');

        if ($type === 'file') {
            $model = new FileModel();
            $model->update($id, ['is_archived' => 0]);
            save_log('Restore', "Restored file ID: $id from archive");
        } elseif ($type === 'folder') {
            $model = new FolderModel();
            $model->update($id, ['is_archived' => 0]);
            save_log('Restore', "Restored folder ID: $id from archive");
        }

        return redirect()->back()->with('success', ucfirst($type) . ' restored successfully.');
    }

    public function delete_permanent($type, $id)
    {
        if(session()->get('role') !== 'admin') return redirect()->back();
        helper('log');

        if ($type === 'file') {
            $model = new FileModel();
            $file = $model->find($id);
            if ($file) {
                $model->delete($id, true); // true = purge
                if(file_exists('uploads/' . $file['file_path'])) {
                    unlink('uploads/' . $file['file_path']);
                }
                save_log('Permanent Delete', "Permanently deleted file: " . $file['filename']);
            }
        } elseif ($type === 'folder') {
            $model = new FolderModel();
            $folder = $model->find($id);
            $model->delete($id, true);
            save_log('Permanent Delete', "Permanently deleted folder: " . ($folder['name'] ?? 'Unknown'));
        }

        return redirect()->back()->with('success', ucfirst($type) . ' permanently deleted.');
    }
}