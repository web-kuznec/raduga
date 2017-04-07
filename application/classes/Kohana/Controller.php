<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Abstract controller class. Controllers should only be created using a [Request].
 *
 * Controllers methods will be automatically called in the following order by
 * the request:
 *
 *     $controller = new Controller_Foo($request);
 *     $controller->before();
 *     $controller->action_bar();
 *     $controller->after();
 *
 * The controller action should add the output it creates to
 * `$this->response->body($output)`, typically in the form of a [View], during the
 * "action" part of execution.
 *
 * @package    Kohana
 * @category   Controller
 * @author     Kohana Team
 * @copyright  (c) 2008-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
abstract class Kohana_Controller {

    public $_initial = FALSE;
    public $_role = FALSE;
    public $_role_name = FALSE;
    public $_role_tag = FALSE;
    public $_user = FALSE;
    public $_user_login = FALSE;
    public $_modules = FALSE;
    
    /**
     * @var  Request  Request that created the controller
     */
    public $request;

    /**
     * @var  Response The response that will be returned from controller
     */
    public $response;

    /**
     * Creates a new controller instance. Each controller must be constructed
     * with the request object that created it.
     *
     * @param   Request   $request  Request that created the controller
     * @param   Response  $response The request's response
     * @return  void
     */
    public function __construct(Request $request, Response $response)
    {
            // Assign the request to the controller
            $this->request = $request;

            // Assign a response to the controller
            $this->response = $response;
    }

    /**
     * Executes the given action and calls the [Controller::before] and [Controller::after] methods.
     * 
     * Can also be used to catch exceptions from actions in a single place.
     * 
     * 1. Before the controller action is called, the [Controller::before] method
     * will be called.
     * 2. Next the controller action will be called.
     * 3. After the controller action is called, the [Controller::after] method
     * will be called.
     * 
     * @throws  HTTP_Exception_404
     * @return  Response
     */
    public function execute()
    {
            // Execute the "before action" method
            $this->before();

            // Determine the action to use
            $action = 'action_'.$this->request->action();

            // If the action doesn't exist, it's a 404
            if ( ! method_exists($this, $action))
            {
                    throw HTTP_Exception::factory(404,
                            'The requested URL :uri was not found on this server.',
                            array(':uri' => $this->request->uri())
                    )->request($this->request);
            }

            // Execute the action itself
            $this->{$action}();

            // Execute the "after action" method
            $this->after();

            // Return the response
            return $this->response;
    }

    /**
     * Automatically executed before the controller action. Can be used to set
     * class properties, do authorization checks, and execute other custom code.
     *
     * @return  void
     */
    public function before()
    {
        $this->user_detect();
        // Nothing by default
    }

    /**
     * Automatically executed after the controller action. Can be used to apply
     * transformation to the response, add extra output, and execute
     * other custom code.
     * 
     * @return  void
     */
    public function after()
    {
            // Nothing by default
    }

    /**
     * Issues a HTTP redirect.
     *
     * Proxies to the [HTTP::redirect] method.
     *
     * @param  string  $uri   URI to redirect to
     * @param  int     $code  HTTP Status code to use for the redirect
     * @throws HTTP_Exception
     */
    public static function redirect($uri = '', $code = 302)
    {
            return HTTP::redirect($uri, $code);
    }

    /**
     * Checks the browser cache to see the response needs to be returned,
     * execution will halt and a 304 Not Modified will be sent if the
     * browser cache is up to date.
     * 
     *     $this->check_cache(sha1($content));
     * 
     * @param  string  $etag  Resource Etag
     * @return Response
     */
    protected function check_cache($etag = NULL)
    {
        return HTTP::check_cache($this->request, $this->response, $etag);
    }
    
    public function action_checkauth()
    {
        if(!session_id())
            @session_start();
        if(isset($_SESSION['unic']))
            return TRUE;
        else
            return FALSE;
    }
    
    public function user_detect()
    {
        if($this->action_checkauth())
        {
            $this->security();
        }
    }
    
    public function security()
    {
        if(isset($_SESSION['unic']))
        {
            $unic = $_SESSION['unic'];
            $this->detect_role($unic);
            $this->detect_dosie($unic);
            $this->detect_modules();
        }
    }
    
    public function detect_role($i)
    {
        $role = Model::factory("Admin_Role")->get_role_by_user($i);
        foreach($role as $k)
        {
            $this->_role = $k->id;
            $this->_role_tag = $k->tag;
            $this->_role_name = $k->name;
        }
    }
    
    public function detect_dosie($i)
    {
        $dosie = Model::factory("Admin_User")->get_user($i);
        foreach($dosie as $d)
        {
            $this->_user = $d->id;
            $this->_user_login = $d->nick;
        }
    }
    
    public function detect_modules()
    {
        $mod = array();
        $modules = Model::factory("Admin_Module")->get_modules_by_role($this->_role);
        foreach($modules as $k)
        {
            $mod[$k->id] = array('tag' => $k->tag, 'name' => $k->name, 'descr' => $k->description, 'gruppa' => $k->gruppa );
        }
        $this->_modules = $mod;
    }

} // End Controller