<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Blocks extends Controller_Admin_Common {
    
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
        
        if(Kohana::$config->load('logo')->count())
            $this->_config = Kohana::$config->load('logo');
    }

    public function action_index()
    {
        $blocks = Model::factory('Admin_Blocks')->get_all();
        if($this->request->post())
            $this->save_sort();
        $html = View::factory('admin/blocks/sort')
                ->set('info', $blocks);
        $this->template->name = "Сортировка";
        $this->template->content = $html;
    }
    
    private function save_sort()
    {
        $id = $this->request->post('id');
        $sort = $this->request->post('sort');
        Model::factory('Admin_Blocks')->save_sort($id, $sort);
        HTTP::redirect('/admin/blocks');
        exit();
    }
    
    /**
     * Метод вывода редактора логотипа
     */
    public function action_logo()
    {
        if($this->request->post())
            $this->edit();
        $logo = Model::factory('Admin_Blocks')->get_logos();
        $html = View::factory('admin/blocks/logo')
                ->set('info', $logo);
        $this->template->name = "Логотип";
        $this->template->content = $html;
    }
    
    /**
     * Метод вывода заголовка
     */
    public function action_headers()
    {
        if($this->request->post())
            $this->edit_headers();
            
        $headers = Model::factory('Admin_Blocks')->get_headers();
        $id = $name = NULL;
        if($headers->count() > 0)
        {
            $name = $headers[0]->name;
            $id = $headers[0]->id;
        }
        $html = View::factory('admin/blocks/headers')
                ->bind('headers', $name)
                ->bind('id', $id);
        $this->template->name = "Заголовок";
        $this->template->content = $html;
    }
    
    /**
     * Метод вывода текста
     */
    public function action_text()
    {
        if($this->request->post())
            $this->edit_text();
            
        $headers = Model::factory('Admin_Blocks')->get_text();
        $id = $text = NULL;
        if($headers->count() > 0)
        {
            $text = $headers[0]->text;
            $id = $headers[0]->id;
        }
        $html = View::factory('admin/blocks/text')
                ->bind('text', $text)
                ->bind('id', $id);
        $this->template->name = "Текст";
        $this->template->content = $html;
    }
    
    /**
     * Метод вывода баннеров
     */
    public function action_banners()
    {
        if($this->request->post())
            $this->edit_banners();
        $banners = Model::factory('Admin_Blocks')->get_banners();
        $html = View::factory('admin/blocks/banners')
                ->bind('banners', $banners)
                ->set('count', $banners->count())
                ->set('limit', $this->count_banners);
        $this->template->name = "Баннеры";
        $this->template->content = $html;
    }
    
    /**
     * Метод Добавления баннера
     */
    public function action_bannersnew()
    {
        $href = $this->correct_href($this->request->post('href'));
        $last = Model::factory('Admin_Blocks')->insert_href($href);
        if(!empty($_FILES['ban']['tmp_name']))
            $this->insert_ban($last);
        HTTP::redirect('/admin/blocks/banners');
        exit();
    }
    
    private function correct_href($href)
    {
        if($href != '')
        {
            if(stristr($href, 'https://') === FALSE && stristr($href, 'http://') === FALSE)
                return 'http://'.$href;
            else
                return $href;
        }
    }
    
    /**
     * Метод редактирования баннера
     */
    private function edit_banners()
    {
        $id = $this->request->post('id');
        $href = $this->correct_href($this->request->post('href'));
        Model::factory('Admin_Blocks')->update_href($id, $href);
        if(!empty($_FILES['ban']['tmp_name']))
            $this->update_ban($id);
        HTTP::redirect('/admin/blocks/banners');
        exit();
    }
    
    /**
     * Метод изменения баннера
     * @param int $id - id баннера
     */
    private function update_ban($id)
    {
        $this->dell_ban($id);
        $dir = PUBPATH.'banners/'.$id;
        $new_photo = date('ymdHis_');
        if(!is_dir($dir))
            mkdir($dir, 0777);
        $img = getimagesize($_FILES['ban']['tmp_name']);
        $ext = '.' . str_replace('image/', '', $img['mime']);
        $f = $dir.'/'.$new_photo.$ext;
        if(move_uploaded_file($_FILES['ban']['tmp_name'], $f))
        {
            Controller_Static_Images::imageresize($f,$f,$this->_config->max_width_img,$this->_config->max_height_img,100);
            $img_type = image_type_to_mime_type($img[2]);
            if($img_type == "image/jpeg")
                shell_exec("jpegoptim --strip-all " .$f);
            elseif($img_type == "image/png")
                shell_exec("optipng " . $f);
            Model::factory('Admin_Blocks')->update_ban($id, $new_photo.$ext);
        }
    }
    
    /**
     * Метод добавления баннера
     * @param int $id - id записи в таблице баннеров
     */
    private function insert_ban($id)
    {
        $dir = PUBPATH.'banners/'.$id;
        $new_photo = date('ymdHis_');
        if(!is_dir($dir))
            mkdir($dir, 0777);
        $img = getimagesize($_FILES['ban']['tmp_name']);
        $ext = '.' . str_replace('image/', '', $img['mime']);
        $f = $dir.'/'.$new_photo.$ext;
        if(move_uploaded_file($_FILES['ban']['tmp_name'], $f))
        {
            Controller_Static_Images::imageresize($f,$f,$this->_config->max_width_img,$this->_config->max_height_img,100);
            $img_type = image_type_to_mime_type($img[2]);
            if($img_type == "image/jpeg")
                shell_exec("jpegoptim --strip-all " .$f);
            elseif($img_type == "image/png")
                shell_exec("optipng " . $f);
            Model::factory('Admin_Blocks')->update_ban($id, $new_photo.$ext);
        }
    }
    
    /**
     * Метод удаляет баннер
     * @param int $id - id баннера
     */
    private function dell_ban($id)
    {
        $ban = Model::factory('Admin_Blocks')->get_ban($id);
        if($ban->count() > 0)
        {
            $img = $ban[0]->img;
            $file = PUBPATH.'banners/'.$id.'/'.$img;
            if(file_exists($file))
                unlink($file);
        }
    }
    
    /**
     * Метод редактирования текста
     */
    private function edit_text()
    {
        if($this->request->post('id'))
            Model::factory('Admin_Blocks')->update_text($this->request->post('id'), $this->request->post('text'));
        else
            Model::factory('Admin_Blocks')->insert_text($this->request->post('text'));
        HTTP::redirect('/admin/blocks/text');
        exit();
    }
    
    /**
     * Метод редактирование заголовка
     */
    private function edit_headers()
    {
        if($this->request->post('id'))
            Model::factory('Admin_Blocks')->update_header($this->request->post('id'), $this->request->post('name'));
        else
            Model::factory('Admin_Blocks')->insert_header($this->request->post('name'));
        HTTP::redirect('/admin/blocks/headers');
        exit();
    }
    
    /**
     * Метод редактирования логотипа
     */
    private function edit()
    {
        if(!empty($_FILES['image']['tmp_name']))
            $this->load_img();
        HTTP::redirect('/admin/blocks/logo');
        exit();
    }
    
    /**
     * Метод загрузки фото
     * @param type $id
     */
    private function load_img()
    {
        $dir = PUBPATH.'logo';
        $new_photo = date('ymdHis_');
        if(!is_dir($dir))
            mkdir($dir, 0777);
        $img = getimagesize($_FILES['image']['tmp_name']);
        $ext = '.' . str_replace('image/', '', $img['mime']);
        $f = $dir.'/'.$new_photo.$ext;
        if(move_uploaded_file($_FILES['image']['tmp_name'], $f))
        {
            Controller_Static_Images::imageresize($f,$f,$this->_config->max_width_img,$this->_config->max_height_img,100);
            $img_type = image_type_to_mime_type($img[2]);
            if($img_type == "image/jpeg")
                shell_exec("jpegoptim --strip-all " .$f);
            elseif($img_type == "image/png")
                shell_exec("optipng " . $f);
            $this->dell_logo();
            Model::factory('Admin_Blocks')->add_logo($new_photo.$ext);
        }
    }
    
    /**
     * Удаление фото
     */
    private function dell_logo()
    {
        $logo = Model::factory('Admin_Blocks')->get_logos();
        if($logo->count() > 0)
        {
            foreach($logo as $k => $v)
            {
                $file = PUBPATH.'logo/'.$v->name;
                if(file_exists($file))
                    unlink($file);
            }
        }
        Model::factory('Admin_Blocks')->dell_logos();
    }
    
    /**
     * Метод удаления баннера
     */
    public function action_bannerdell()
    {
        if($this->request->param('id'))
        {
            $id = $this->request->param('id');
            $this->dell_ban($id);
            Model::factory('Admin_Blocks')->dell_banners($id);
        }
        HTTP::redirect('/admin/blocks/banners');
        exit();
    }
}