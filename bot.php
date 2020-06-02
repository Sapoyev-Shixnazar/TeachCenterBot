<?php

require_once "Telegram.php";

$telegram = new Telegram('1119147401:AAH1EixEagpJEGF-GMp_8Z5sVju1kt5p6A8');
$data = $telegram->getData();
$message = $data['message'];
$text = $message['text'];
$chat_id = $data['chat']['id'];

if($text = '/start'){
    $content = [
      'chat_id' => $chat_id,
      'text' => $content
    ];
    $telegram->sendMessage($content);
}