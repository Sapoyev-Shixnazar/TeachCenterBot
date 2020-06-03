<?php

require_once "Telegram.php";
require_once "users.php";
require_once "db_connect.php";
require_once "texts.php";
$telegram = new Telegram('1119147401:AAH1EixEagpJEGF-GMp_8Z5sVju1kt5p6A8');
$data = $telegram->getData();
$message = $data['message'];
$text = $message['text'];
$chat_id = $data['chat']['id'];
echo 'hello';
if ($text = "/start") {
    chooseLanguage();
    $content = array('chat_id' => $chat_id, 'text' => "Пожалуйста выберите язык.\nIltimos, tilni tanlang.");
    $telegram->sendMessage($content);
} else {
    switch (getPage($chat_id)) {
        case 'start':
            if ($text == 'Русский 🇷🇺') {
                setLanguage($chat_id, 'uz');
            } elseif ($text == 'O\'zbek tili 🇺🇿') {
                setLanguage($chat_id, 'ru');
            } else {
                chooseButtons();
            }
            break;
        case 'main':
            // TODO
            break;
    }
}

function chooseLanguage()
{
    global $telegram, $chat_id, $message;
    setPage($chat_id, 'start');
    $option = [
        //First row
        [$telegram->buildKeyBoardButton("Русский 🇷🇺"), $telegram->buildKeyBoardButton("O'zbek tili 🇺🇿")],
    ];
    $keyb = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Пожалуйста выберите язык.\nIltimos, tilni tanlang.");
    $telegram->sendMessage($content);
}

function showMainPage()
{
    global $telegram, $chat_id, $message;
    $text = getmText('choose_category', $chat_id);
    setPage($chat_id, 'main');
    $option = [
        //First row
        [$telegram->buildKeyBoardButton("Русский 🇷🇺"), $telegram->buildKeyBoardButton("O'zbek tili 🇺🇿")],
    ];
    $keyb = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Пожалуйста выберите язык.\nIltimos, tilni tanlang.");
    $telegram->sendMessage($content);
}

function chooseButtons()
{
    global $telegram, $chat_id;

    $content = array('chat_id' => $chat_id, 'text' => "Iltimos, quyidagi tugmalardan birini tanlang.");
    $telegram->sendMessage($content);
}