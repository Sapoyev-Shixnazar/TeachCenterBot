<?php
/**
 * Created by PhpStorm.
 * User: Sapayev-PC
 * Date: 05.06.2020
 * Time: 22:34
 */

class Subjects
{
    public $lang;

    function __construct($lang = 'uz')
    {
        $this->lang = $lang;
    }

    function setLanguage($lang)
    {
        $this->lang = $lang;
    }

    function getLanguage()
    {
        return $this->lang;
    }

    /**
     * @param $keyword
     * @return mixed
     */
    function getSubject($keyword)
    {
        global $db;
        $result = $db->query("SELECT " . "* FROM `subjects` WHERE `keyword` = '{$keyword}' LIMIT 1");
        $arr = $result->fetch_assoc();
        $text = "";
        if (isset($arr[$this->lang]))
            $text = $arr[$this->lang];
        return $text;
    }

    function getSubjects()
    {
        global $db;
        $result = $db->query("SELECT " . "* FROM `subjects`");
        $array = [];
        while ($arr = $result->fetch_assoc()) {
            if (isset($arr[$this->lang]))
                $array[] = $arr[$this->lang];
        }
        return $array;
    }
    function getKeyword($name)
    {
        global $db;
        $keyword = "";
        //$result = $db->query("SELECT * FROM `subjects` WHERE `{$this->lang}` = '{$name}' LIMIT 1");
        $result = $db->query("SELECT". " * FROM `subjects` WHERE `{$this->lang}` = '{$name}' LIMIT 1");

        $arr = $result->fetch_assoc();
        if (isset($arr[$this->lang])) {
            $keyword = $arr['keyword'];
        }

        return $keyword;
    }
}