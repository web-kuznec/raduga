<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Stop extends Controller_Admin_Common
{    
    public function action_index()
    {
        $this->template->name = "Доступ запрещен";
        $this->template->content = "Вы не имеете прав доступа к этому модулю.";
    }

} //End Controller_Admin_Stop