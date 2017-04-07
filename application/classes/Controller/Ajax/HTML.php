<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax_HTML extends Controller
{
    public $_error = array();
    // Результат запроса
    protected $_result = array();
    public $_access = FALSE;
    
    public function before()
    {
        parent::before();
        
        if(Request::initial()->is_ajax())
        {
            $this->response->headers(array(
                'Content-Type'  => 'text/html',
                'Pragma'        => 'no-cache', 
                'Cache-Control' => 'no-store, no-cache, must-revalidate',
            ));
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
        }
        else
            $this->_error['code'] = 'Request is not AJAX';
    }
}