<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Settings extends Controller_Admin_Common {
    
    private $_config = NULL;
    
    public function before()
    {
        parent::before();
        if($this->_user === FALSE) // юзер не авторизован
        {
            $this->template->set_filename('login');
            $this->template->name = "Авторизация";
            $this->template->content = $this->noauth();
        }
    }
    
    /**
     * Метод вывода настроек
     */
    public function action_index()
    {
        if($this->request->post())
            $this->edit();
        $settings = Model::factory('Admin_Settings')->get_all();
        $html = View::factory('admin/settigs/edit')
                ->set('settings', $settings);
        $this->template->content = $html;
    }
    
    private function edit()
    {
        $id = $this->request->post('id');
        $color = $this->request->post('color');
        $count = $this->request->post('count');
        Model::factory('Admin_Settings')->set_setting($id, $color, $count);
        HTTP::redirect('/admin/settings');
    }
}