<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Security extends Controller_Admin_Common
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
                if($v['tag'] == $contr)
                {
                    $this->_access = TRUE;
                    break;
                }
            }
        }
        if($this->_user === FALSE)
            HTTP::redirect(URL::base()."admin/");
        elseif($this->_access === FALSE)
            HTTP::redirect(URL::base()."admin/admin/stop/");
    }
} //End Controller_Admin_Security