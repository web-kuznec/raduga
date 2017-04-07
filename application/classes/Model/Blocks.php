<?php defined('SYSPATH') or die('No direct script access.');

class Model_Blocks extends Model
{
    protected $_table = 'blocks';
    
    public function get_blocks()
    {
        return DB::select()
                ->from($this->_table)
                ->order_by('sort')
                ->as_object()
                ->execute();
    }
    
    public function get_info($block, $type)
    {
        return DB::select()
                ->from($type)
                ->where('blocks_id','=',$block)
                ->as_object()
                ->execute();
    }
}