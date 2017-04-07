<?php defined('SYSPATH') or die('No direct script access.');
 
abstract class Controller_Admin_Common extends Controller_Template
{ 
    public $template = 'admin/main';
    public $count_banners = 2;
    
    public function before()
    {
        parent::before();
        $this->security();
        $this->template->tag = '';
        $name = $this->name_module($this->request->controller());
        if($name !== FALSE)
        {
            $this->template->name = $name['name'];
            $this->template->tag = $name['tag'];
        }
        $settings = Model::factory('Admin_Settings')->get_all();
        $this->count_banners = $settings[0]->count;
        $this->template->nick = $this->_user_login;
        $this->template->styles = View::factory('admin/styles/styles');
        $this->template->scripts = View::factory('admin/scripts/scripts');
        $this->template->scripts_bottom = View::factory('admin/scripts/scripts_bottom');
    }
    
    /**
     * Метод выводит окно авторизации
     * @return type
     */
    public function noauth()
    {
        $html = View::factory('auth/auth');
        return View::factory('auth/oblojka')->set('html', $html);
    }
    
    public function info()
    {
        return View::factory('admin/info');
    }
    
    public function admin()
    {
        //$modules = $this->action_getmodules();
    }
    
    public function menu()
    {
        if(count($this->_modules) > 0)
        {
            $html = View::factory('admin/menu')
                    ->set('menu', $this->_modules);
            return $html;
        }
        else
            return FALSE;
    }
    
    public function name_module($controller)
    {
        return Model::factory('Admin_Modaccess')->get_name(strtolower($controller));
    }
    
} //End Controller_Admin_Common