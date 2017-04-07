<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Admin_Blocks extends Model
{
    public function get_logos()
    {
        return DB::select()
                    ->from('logo')
                    ->as_object()
                    ->execute();
    }
    
    public function add_logo($photo)
    {
        DB::insert('logo', array('name', 'blocks_id'))
                ->values(array($photo, '1'))
                ->execute();
    }
    
    public function dell_logos()
    {
        DB::delete('logo')
                ->execute();
    }
    
    public function get_headers()
    {
        return DB::select()
                    ->from('headers')
                    ->as_object()
                    ->execute();
    }
    
    public function update_header($id, $name)
    {
        DB::update('headers')
                ->set(array('name' => $name))
                ->where('id', '=', $id)
                ->execute();
    }
    
    public function insert_header($name)
    {
        DB::insert('headers', array('name', 'blocks_id'))
                ->values(array($name, '2'))
                ->execute();
    }
    
    public function get_text()
    {
        return DB::select()
                    ->from('text')
                    ->as_object()
                    ->execute();
    }
    
    public function update_text($id, $text)
    {
        DB::update('text')
                ->set(array('text' => $text))
                ->where('id', '=', $id)
                ->execute();
    }
    
    public function insert_text($text)
    {
        DB::insert('text', array('text', 'blocks_id'))
                ->values(array($text, '3'))
                ->execute();
    }
    
    public function get_banners()
    {
        return DB::select()
                ->from('banners')
                ->as_object()
                ->execute();
    }
    
    public function update_href($id, $href)
    {
        DB::update('banners')
                ->set(array('href' => $href))
                ->where('id', '=', $id)
                ->execute();
    }
    
    public function update_ban($id, $name)
    {
        DB::update('banners')
                ->set(array('img' => $name))
                ->where('id', '=', $id)
                ->execute();
    }
    
    public function get_ban($id)
    {
        return DB::select()
                ->from('banners')
                ->where('id', '=', $id)
                ->as_object()
                ->execute();
    }
    
    public function insert_href($href)
    {
        $query =  DB::insert('banners', array('href', 'blocks_id'))
                ->values(array($href, '4'))
                ->execute();
        return $query[0];
    }
    
    public function dell_banners($id)
    {
        DB::delete('banners')
                ->where('id', '=', $id)
                ->execute();
    }
    
    public function get_all()
    {
        return DB::select()
                ->from('blocks')
                ->order_by('sort')
                ->as_object()
                ->execute();
    }
    
    public function save_sort($id, $sort)
    {
        DB::update('blocks')
                ->set(array('sort' => $sort))
                ->where('id', '=', $id)
                ->execute();
    }
}