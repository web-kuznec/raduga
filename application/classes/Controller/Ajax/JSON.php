<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax_JSON extends Controller
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
                'Content-Type'  => 'text/json',
                'Pragma'        => 'no-cache', 
                'Cache-Control' => 'no-store, no-cache, must-revalidate',
            ));
        }
        else
            $this->_error['code'] = 'Request is not AJAX';
    }
}