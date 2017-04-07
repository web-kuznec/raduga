<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Admin_User extends Model
{
    protected $_table = "users";
    
    public function get_token($id)
    {
        return DB::select()
                ->from('users_token')
                ->where('users_id', '=', $id)
                ->as_object()
                ->execute();
    }
    
    public function get_user($id)
    {
        return DB::select('users.*, users_roles.role_id')
                    ->from($this->_table)
                    ->join('users_roles')
                    ->on('users.id', '=', 'users_roles.user_id')
                    ->where('users.id', '=', $id)
                    ->as_object()
                    ->execute();
    }
    
    public function get_user_by_id($id)
    {
        return DB::select()
                    ->from($this->_table)
                    ->where('id', '=', $id)
                    ->as_object()
                    ->execute();
    }
    
    public function save_role($id,$role)
    {
        DB::update('users_roles')
                ->set(array('role_id' => $role))
                ->where('user_id', '=', $id)
                ->execute();
    }
    
    public function add_user_role($id,$role)
    {
        DB::insert('users_roles', array('user_id', 'role_id'))
                ->values(array($id, $role))
                ->execute();
    }
    
    public function get_user_by_name($id)
    {
        return DB::select()
                    ->from($this->_table)
                    ->where('nick', '=', $id)
                    ->as_object()
                    ->execute();
    }
    
    public function get_user_by_phone($phone)
    {
        return DB::select()
                    ->from($this->_table)
                    ->where('phone', '=', $phone)
                    ->as_object()
                    ->execute();
    }
    
    public function get_user_by_hash($hash)
    {
        return DB::select()
                    ->from($this->_table)
                    ->where('hash', '=', $hash)
                    ->as_object()
                    ->execute();
    }
    
    public function unique_phone($phone)
    {
        return ! DB::select(array(DB::expr('COUNT(phone)'), 'total'))
                    ->from('users')
                    ->where('phone', '=', $phone)
                    ->execute()
                    ->get('total');
    }
    
    public function update_hash($id, $hash)
    {
        DB::update($this->_table)
                ->set(array('hash' => $hash))
                ->where('id', '=', $id)
                ->execute();
        return FALSE;
    }
    
    public function check_token($id, $token)
    {
        return DB::select()
                    ->from('users_token')
                    ->where('token', '=', $token)
                    ->where('users_id', '=', $id)
                    ->as_object()
                    ->execute();
    }
    
    public function isset_tocken($token)
    {
        return DB::select()
                    ->from('users_token')
                    ->where('token', '=', $token)
                    ->as_object()
                    ->execute();
    }
    
    public function isset_phone_and_code($phone, $code)
    {
        return DB::select(array(DB::expr('COUNT(phone)'), 'total'))
                    ->from('users')
                    ->where('phone', '=', $phone)
                    ->where('code_sms', '=', $code)
                    ->execute()
                    ->get('total');
    }
    
    public function confirm_code_sms($phone, $code)
    {
        DB::update($this->_table)
                ->set(array('status' => 1, 'code_sms' => NULL, 'date_sms' => date('Y-m-d H:i:s')))
                ->where('phone', '=', $phone)
                ->where('code_sms', '=', $code)
                ->execute();
    }
    
    public function unique_nick($nick)
    {
        return ! DB::select(array(DB::expr('COUNT(nick)'), 'total'))
                    ->from('users')
                    ->where('nick', '=', $nick)
                    ->execute()
                    ->get('total');
    }
    
    public function unique_email($email)
    {
        return ! DB::select(array(DB::expr('COUNT(nick)'), 'total'))
                    ->from('users')
                    ->where('email', '=', $email)
                    ->execute()
                    ->get('total');
    }
    
    public function add_user($phone, $hash, $token, $os, $confirm, $code_sms)
    {
        $result = DB::insert($this->_table, array('phone', 'hash', 'os', 'confirm', 'code_sms', 'status'))
                    ->values(array($phone, $hash, $os, $confirm, $code_sms, '0'))
                    ->execute();
        $last_id = $result[0];
        DB::insert('users_token', array('token', 'users_id'))
                    ->values(array($token, $last_id))
                    ->execute();
        return $last_id;
    }
    
    public function confirm($confirm)
    {
        $query = DB::select('id')
            ->from($this->_table)
            ->where('confirm', '=', $confirm)
            ->where('status', '=', 0)
            ->limit('1')
            ->execute()
            ->as_array();
        if(isset($query[0]['id']))
        {
            DB::update($this->_table)
                ->set(array('status' => 1))
                ->where('id', '=', $query[0]['id'])
                ->execute();
            return $query[0];
        }
        else
            return FALSE;
    }
    
    public function user_role($id)
    {
        $query = DB::select()
                    ->from('users_roles')
                    ->where('user_id', '=', $id)
                    ->where('role_id', '=', 1)
                    ->execute()
                    ->as_array();
        if(!isset($query[0]))
            DB::insert('users_roles', array('user_id', 'role_id'))
                ->values(array($id, 1))
                ->execute();
    }
    
    public function set_reset($email, $reset, $date)
    {
        DB::update($this->_table)
                ->set(array('reset' => $reset, 'reset_data' => $date))
                ->where('email', '=', $email)
                ->execute();
    }
    
    public function reset($reset)
    {
        $query = DB::select()
                    ->from($this->_table)
                    ->where('reset', '=', $reset)
                    ->where('reset_data', '<', DB::expr('NOW()'))
                    ->where(DB::expr('reset_data + INTERVAL 30 MINUTE' ), '>', DB::expr('NOW()'))
                    ->limit(1)
                    ->execute()
                    ->as_array();
        
        if(isset($query[0]))
        {
            DB::update($this->_table)
                    ->set(array('reset' => NULL, 'reset_data' => NULL))
                    ->where('id', '=', $query[0]['id'])
                    ->execute();
            return $query[0];
        }
        else
            return FALSE;
    }
    
    public function newpass($user, $newpass, $salt, $confirm)
    {
        DB::update($this->_table)
            ->set(array('password' => $newpass, 'salt' => $salt, 'confirm' => $confirm))
            ->where('id', '=', $user)
            ->execute();
    }
    
    public function dell_tocken($token)
    {
        DB::delete('users_token')
                ->where('token', '=', $token)
                ->execute();
    }
    
    public function update_code_sms($phone, $sms)
    {
        DB::update($this->_table)
            ->set(array('code_sms' => $sms))
            ->where('phone', '=', $phone)
            ->execute();
    }
    
    public function change_hash($old, $new)
    {
        DB::update($this->_table)
                ->set(array('hash' => $new))
                ->where('hash', '=', $old)
                ->execute();
    }
    
    public function check_isset_hash($hash)
    {
        return DB::select(array(DB::expr('COUNT(hash)'), 'total'))
                    ->from($this->_table)
                    ->where('hash', '=', $hash)
                    ->execute()
                    ->get('total');
    }
    
    public function get_user_by_event($id)
    {
        return DB::select('users.*')
                ->from('users')
                ->join('events_users')
                ->on('users.id','=','events_users.users_id')
                ->where('events_users.events_id','=',$id)
                ->as_object()
                ->execute();
    }
    
    public function update_user($id,$name,$descr,$ban,$status)
    {
        DB::update($this->_table)
                ->set(array('name' => $name, 'descr' => $descr, 'ban' => ($ban == 0) ? NULL : 1 , 'status' => $status ))
                ->where('id','=',$id)
                ->execute();
    }
    
    public function dell_img($id)
    {
        DB::update($this->_table)
                ->set(array('photo' => NULL, 'ext' => NULL))
                ->where('id','=',$id)
                ->execute();
    }
    
    public function new_photo($id, $img, $ext)
    {
        DB::update($this->_table)
                ->set(array('photo' => $img, 'ext' => $ext))
                ->where("id", "=", $id)
                ->execute();
    }
    
    public function noban($id)
    {
        DB::update($this->_table)
                ->set(array('ban' => NULL))
                ->where("id", "=", $id)
                ->execute();
    }
    
    public function ban($id)
    {
        DB::update($this->_table)
                ->set(array('ban' => 1))
                ->where("id", "=", $id)
                ->execute();
    }
    
    public function dell($id)
    {
        DB::update($this->_table)
                ->set(array('status' => 2))
                ->where("id", "=", $id)
                ->execute();
    }
    
    public function set_vote_up($id)
    {
        DB::update($this->_table)
                ->set(array('range_for' => DB::expr('range_for + 1'), 'range_all' => DB::expr('range_all + 1')))
                ->where('id', '=', $id)
                ->execute();
    }
    
    public function set_vote_down($id)
    {
        DB::update($this->_table)
                ->set(array('range_all' => DB::expr('range_all + 1')))
                ->where('id', '=', $id)
                ->execute();
    }
    
    public function set_vote_static($user, $id, $vote)
    {
        DB::insert('vote_static', array('users_id', 'participant_id', 'vote'))
                ->values(array($user, $id, $vote))
                ->execute();
    }
    
    public function check_vote($user_id, $participant_id)
    {
        return DB::select()
                ->from('vote_static')
                ->where('users_id', '=', $user_id)
                ->where('participant_id', '=', $participant_id)
                ->as_object()
                ->execute();
                
    }
    
    public function check_isset_user($id)
    {
        $query = DB::select()
                ->from($this->_table)
                ->where('id', '=', $id)
                ->as_object()
                ->execute();
        
        if($query->count() == 0)
            return TRUE;
        else
            return FALSE;
    }
    
    public function edit($id, $name, $descr = NULL)
    {
        DB::update($this->_table)
                ->set(array('name' => $name, 'descr' => $descr))
                ->where('id', '=', $id)
                ->execute();
    }
    
    public function edit_interests($id, $interests)
    {
        DB::update($this->_table)
                ->set(array('interests' => $interests))
                ->where('id', '=', $id)
                ->execute();
    }
}