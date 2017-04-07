<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Admin extends Controller_Admin_Common
{    
    public function action_index()
    {
        if($this->_user === FALSE)
        {
            $this->template->set_filename('login');
            $this->template->name = "Авторизация";
            $this->template->content = $this->noauth();
        }
        else
        {
            $this->template->name = "Панель управления";
            $this->template->content = $this->info();
        }
    }
    
    public function action_noauth()
    {
        $this->template->content = View::factory('auth/auth');
    }
    
    public function action_stop()
    {
        $this->template->content = View::factory('auth/not_access');
    }
    
    /**
     * Функция активации аккаунта
     */
    public function action_confirm()
    {
        if(isset($_GET['confirm']))
        {
            $confirm = $_GET['confirm'];
            $user = Model::factory('User')->confirm($confirm);
            if($user !== FALSE)
            {
                Model::factory('User')->user_role($user['id']);
                if(!session_id())
                    @session_start();
                $_SESSION['unic'] = $user['id'];
                $this->user_detect();
                $_SESSION['role'] = $this->_role;
                HTTP::redirect(URL::base('http', TRUE));
            }
        }
    }
    
    /**
     * Функция восстановления пароля
     */
    public function action_reset()
    {
        if(isset($_GET['reset']))
        {
            $reset = $_GET['reset'];
            $user = Model::factory('User')->reset($reset);
            if($user !== FALSE)
            {
                $this->template->content = View::factory('auth/reset')
                                                    ->set('user', $user['id']);
            }
            else
                $this->template->content = View::factory('auth/dont_reset');
        }
    }
    
} //End Controller_Admin_Admin