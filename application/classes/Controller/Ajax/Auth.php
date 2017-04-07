<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax_Auth extends Controller_JSON
{
    public $_reg_error;
    public $_user = NULL;
    public $_pass = NULL;
    public $_remember = NULL;

    /**
     * Авторизация
     */
    public function action_index()
    {
        if(empty($this->_error))
        {
            $this->_user = $this->request->post('username');
            $this->_pass = $this->request->post('password');

            $post = Validation::factory($this->request->post());
            $post->rule(TRUE, 'not_empty');
            if($post->check()) // проводим валидацию
            {
                $this->check_auth();
            }
            echo json_encode($this->_result);
        }
        else
            echo json_encode($this->_errorr);
    }

    /**
     * Функция проверяет авторизацию - есть ли такой юзер в бд
     */
    /* Клевая авторизация с солью
     * private function check_auth()
    {
        $user = Model::factory('Admin_User')->get_user_by_name($this->_user);
        if($user->count() == 1)
        {
            foreach($user as $r)
            {
                $user_id = $r->id;
                $bdname = $r->nick;
                $bdpass = $r->password;
                $bdsalt = $r->salt;
            }
            if($this->check_coding($this->_user, $this->_pass, $bdsalt) == $bdpass)
                $this->set_cooks($user_id);
            else
                $this->_result['code'] = "pass";
        } else
        {
            $this->_result['code'] = "not users";
        }
    }*/
    private function check_auth()
    {
        $user = Model::factory('Admin_User')->get_user_by_phone($this->_user);
        if($user->count() == 1)
        {
            foreach($user as $r)
            {
                $user_id = $r->id;
                $phone = $r->phone;
                $hash = $r->hash;
            }
            if(md5($this->_user.$this->_pass) == $hash)
                $this->set_cooks($user_id);
            else
                $this->_result['code'] = "pass";
        } else
        {
            $this->_result['code'] = "not users";
        }
    }

    /**
     * Функция устанавливает куки пользователя и заполняет сессию
     * @param type $user_id
     */
    private function set_cooks($user_id)
    {
        if(isset($this->_remember))
        {
            setcookie('login', $this->_user, time() + 604800, "/");
            setcookie('pass', $this->_pass, time() + 604800, "/");
        }
        if(!session_id())
            @session_start();
        $_SESSION['unic'] = $user_id;
        $this->user_detect();
        $_SESSION['role'] = $this->_role;

        $this->_result['code'] = "success";
    }

    /**
     * Функция регистрации
     */
    public function action_registaration()
    {
        if(empty($this->_error))
        {
            if($this->valid_reg())
            {
                $username = $this->request->post('nick');
                $email = $this->request->post('email');
                $password = $this->request->post('password');
                $password_confirm = $this->request->post('password_confirm');
                $salt = md5(microtime());
                $newpass = $this->coding($username, $password, $salt);
                $confirm = md5(microtime());
                Model::factory("User")->add_user($username, $email, $newpass, $salt, $confirm);
                $config = Kohana::$config->load('email');
                Email::connect($config);
                $to = array('to' => $email);
                $subject = 'Подтверждение регистрации';
                $from = 'yasv-777@yandex.ru';
                $message = '<h3>Подтверждение регистрации</h3><br>Ваш email '.$email.' был указан при регистрации на сайте '. URL::base("http", TRUE).'.<br>Для прохождения регистрации, пожалуйста, пройдите по ссылке <a href="'.URL::base('http', TRUE).'admin/admin/confirm/?confirm='.$confirm.'">'.URL::base("http", TRUE).'</a>, если вы нигде не регистрировались, просто удалите это письмо.';

                Email::send($to, $from, $subject, $message, $html = true);
                $this->_result['code'] = "success";
            }
            else
                $this->_result['code'] = $this->_reg_error;

            echo json_encode($this->_result);
        }
        else
            echo json_encode($this->_errorr);
    }

    public function action_backup()
    {
        if(empty($this->_error))
        {
            if($this->valid_backup())
            {
                $email = $this->request->post('email');
                $reset = md5(microtime());
                $date = date('Y-m-d H:i:s');

                Model::factory("User")->set_reset($email, $reset, $date);

                $config = Kohana::$config->load('email');
                Email::connect($config);
                $to = array('to' => $email);
                $subject = 'Восстановление пароля';
                $from = 'yasv-777@yandex.ru';
                $message = '<h3>Восстановление пароля</h3><br>Ваш email '.$email.' был указан при восстанолении пароля на сайте '. URL::base("http", TRUE).'.<br>Для продолжения, пожалуйста, пройдите по ссылке <a href="'.URL::base('http', TRUE).'admin/admin/reset/?reset='.$reset.'">'.URL::base("http", TRUE).'</a>, если вы не восстанавливали пароль, просто удалите это письмо.';

                Email::send($to, $from, $subject, $message, $html = true);
                $this->_result['code'] = "success";
            }
            else
                $this->_result['code'] = $this->_reg_error;

            echo json_encode($this->_result);
        }
        else
            echo json_encode($this->_errorr);
    }

    public function action_newpass()
    {
        if(empty($this->_error))
        {
            if($this->valid_newpass())
            {
                $pass = $this->request->post('pass');
                $pass_confirm = $this->request->post('pass_confirm');
                $user = $this->request->post('user');
                $about = Model::factory('User')->get_user($user);
                if($about->count() == 1 && $pass == $pass_confirm)
                {
                    foreach($about as $k => $v)
                    {
                        $nick = $v->nick;
                    }
                    $salt = md5(microtime());
                    $newpass = $this->coding($nick, $pass, $salt);
                    $confirm = md5(microtime());
                    Model::factory('User')->newpass($user, $newpass, $salt, $confirm);
                    $this->_result['code'] = "success";
                    echo json_encode($this->_result);
                }
            }
            else
                echo json_encode($this->_reg_error);
        }
        else
            echo json_encode($this->_errorr);
    }

    private function valid_newpass()
    {
        $post = Validation::factory($this->request->post());
        $post->rule('pass', 'not_empty')
            ->rule('pass_confirm', 'not_empty');
        if($post->check())
            return TRUE;
        else
        {
            $this->_reg_error = $post->errors('user');
            return FALSE;
        }
    }

    /**
     * Функция проверяет поля регистрации
     * @return boolean
     */
    private function valid_reg()
    {
        $user = Model::factory('User');
        $post = Validation::factory($this->request->post());
        $post->rule('nick', 'not_empty')
            ->rule('password', 'not_empty')
            ->rule('password', 'matches', array(':validation', 'password', 'password_confirm'))
            ->rule('email', 'email')
            ->rule('email', 'email_domain')
            ->rule('nick', array($user, 'unique_nick'))
            ->rule('email', array($user, 'unique_email'));
        if($post->check())
            return TRUE;
        else
        {
            $this->_reg_error = $post->errors('user');
            return FALSE;
        }
    }

    private function valid_backup()
    {
        $post = Validation::factory($this->request->post());
        $post->rule('email', 'email')
            ->rule('email', 'email_domain');
        if($post->check())
            return TRUE;
        else
        {
            $this->_reg_error = $post->errors('user');
            return FALSE;
        }
    }


    /**
     * Функция кодирует пароль
     * @param type $username
     * @param type $password
     * @return type
     */
    private function coding($username, $password, $salt)
    {
        $pwd = md5($password);
        $combine = $pwd . $salt . $username;
        return md5($combine);
    }

    private function check_coding($username, $password, $salt)
    {
        $pwd = md5($password);
        $combine = $pwd . $salt . $username;
        return md5($combine);
    }

    public function action_exit()
    {
        unset($_SESSION['unic']);
        unset($_SESSION['role']);
        setcookie('login', "", time() + 604800, "/");
        setcookie('pass', "", time() + 604800, "/");
    }

    public function action_show_registration()
    {
        echo View::factory('auth/registration');
    }

    public function action_show_auth()
    {
        echo View::factory('auth/auth');
    }

    public function action_show_backap()
    {
        echo View::factory('auth/backup');
    }

}