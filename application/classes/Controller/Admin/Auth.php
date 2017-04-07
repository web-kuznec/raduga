<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Auth extends Controller_Admin_Common
{    
    public $_access = FALSE;
    
    public function before()
    {
        parent::before();
        $contr = strtolower($this->request->controller());
        if(!empty($this->_modules))
        {
            foreach($this->_modules as $k => $v)
            {
                if($v == $contr)
                {
                    $this->_access = TRUE;
                    break;
                }
            }
        }
        if($this->_access === FALSE && $this->_user !== FALSE)
            HTTP::redirect(URL::base()."admin/stop/");
        else
            HTTP::redirect(URL::base()."admin/admin/noauth/");
    }
} //End Controller_Admin_Security