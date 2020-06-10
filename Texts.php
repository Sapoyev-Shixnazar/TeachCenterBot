<?php
require_once "db_connect.php";
//require_once "Users.php";

class Texts
{
    public $lang;

    function __construct($lang='uz')
    {
        $this->lang = $lang;
    }

    function setLanguage($lang){
        $this->lang = $lang;
    }
    function getLanguage(){
        return $this->lang;
    }
    /**
     * @param $keyword
     * @return mixed
     */
    function getmText($keyword)
    {
        global $db;
        $result = $db->query("SELECT " . "* FROM `texts` WHERE `keyword` = '{$keyword}' LIMIT 1");
        $arr = $result->fetch_assoc();
        $text = "";
        if(isset($arr[$this->lang]))
            $text = $arr[$this->lang];
        return $text;
    }
}
