<?php defined('SYSPATH') or die('No direct script access.');
 
abstract class Controller_Common extends Controller_Template {
 
    public $template = 'main';
    public function before()
    {
        parent::before();
        if(!session_id())
            @session_start();
        
        $settings = Model::factory('Admin_Settings')->get_all();
        $this->template->color = $settings[0]->color;
        $this->template->title = '';
        $this->template->keywords = '';
        $this->template->description = '';
    }
 
} // End Common