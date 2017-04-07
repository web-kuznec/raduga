<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Admin_Auth extends ORM
{
    
    protected $_table = 'users';
 
    public function get_auth($login)
    {
        $query = DB::select('id', 'username', 'password', 'salt')
		->from($this->_table)
                ->where('username', '=', $login)
                ->as_object()
                ->execute();
        return $query;
    }
    
    public function set_reg($mass)
    {
        $query = DB::insert('users', array('username', 'password', 'salt', 'email'))
            ->values($mass);
        $query = $query->execute();
    }
    
    public function set_role($user)
    {
        $query = DB::select('FK_role')
                ->from('user_role')
                ->where('FK_user', '=', $user)
                ->as_object()
                ->execute();
        return $query;
    }
    
    public function get_role($user)
    {
        $query = DB::select('FK_role')
                ->from('user_role')
                ->where('FK_user', '=', $user)
                ->limit('1')
                ->as_object()
                ->execute();
        return $query;
    }
}