<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Admin_Role extends Model
{
    protected $_table = 'roles';
    
    public function get_role_by_user($id)
    {
        return DB::select($this->_table.'.id', $this->_table.'.tag', $this->_table.'.name')
                    ->from($this->_table)
                    ->join('users_roles')
                    ->on($this->_table.'.id', '=', 'users_roles.role_id')
                    ->where('users_roles.user_id', '=', $id)
                    ->as_object()
                    ->execute();
    }
}