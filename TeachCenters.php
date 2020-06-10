<?php
/**
 * Created by PhpStorm.
 * User: Sapayev-PC
 * Date: 06.06.2020
 * Time: 23:28
 */

class TeachCenters
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
    function getCenters($district, $key)
    {
        global $db;
        $result = $db->query("SELECT " . "* FROM `trainingcentres` WHERE `district` = '{$district}'");
        $array = [];
        while ($arr = $result->fetch_assoc()) {
            $keys = explode(", ", $arr['subjects']);
            if (isset($arr['name']) && in_array($key, $keys))
                $array[] = $arr['name'];
        }
        return $array;
    }
    function getAllCenters()
    {
        global $db;
        $result = $db->query("SELECT " . "* FROM `trainingcentres`");
        $array = [];
        while ($arr = $result->fetch_assoc()) {
            if (isset($arr['name']))
                $array[] = $arr['name'];
        }
        return $array;
    }

}