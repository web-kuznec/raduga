<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Groupus extends Controller_Admin_Common {
    
    public function action_index()
    {
        $groups = Model::factory('Admin_Users')->get_groups();
        $name = $this->name_module($this->request->controller());
        $this->template->action = View::factory('admin/groupus/action');
        if($name !== FALSE)
            $this->template->name = $name['name'];
        $html = View::factory('admin/groupus/all')
                ->set('groups', $groups);
        $this->template->content = $html;
    }
}