<?php 

use App\Models\LogModel;

if (! function_exists('save_log')) {
    function save_log($action, $details = '') {
        $session = session();
        $model = new LogModel();
        
        // Safety check: only log if user is logged in
        if($session->get('id')) {
            $model->save([
                'user_id'   => $session->get('id'),
                'user_name' => $session->get('username'),
                'role'      => $session->get('role'),
                'action'    => $action,
                'details'   => $details
            ]);
        }
    }
}