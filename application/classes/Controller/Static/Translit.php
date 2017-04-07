<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Static_Translit extends Controller {
    
    public static $_id = NULL;
    public static $_table = "";
    public static $_name = "";
    public static $_ext = NULL;
    
    public static $rule = array(
            "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
            "Д"=>"d","Е"=>"e","Ё"=>"e","Ж"=>"j","З"=>"z","И"=>"i",
            "Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
            "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
            "У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch",
            "Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"",
            "Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
            "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ё"=>"e","ж"=>"j",
            "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
            "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
            "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
            "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
            "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
            " "=>"-","'"=>"","."=>"",","=>"","*"=>"","@"=>"",
            "!"=>"","#"=>"","$"=>"","/"=>"-","%"=>"","^"=>"",
            ":"=>"","&"=>"","*"=>"","+"=>"-","="=>"-","?"=>"",
            ";"=>"","_"=>"","|"=>"","№"=>"","«"=>"","»"=>"",
            '"'=>"","“"=>"","”"=>"","("=>"",")"=>""
        );
    
    //@param $name - Строка которую надо преобразовать в транслит
    //@param $table - Таблица в которой будет транслит
    //@param $id - id в таблице для которого ставим транслит
    //@param $ext - Расширение, которое добавить в конец транслита (php)
    /**
     * 
     * @param string $name
     * @param string $table
     * @param integer $id
     * @param string $ext
     * @return string
     */
    public static function index($name, $table, $id = NULL, $ext = NULL)
    {
        self::set_params($name, $table, $id, $ext);
        $translit = self::translit(self::$_name);
        return $translit;
    }
    
    private static function set_params($name, $table, $id, $ext)
    {
        self::$_name = trim($name);
        self::$_table = trim($table);
        if($id !== NULL)
            self::$_id = trim($id);
        if($ext !== NULL)
            self::$_ext = trim($ext);
    }
    
    /*
     * Метод преобразует $name в транслит
     */
    public static function translit($name)
    {
        $translit = strtr($name, self::$rule);
        $tmp_translit = self::temp($translit);
        $check = self::check($tmp_translit, self::$_table, self::$_id);
        if($check === TRUE) {
            $tmp_translit = self::correct($translit);
            $tmp_translit = self::temp($tmp_translit);
        }
        
        return $tmp_translit;
    }
    
    public static function temp($translit) {
        if(self::$_ext !== NULL)
            $tmp_translit = $translit.".".self::$_ext;
        else
            $tmp_translit = $translit;
        return $tmp_translit;
    }
    
    /*
     * Проверка на совпадение поля translit
     * Возвращает true если нет совпадений, false иначе
     */
    public static function check($translit, $table, $id = NULL)
    {
        return Model::factory('Translit')->check($translit, $table, $id);
    }
    
    /*
     * Метод возвращает уникальный translit для таблицы
     */
    private static function correct($translit)
    {
        $rand = rand(0, 9);
        $translit = $translit.$rand;
        $check = self::check($translit, self::$_table, self::$_id);
        if($check === TRUE)
            $translit = self::correct($translit);
        else
            return $translit;
    }
    
} //END Controller_Static_Translit