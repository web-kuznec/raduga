<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Admin_Module extends Model
{
    protected $_table = 'modules';
    
    public function get_modules()
    {
        return DB::select()
                ->from('modules')
                ->as_object()
                ->execute();
    }
    
    public function get_linkrole()
    {
        return DB::select('modules_roles.module_id', 'modules_roles.role_id', 'roles.name', 'roles.tag')
                ->from('modules_roles')
                ->join('roles')
                ->on('modules_roles.role_id', '=', 'roles.id')
                ->as_object()
                ->execute();
    }
    
    public function get_roles()
    {
        return DB::select()
                ->from('roles')
                ->where('tag', '!=', 'admin')
                ->execute()
                ->as_array();
    }
    
    public function get_modules_by_role($id)
    {
        return DB::select($this->_table.'.id', $this->_table.'.tag', $this->_table.'.name', $this->_table.'.description', $this->_table.'.gruppa')
                    ->from('modules_roles')
                    ->join($this->_table)
                    ->on('modules_roles.module_id', '=', $this->_table.'.id')
                    ->where('modules_roles.role_id', '=', $id)
                    ->as_object()
                    ->execute();
    }
    
}