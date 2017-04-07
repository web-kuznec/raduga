<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Common {

    public $template = 'main';
    
    public function action_index()
    {
        $blocks = Model::factory('Blocks')->get_blocks();
        $html = "";
        foreach($blocks as $k => $v)
        {
            $html .= View::factory('blocks/'.$v->types)
                    ->set('info', Model::factory('Blocks')->get_info($v->id, $v->types));
        }
        $this->template->content = $html;
    }

} // End Welcome