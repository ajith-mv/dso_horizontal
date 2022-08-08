<?php
namespace App\Helpers;
use App\Models\LogSheet;

class LogActivity   {
    public static function log($id)    {
        switch (request()->route()->getActionMethod()) {
            case 'batch_destroy':
                $action_type  = 'DELETE';
                $module_name  = 'Batches' ;
            break;
            case 'destroy':
                $action_type  = 'DELETE';
                $module_name  = 'Material Products' ;
            break;
            case 'duplicate_batch':
                $action_type  = 'DUPLICATE';
                $module_name  = 'Batches' ;
            break;
            case 'save_search_history':
                $action_type  = 'CREATE';
                $module_name  = 'Search History' ;
            break;
            case 'delete_search_history':
                $action_type  = 'DELETE';
                $module_name  = 'Search History' ;
            break;
            case 'import_excel':
                $action_type  = 'IMPORT';
                $module_name  = 'Material Products' ;
            break;
            case 'storeWizardForm':
                switch (request()->route()->getName()) {
                    case 'create.material-product':
                        $action_type  = 'CREATE';
                        $module_name  = 'Material Products' ;
                    break;
                    case 'edit_or_duplicate.material-product':
                        $action_type  = 'UPDATE';
                        $module_name  = 'Material Products' ;
                    break;
                } 
            break; 
        } 
        
    	LogSheet::updateOrCreate([
            'ip'          => request()->ip(),
            'agent'       => request()->header('user-agent'),
            'user_id'     => auth_user()->id,
            'user_name'   => auth_user()->alias_name,
            'module_name' => $module_name,
            'action_type' => $action_type ?? "",
            "module_id"   => $id
        ]);
    }

    public static function all()   {
    	return LogSheet::latest()->get();
    }
}