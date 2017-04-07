<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Slides extends Controller_Admin_Common {
    
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
        $this->_config = array('max_width_img' => 1000, 'max_height_img' => 800,
            'min_width_img' => 300, 'min_height_img' => 400);
    }
    
    /**
     * Метод редактирования слайда №1
     */
    public function action_1()
    {
        $this->slide_rule();
    }
    
    /**
     * Услуги
     */
    public function action_2()
    {
        $services = Model::factory('Admin_Slides')->all_services();
        $html = View::factory('admin/services/all')
                ->set('services', $services)
                ->set('action', $this->request->action());
        $this->template->content = $html;
    }
    
    /**
     * Метод добавления услуги
     */
    public function action_addservice()
    {
        if($this->request->post())
            $this->add_services();
        $html = View::factory('admin/services/add');
        $this->template->content = $html;
    }
    
    /**
     * Метод редактирования услуги
     */
    public function action_editservice()
    {
        $id = $this->request->param('id');
        if($this->request->post())
            $this->edit_services();
        $service = Model::factory('Admin_Slides')->get_service($id);
        $html = View::factory('admin/services/edit')
                ->set('service', $service);
        $this->template->content = $html;
    }
    
    /**
     * Фотогалерея
     */
    public function action_3()
    {
        if(!empty($_FILES['images']['tmp_name'][0]))
            $this->load_img();
        $photos = Model::factory('Admin_Slides')->get_photos();
        $html = View::factory('admin/gallery/all')
                ->set('photos', $photos);
        $this->template->content = $html;
    }
    
    private function load_img()
    {
        foreach ($_FILES['images']['name'] as $k => $v)
        {
            $dir = PUBPATH.'gallery/big/';
            $new_photo = date('ymdHis_').$k;
            if(!is_dir($dir))
                mkdir($dir, 0777);
            $img = getimagesize($_FILES['images']['tmp_name'][$k]);
            $ext = '.' . str_replace('image/', '', $img['mime']);
            $f = $dir.'/'.$new_photo.$ext;
            if(move_uploaded_file($_FILES['images']['tmp_name'][$k], $f))
            {
                Controller_Static_Images::imageresize($f,$f,$this->_config['max_width_img'],$this->_config['max_height_img'],100);
                $img_type = image_type_to_mime_type($img[2]);
                if($img_type == "image/jpeg")
                    shell_exec("jpegoptim --strip-all " .$f);
                elseif($img_type == "image/png")
                    shell_exec("optipng " . $f);
                Model::factory('Admin_Slides')->add_photo(1, $new_photo, $ext);
            }
            //Уменшеная копия
            $dir2 = PUBPATH.'gallery/min/';
            if(!is_dir($dir2))
                mkdir($dir2, 0777);
            $f2 = $dir2.'/'.$new_photo.$ext;
            Controller_Static_Images::imageresize($f2,$f,$this->_config['min_width_img'],$this->_config['min_height_img'],100);
            $img_type = image_type_to_mime_type($img[2]);
            if($img_type == "image/jpeg")
                shell_exec("jpegoptim --strip-all " .$f2);
            elseif($img_type == "image/png")
                shell_exec("optipng " . $f2);
        }
    }
    
    /**
     * Варианты размещения
     */
    public function action_4()
    {
        $variables = Model::factory('Admin_Slides')->all_variables();
        $html = View::factory('admin/variables/all')
                ->set('variables', $variables)
                ->set('m', $variables)
                ->set('action', $this->request->action());
        $this->template->content = $html;
    }
    
    public function action_add()
    {
        $id = $this->request->param('id');
        if($this->request->post())
            $this->add_variables();
        
        $html = View::factory('admin/variables/add')
                ->set('id', $id);
        $this->template->content = $html;
    }
    
    public function add_variables()
    {
        $id = $_POST['id'];
        $text = $_POST['text'];
        Model::factory('Admin_Slides')->addvariables($id, $text);
        HTTP::redirect('/admin/slides/4');
    }
    
    public function action_edit()
    {
        if($this->request->post())
            $this->edit_variables();
        
        $id = $this->request->param('id');
        if($id)
        {
            $variables = Model::factory('Admin_Slides')->get_variables($id);
            $html = View::factory('admin/variables/edit')
                    ->set('variables', $variables)
                    ->set('action', $this->request->action());
            $this->template->content = $html;
        }
    }
    
    public function action_dell()
    {
        $id = $this->request->param('id');
        if($id)
            Model::factory('Admin_Slides')->dell_variable($id);
    }
    
    public function edit_variables()
    {
        $id = $_POST['id'];
        $text = $_POST['text'];
        Model::factory('Admin_Slides')->save_variables($id, $text);
        HTTP::redirect('/admin/slides/4');
    }
    
    /**
     * Метод добавления услуги
     */
    public function add_services()
    {
        $awesome = $_POST['awesome'];
        $h = $_POST['h'];
        $p = $_POST['p'];
        Model::factory('Admin_Slides')->save_services($awesome, $h, $p);
    }
    
    /**
     * Метод редактирования услуги
     */
    public function edit_services()
    {
        $id = $_POST['id'];
        $awesome = $_POST['awesome'];
        $h = $_POST['h'];
        $p = $_POST['p'];
        Model::factory('Admin_Slides')->edit_services($id, $awesome, $h, $p);
        HTTP::redirect('/admin/slides/2');
    }
    
    public function action_dellservice()
    {
        $id = $this->request->param('id');
        if($id)
            Model::factory('Admin_Slides')->dell_services($id);
    }
    
    /**
     * Документы
     */
    public function action_5()
    {
        $docs = Model::factory('Admin_Slides')->all_docs(1);
        $html = View::factory('admin/docs/all')
                ->set('docs', $docs)
                ->set('action', $this->request->action());
        $this->template->content = $html;
    }
    
    public function action_adddocs()
    {
        if($this->request->post())
            $this->add_docs();
        $html = View::factory('admin/docs/add');
        $this->template->content = $html;
    }
    
    public function add_docs()
    {
        $awesome = $_POST['awesome'];
        $p = $_POST['p'];
        Model::factory('Admin_Slides')->add_docs($awesome, $p, 1);
        HTTP::redirect('/admin/slides/5');
    }
    
    public function action_editdocs()
    {
        $id = $this->request->param('id');
        if($id)
        {
            if($this->request->post())
            {
                $this->edit_docs();
                HTTP::redirect('/admin/slides/5');
            }
            $docs = Model::factory('Admin_Slides')->get_docs($id);
            $html = View::factory('admin/docs/edit')
                    ->set('docs', $docs);
            $this->template->content = $html;
        }
    }
    
    /**
     * Необходимые вещи
     */
    public function action_6()
    {
        $docs = Model::factory('Admin_Slides')->all_docs(2);
        $html = View::factory('admin/dress/all')
                ->set('docs', $docs)
                ->set('action', $this->request->action());
        $this->template->content = $html;
    }
    
    public function action_adddress()
    {
        if($this->request->post())
            $this->add_dress();
        $html = View::factory('admin/dress/add');
        $this->template->content = $html;
    }
    
    public function add_dress()
    {
        $awesome = $_POST['awesome'];
        $p = $_POST['p'];
        Model::factory('Admin_Slides')->add_docs($awesome, $p, 2);
        HTTP::redirect('/admin/slides/6');
    }
    
    public function action_editdress()
    {
        $id = $this->request->param('id');
        if($id)
        {
            if($this->request->post())
            {
                $this->edit_docs();
                HTTP::redirect('/admin/slides/6');
            }
            $docs = Model::factory('Admin_Slides')->get_docs($id);
            $html = View::factory('admin/dress/edit')
                    ->set('docs', $docs);
            $this->template->content = $html;
        }
    }
    
    public function edit_docs()
    {
        $id = $_POST['id'];
        $awesome = $_POST['awesome'];
        $p = $_POST['p'];
        Model::factory('Admin_Slides')->save_docs($id, $awesome, $p);
    }
    
    /**
     * Противопоказания
     */
    public function action_7()
    {
        $docs = Model::factory('Admin_Slides')->all_docs(3);
        $html = View::factory('admin/stop/all')
                ->set('docs', $docs)
                ->set('action', $this->request->action());
        $this->template->content = $html;
    }
    
    /**
     * Метод добавления противопоказания
     */
    public function action_addstop()
    {
        if($this->request->post())
            $this->add_stop();
        $html = View::factory('admin/stop/add');
        $this->template->content = $html;
    }
    
    /**
     * Запись противопоказания в бд
     */
    public function add_stop()
    {
        $awesome = $_POST['awesome'];
        $p = $_POST['p'];
        Model::factory('Admin_Slides')->add_docs($awesome, $p, 3);
        HTTP::redirect('/admin/slides/7');
    }
    
    /**
     * Метод редактирования противопоказания
     */
    public function action_editstop()
    {
        $id = $this->request->param('id');
        if($id)
        {
            if($this->request->post())
            {
                $this->edit_docs();
                HTTP::redirect('/admin/slides/7');
            }
            $docs = Model::factory('Admin_Slides')->get_docs($id);
            $html = View::factory('admin/stop/edit')
                    ->set('docs', $docs);
            $this->template->content = $html;
        }
    }
    
    /**
     * Метод вызывает модели с соответствующим action
     */
    private function slide_rule()
    {
        if($this->request->post())
            $this->edit();
        
        $slide = Model::factory('Admin_Slides')->get_slide($this->request->action());
        $html = View::factory('admin/slides/edit')
                ->set('slide', $slide)
                ->set('action', $this->request->action());
        $this->template->content = $html;
    }
    
    /**
     * Метод редактирования слайда
     */
    private function edit()
    {
        $id = $this->request->post('id');
        $h1 = $this->request->post('h1');
        $text1 = $this->request->post('text1');
        $h2 = $this->request->post('h2');
        $text2 = $this->request->post('text2');
        $h3 = $this->request->post('h3');
        $text3 = $this->request->post('text3');
        
        Model::factory('Admin_Slides')->set_slide($id, $h1, $text1, $h2, $text2, $h3, $text3);
        HTTP::redirect('/admin/slides/'.$this->request->action());
    }
}