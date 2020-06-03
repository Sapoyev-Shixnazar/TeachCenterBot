<?php

function setPage($chat_id, $data)
{
    file_put_contents('users/' . $chat_id . 'page.txt', $data);
}

function getPage($chat_id) {
    return file_get_contents('users/' . $chat_id . 'page.txt');
}
function setLanguage($chat_id, $content){
    file_put_contents('users/'.$chat_id.'language.txt', $content);
}
function getLanguage($chat_id){
    file_get_contents('users/'.$chat_id.'language.txt');
}