<?php
/**
 * Created by PhpStorm.
 * User: Sapayev-PC
 * Date: 05.06.2020
 * Time: 13:38
 */

class Districts
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
    function getDistrict($keyword)
    {
        global $db;
        $result = $db->query("SELECT " . "* FROM `districts` WHERE `keyword` = '{$keyword}' LIMIT 1");
        $arr = $result->fetch_assoc();
        $text = "";
        if (isset($arr[$this->lang]))
            $text = $arr[$this->lang];
        return $text;
    }

    function getDistricts()
    {
        global $db;
        $result = $db->query("SELECT " . "* FROM `districts`");
        $array = [];
        while ($arr = $result->fetch_assoc()) {
            if (isset($arr[$this->lang]))
                $array[] = $arr[$this->lang];
        }
        return $array;
    }

    /**
     * @param $name
     * @return string
     */
    function getKeyword($name)
    {
        global $db;
        $keyword = "";
        //$result = $db->query("SELECT * FROM `districts` WHERE `{$this->lang}` = '{$name}' LIMIT 1");
        $result = $db->query("SELECT" ." * FROM `districts` WHERE `{$this->lang}` = '{$name}' LIMIT 1");

        $arr = $result->fetch_assoc();
        if (isset($arr[$this->lang])) {
            $keyword = $arr['keyword'];
        }

        return $keyword;
    }
}