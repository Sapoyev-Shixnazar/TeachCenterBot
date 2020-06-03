<?php
require_once "db_connect.php";
require_once "users.php";

function getmText($keyword, $chat_id)
{
    global $db;
    $lang = getLanguage($chat_id);
    $result = $db->query("SELECT * FROM `texts` WHERE `keyword` = '{$keyword}' LIMIT 1");

    $arr = $result->fetch_assoc();
    var_dump($arr);
}