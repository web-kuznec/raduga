<?php defined('SYSPATH') OR die('No direct script access.');

class HTTP_Exception extends Kohana_HTTP_Exception {
 
    /**
     * Generate a Response for all Exceptions without a more specific override
     * 
     * The user should see a nice error page, however, if we are in development
     * mode we should show the normal Kohana error page.
     * 
     * @return Response
     */
    public function get_response()
    {
        // Lets log the Exception, Just in case it's important!
        Kohana_Exception::log($this);
 
        if (Kohana::$environment >= Kohana::DEVELOPMENT)
        {
            // Show the normal Kohana error page.
            return parent::get_response();
        }
        else
        {
            // Generate a nicer looking "Oops" page.
            $view = View::factory('errors/default')
                    ->set('code', $this->getCode());
 
            $response = Response::factory()
                ->status($this->getCode())
                ->headers(array(
                    'Content-Type'  => 'text/html',
                    'Pragma'        => 'no-cache', 
                    'Cache-Control' => 'no-store, no-cache, must-revalidate',
                ))
                ->body($view->render());
 
            return $response;
        }
    }
}