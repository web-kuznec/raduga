<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Admin_Settings extends Model
{
    protected $_table = "settings";
    
    public function get_all()
    {
        return DB::select()
                    ->from($this->_table)
                    ->where('id','=',1)
                    ->as_object()
                    ->execute();
    }
    
    public function set_setting($id, $color, $count)
    {
        DB::update($this->_table)
                ->set(array('color' => $color, 'count' => $count))
                ->where('id', '=', $id)
                ->execute();
    }
}