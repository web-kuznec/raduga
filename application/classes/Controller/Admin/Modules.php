<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Modules extends Controller_Admin_Common {
    
    public function action_index()
    {
        $modules = Model::factory('Module')->get_modules();
        $link_role = Model::factory('Module')->get_linkrole();
        $groups = Model::factory('Module')->get_roles();
        $html = View::factory('admin/modules/modules')
                    ->set('modules', $modules)
                    ->set('link_role', $link_role)
                    ->set('groups', $groups);
        $this->template->content = $html;
        $this->template->action = View::factory('admin/modules/action');
        $name = $this->name_module($this->request->controller());
        if($name !== FALSE)
            $this->template->name = $name['name'];
    }
    
} //End Controller_Admin_Modules