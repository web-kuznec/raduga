<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Users extends Controller_Admin_Common {
    
    private $_config = NULL;
    public $_n = 2;    //Количество позиций на странице
    public $_paginator = FALSE; //Пагинатор выключен
    public $_start = 0; //Начало выборки
    public $_limit = 20;    //Ограничение выборки
    
    public function before()
    {
        parent::before();
        if($this->_user === FALSE) // юзер не авторизован
        {
            $this->template->set_filename('login');
            $this->template->name = "Авторизация";
            $this->template->content = $this->noauth();
        }
        $this->_config = Kohana::$config->load('users');
        $this->_n = $this->_config->count_item;
        $this->template->h = "Пользователи";
        $page = $this->request->param('page');
        $pages = $this->pages($this->_n, $page);
        $this->_start = $pages['start'];
        $this->_limit = $pages['limit'];
    }
    
    /**
     * Метод вывода всех пользователей
     */
    public function action_index()
    {
        $filtr = NULL;
        if($this->request->post('filrt-phone'))
            $filtr = $this->request->post('filrt-phone');
        $users = Model::factory('Admin_Users')->get_users($filtr);
        $count = $users->count();
        $this->pagination($count);
        $users = Model::factory('Admin_Users')->get_users_limit($this->_start, $this->_limit, $filtr);
        $html = View::factory('admin/users/all')
                ->set('users', $users)
                ->set('h', 'Все пользователи')
                ->bind('filtr', $filtr)
                ->bind('pagination', $this->_paginator);
        $this->template->h = "";
        $this->template->content = $html;
    }
    
    /**
     * Метод вывода всех пользоваиелей в группе пользователи
     */
    public function action_users()
    {
        $filtr = NULL;
        if($this->request->post('filrt-phone'))
            $filtr = $this->request->post('filrt-phone');
        $users = Model::factory('Admin_Users')->get_only_users($filtr);
        $count = $users->count();
        $this->pagination($count);
        $users = Model::factory('Admin_Users')->get_only_users_limit($this->_start, $this->_limit, $filtr);
        $html = View::factory('admin/users/all')
                ->set('users', $users)
                ->set('h', 'Пользователи')
                ->bind('filtr', $filtr)
                ->bind('pagination', $this->_paginator);
        $this->template->content = $html;
    }
    
    /**
     * Метод вывода всех модераторов
     */
    public function action_moderators()
    {
        $users = Model::factory('Admin_Users')->get_moderators();
        $html = View::factory('admin/users/all')
                ->set('users', $users)
                ->set('h', 'Модераторы')
                ->bind('filtr', $filtr);
        $this->template->content = $html;
    }
    
    /**
     * Метод вывода всех админов
     */
    public function action_admins()
    {
        $filtr = NULL;
        if($this->request->post('filrt-phone'))
            $filtr = $this->request->post('filrt-phone');
        $users = Model::factory('Admin_Users')->get_admin($filtr);
        $count = $users->count();
        $this->pagination($count);
        $users = Model::factory('Admin_Users')->get_admin_limit($this->_start, $this->_limit, $filtr);
        $html = View::factory('admin/users/all')
                ->set('users', $users)
                ->set('h', 'Администраторы')
                ->bind('filtr', $filtr)
                ->bind('pagination', $this->_paginator);
        $this->template->content = $html;
    }
    
    /**
     * Метод выводит форму добавления юзера
     */
    public function action_add()
    {
        if(!empty($_POST))
        {
            $this->new_user();
            exit();
        }
        $this->template->name = "Страница создания пользователя";
        $html = View::factory('admin/users/add');
        $this->template->content = $html;
    }
    
    /**
     * Метод редактирования юзера
     * @throws HTTP_Exception_404
     */
    public function action_edit()
    {
        $id = $this->request->param('id'); // идентификатор юзера в адресной строке
        if($id)
        {
            if(!empty($_POST))
            {
                $this->save_user($id);
                exit();
            }
            $this->template->name = "Страница редактирования пользователя";
            $user = Model::factory('Admin_User')->get_user($id);
            $html = View::factory('admin/users/edit')
                    ->set('user', $user);
            $this->template->content = $html;
        }
        else
        {
            throw new HTTP_Exception_404('Страница не найдена');
            exit();
        }
    }
    
    /**
     * Метод сохранения данных юзера
     * @param int $id - идентификатор пользователя
     */
    private function new_user()
    {
        $name = $this->request->post('name');
        $phone = $this->request->post('phone');
        $descr = $this->request->post('descr');
        $pass = $this->request->post('pass');
        $ban = $this->request->post('ban');
        $status = $this->request->post('status');
        $role = $this->request->post('role');
        $phone = str_replace('(', '', $phone);
        $phone = str_replace(')', '', $phone);
        $phone = str_replace('-', '', $phone);
        $phone = str_replace(' ', '', $phone);
        $phone = "7".str_replace('+7', '', $phone);
        
        if($this->check_phone($phone))
            HTTP::redirect('/admin/users');
        
        $hash = md5($phone.$pass);
        // Сохраняем данные
        $last_user = Model::factory('Admin_Users')->new_user($name, $phone, $descr, $ban, $status, $hash);
        Model::factory('Admin_User')->add_user_role($last_user,$role);
        // Грузим фотоньку
        if(!empty($_FILES['images']['tmp_name'][0]))
            $this->load_img($last_user, '');
        
        HTTP::redirect('/admin/users');
    }
    
    /**
     * Метод проверки номера телефона в базе
     * @param type $phone
     * @return boolean
     */
    private function check_phone($phone)
    {
        $check = Model::factory('Admin_Users')->check_phone($phone);
        if($check->count() > 0 )
            return TRUE;
        else
            return FALSE;
    }
    
    /**
     * Метод сохранения данных юзера
     * @param int $id - идентификатор пользователя
     */
    private function save_user($id)
    {
        $name = $this->request->post('name');
        $phone = $this->request->post('phone');
        $descr = $this->request->post('descr');
        $pass = $this->request->post('pass');
        $pass2 = $this->request->post('pass2');
        if($pass != $pass2)
            $pass = "";
        $ban = $this->request->post('ban');
        $status = $this->request->post('status');
        $old_user = Model::factory('Admin_User')->get_user($id);
        $role = $this->request->post('role');
        // Меняем пароль
        if(!empty($pass))
        {
            $new_phone = $old_user[0]->phone;
            if($old_user[0]->phone != $phone)
                $new_phone = $phone;
            $this->change_pass($id,$new_phone, $pass);
        }
        // Сохраняем данные
        Model::factory('Admin_User')->update_user($id,$name,$descr,$ban,$status);
        Model::factory('Admin_User')->save_role($id,$role);
        // Грузим фотоньку
        if(!empty($_FILES['images']['tmp_name'][0]))
            $this->load_img($id, $old_user[0]->photo.$old_user[0]->ext);
        
        HTTP::redirect('/admin/users');
    }
    
    /**
     * Метод обновляет hash юзера
     * @param int $id - идентификатор пользователя
     * @param int $new_phone - номер телефона пользователя
     * @param varchar $pass - пароль пользователя
     */
    private function change_pass($id,$new_phone, $pass)
    {
        Model::factory('Admin_User')->update_hash($id, md5($new_phone.$pass));
    }
    
    /**
     * Метод загрузки фотографии
     * @param int $id - идентификатор пользователя
     * @param varchar $old_photo - старая фотография, если есть
     */
    private function load_img($id, $old_photo)
    {
        $dir = PUBPATH.'users/'.$id;
        $new_photo = $id."_".date('ymdHis');
        if(!is_dir($dir))
            mkdir($dir, 0777);
        $path = $dir.'/'.$new_photo;
        
        $img = getimagesize($_FILES['images']['tmp_name']);
        $ext = '.' . str_replace('image/', '', $img['mime']);
        $f = $path.$ext;
        $f_small = $path."_small".$ext;
        
        // Вариант на обычном серваке
        if(move_uploaded_file($_FILES['images']['tmp_name'], $f))
        {
            Controller_Static_Images::imageresize($f,$f,$this->_config->max_width_img,$this->_config->max_height_img,100);
            $img_type = image_type_to_mime_type($img[2]);
            if($img_type == "image/jpeg")
                shell_exec("jpegoptim --strip-all " .$f);
            elseif($img_type == "image/png")
                shell_exec("optipng " . $f);
            
            Controller_Static_Images::imageresize($f_small,$f,$this->_config->max_width_img_small,$this->_config->max_height_img_small,100);
            $img_type = image_type_to_mime_type($img[2]);
            if($img_type == "image/jpeg")
                shell_exec("jpegoptim --strip-all " .$f_small);
            elseif($img_type == "image/png")
                shell_exec("optipng " . $f_small);
        }
        
        // Вариант на нормальном серваке
        //$ext = $this->CreateImageOriginal($_FILES['images']['tmp_name'], $path, "users");
        //$this->CreateImageMini($path, $ext, "users");
        $this->dell_img($id, $old_photo);
        $this->save_img($id, $new_photo, $ext);
    }
    
    public function setTransparency($new_image, $image_source)
    {
        $transparencyIndex = imagecolortransparent($image_source);
        $transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255);

        if ($transparencyIndex >= 0)
            $transparencyColor = imagecolorsforindex($image_source, $transparencyIndex);   

        $transparencyIndex = imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']);
        imagefill($new_image, 0, 0, $transparencyIndex);
        imagecolortransparent($new_image, $transparencyIndex);
    }
    
    /**
     * Метод записывает адрес картинки в бд
     * @param int $id - идентификатор пользователя
     * @param varchar $img - название загруженной картинки
     * @param type $ext - расширение загруженной картинки
     */
    private function save_img($id, $img, $ext)
    {
        Model::factory('Admin_User')->new_photo($id, $img, $ext);
    }
    
    /**
     * Метод удаления картинки пользователя
     * @param int $id - идентификатор картинки
     */
    private function dell_img($id,$old_photo)
    {
        if(!empty($old_photo))
        {
            Model::factory('Admin_User')->dell_img($id);
            $file = PUBPATH.'users/'.$id."/".$old_photo;
            $file_small = str_replace(".", "_small.", $file);
            if(file_exists($file))
                unlink($file);
            if(file_exists($file_small))
                unlink($file_small);
        }
    }
    
    public function CreateImageOriginal($tempName, $fileName, $essence)
    {
        $formats = array('image/jpeg' => TRUE, 'image/jpg' => TRUE, 'image/gif' => TRUE, 'image/png' => TRUE);
        $img = getimagesize($tempName);

        if(!isset($formats[$img['mime']]))
            return FALSE;

        $ext = '.' . str_replace('image/', '', $img['mime']);
        exec('cp ' . $tempName . ' ' . $fileName . $ext);

        if($img['channels'] == 4)
            exec('/usr/bin/convert -colorspace RGB ' . $fileName . $ext . ' ' . $fileName . $ext);

        $img_type = image_type_to_mime_type($img[2]);
        if($img_type == "image/jpeg")
            shell_exec("jpegoptim --strip-all " .$fileName.$ext);
        elseif($img_type == "image/png")
            shell_exec("optipng " . $fileName . $ext);
        
        $this->CreateMainImage($fileName, $ext, $essence, $img);

        return $ext;
    }
    
    public function CreateMainImage($fileName, $ext, $essence, $img)
    {
        $img = getimagesize($fileName . $ext);
        $img_type = image_type_to_mime_type($img[2]);

        if($essence == 'users')
        {
            $size = $img[0] > $this->_config->max_width_img || $img[1] > $this->_config->max_height_img ?  $this->_config->max_width_img.'x'.$this->_config->max_height_img : $size = $img[0] . 'x' . $img[1];
            exec('/usr/bin/convert -quality 100 -geometry ' . $size . ' ' . $fileName . $ext . ' ' . $fileName . $ext);
            if($img_type == "image/jpeg")
                shell_exec("jpegoptim --strip-all " . $fileName . $ext);
            elseif($img_type == "image/png")
                shell_exec("optipng" . $fileName . $ext);
        }
    }
    
    public function CreateImageMini($fileName, $ext, $essence)
    {
        $img = getimagesize($fileName . $ext);
        $img_type = image_type_to_mime_type($img[2]);

        $this->AutoImageResize($fileName . $ext, $fileName . '_small' . $ext, $this->_config->max_width_img_small, $this->_config->max_height_img_small);
        if($img_type == "image/jpeg")
            shell_exec("jpegoptim --strip-all ".$fileName . "_small" . $ext);
        elseif($img_type == "image/png")
            shell_exec("optipng ".$fileName . "_small" . $ext);
    }
    
    private function AutoImageResize($path, $pathNew, $wDest, $hDest)
    {
        list($width, $height) = getimagesize($path);
        list($wNew, $hNew) = array($width, $height);
        $mulTrue = $wDest / $hDest;
        $mul = $width / $height;

        if($mulTrue > $mul = $width / $height)
            $hNew = ceil($width * $hDest / $wDest);
        else
            $wNew = ceil($height * $wDest / $hDest);

        $offsetX = floor(($width - $wNew) / 2);
        $offsetY = floor(($height - $hNew) / 2);

        exec("/usr/bin/convert -crop ${wNew}x$hNew+$offsetX+$offsetY $path $pathNew");
        exec("/usr/bin/convert -geometry ${wDest}x$hDest -quality 100 $pathNew $pathNew");
    }
    
    /**
     * Постраничная навигация
     * @param integer $count количество позиций
     */
    public function pagination($count)
    {
        $page = $this->request->param('page');
        if(isset($page))
        {
            $this->_start = $this->_n*$page-$this->_n;
            $this->_limit = $this->_n;
        }
        else
        {
            $this->_limit = $this->_n;
        }
        $this->_paginator = Pagination::factory(array('total_items' => $count, 'items_per_page' => $this->_n));
    }
    
    public function pages($count, $page = NULL)
    {
        if($page)
        {
            $start = $count*$page-$count;
            $limit = $count;
        }
        else
        {
            $start = 0;
            $limit = $count;
        }
        return array('start' => $start, 'limit' => $limit);
    }
    
}