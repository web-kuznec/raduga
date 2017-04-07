<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Admin_Admin extends Model
{
    public function get_modules($role)
    {
        $query = DB::select('modules.id', 'modules.tag', 'modules.name')
                ->from('modules')
                ->join('link_mod_role')
                ->on('modules.id', '=', 'modulelinkroles.FK_module')
                ->where('modulelinkroles.FK_role', '=', $role)
                ->and_where('modules.admin', '=', '1');
        return $query;
    }
    
    public function get_menu($role)
    {
        return DB::select('modules.*')
                    ->from('modules')
                    ->join('modulelinkroles')
                    ->on('modules.id', '=', 'modulelinkroles.module_id')
                    ->where('modulelinkroles.role_id', '=', $role)
                    ->order_by('modules.gruppa', 'ASC')
                    ->order_by('modules.sort', 'ASC')
                    ->as_object()
                    ->execute();
    }
    
    public function security($id)
    {
        $query = DB::select('users_roles.role_id', 'roles.tag', 'roles.name')
                ->from('users_roles')
                ->join('roles')
                ->on('users_roles.role_id', '=', 'roles.id')
                ->where('users_roles.user_id', '=', $id)
                ->limit('1')
                ->execute()
                ->as_array();
        if(count($query) == 1)
            return $query[0];
        else
            return FALSE;
    }
}