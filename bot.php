<?php

require_once 'Telegram.php';
require_once 'Users.php';
require_once 'Pages.php';
require_once 'Texts.php';
require_once 'Districts.php';
require_once 'Subjects.php';
require_once 'TeachCenters.php';
$telegram = new Telegram('1119147401:AAH1EixEagpJEGF-GMp_8Z5sVju1kt5p6A8');
$data = $telegram->getData();
$callback_query = $telegram->Callback_Query();
$message = $data['message'];
$text = $message['text'];
$chat_id = $message['chat']['id'];

$user = new Users($chat_id);
$texts = new Texts($user->getLanguage());
$distrcts = new Districts($user->getLanguage());
$subjects = new Subjects($user->getLanguage());
$centers = new TeachCenters($user->getLanguage());
/*$telegram->sendMessage([
    'chat_id' => $chat_id,
    'text' => Pages::MAIN
]);*/
if ($text == "/start") {
    chooseLanguage();
} else {
    switch ($user->getPage()) {
        case Pages::START:
            if ($text == 'Русский 🇷🇺') {
                $user->setLanguage('ru');
                $texts->setLanguage('ru');
                $distrcts->setLanguage('ru');
                showMainPage();
            } elseif ($text == "O'zbek tili 🇺🇿") {
                $user->setLanguage('uz');
                $texts->setLanguage('uz');
                $distrcts->setLanguage('uz');
                showMainPage();
            } else {
                chooseButtons();
            }
            break;
        case Pages::MAIN:
            switch ($text) {
                case $texts->getmText('choose_teach_center'):
                    showDistricts();
                    break;
                case $texts->getmText('change_language');
                    changeLanguage();
                    break;
                case $texts->getmText('teach_center_list'):
                    showAllTeachCenters();
                    //showPag();
                    break;
            }
            break;
        case Pages::DISTRICTS:
            switch ($text) {
                case $texts->getmText('back'):
                case $texts->getmText('main_page'):
                    showMainPage();
                    break;
                default:
                    if (in_array(substr($text, 5), $distrcts->getDistricts())) {
                        $user->setDistrict($distrcts->getKeyword(substr($text, 5)));
                        showSubjects();
                    } else {
                        chooseButtons();
                    }
                    break;
            }
            break;
        case Pages::SUBJECTS:
            switch ($text) {
                case $texts->getmText('back'):
                    showDistricts();
                    break;
                case $texts->getmText('main_page'):
                    showMainPage();
                    break;
                default:
                    if (in_array(substr($text, 7), $subjects->getSubjects())) {
                        $user->setSubject($subjects->getKeyword(substr($text, 7)));
                        showTeachCenters();

                    } else {
                        chooseButtons();
                    }
                    break;
            }
            break;
        case Pages::CENTER:
            //TODO
            break;
    }
}
function chooseLanguage()
{
    global $telegram, $user;
    $user->setPage('start');
    $option = [
        //First row
        [$telegram->buildKeyBoardButton("Русский 🇷🇺"), $telegram->buildKeyBoardButton("O'zbek tili 🇺🇿")],
    ];
    $keyb = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
    $content = array('chat_id' => $user->getId(), 'reply_markup' => $keyb, 'text' => "Пожалуйста выберите язык.\nIltimos, tilni tanlang.");
    $telegram->sendMessage($content);
}

function showMainPage()
{
    global $telegram, $user, $texts;
    $texts->setLanguage($user->getLanguage());
    $user->setPage(Pages::MAIN);
    /*$telegram->sendMessage([
        'chat_id' => $user->getId(),
        'text' => Pages::MAIN
    ]);*/
    $option = [
        //First row
        [$telegram->buildKeyBoardButton($texts->getmText('choose_teach_center')), $telegram->buildKeyBoardButton($texts->getmText('teach_center_list'))],
        [$telegram->buildKeyBoardButton($texts->getmText('change_language'))]
    ];

    $keyb = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
    $content = array('chat_id' => $user->getId(), 'reply_markup' => $keyb, 'text' => $texts->getmText('choose_category'));
    $telegram->sendMessage($content);
}

function showDistricts()
{
    global $user, $texts, $distrcts;
    $user->setPage(Pages::DISTRICTS);
    $textInfo = $texts->getmText('choose_district');
    $dists = $distrcts->getDistricts();
    sendTextWithKeyboard($dists, $textInfo, "📍 ");
}

function changeLanguage()
{
    global $user;
    if ($user->getLanguage() == "uz") {
        $user->setLanguage("ru");
    } else {
        $user->setLanguage("uz");
    }
    showMainPage();
}

function showSubjects()
{
    global $user, $texts, $subjects;
    $textInf = $texts->getmText('choose_subject');
    $user->setPage(Pages::SUBJECTS);
    $subs = $subjects->getSubjects();
    sendTextWithKeyboard($subs, $textInf, "▫️ ");
}

function sendTextWithKeyboard($buttons, $text, $smile)
{
    global $telegram, $user, $texts;
    $option = [];
    //array
    for ($i = 0; $i < count($buttons); $i += 2) {
        $option[] = [$telegram->buildKeyBoardButton($smile . $buttons[$i]), $telegram->buildKeyBoardButton($smile . $buttons[$i + 1])];
    }
    $option[] = [$telegram->buildKeyboardButton($texts->getmText('back')), $telegram->buildKeyboardButton($texts->getmText('main_page'))];
    $keyb = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
    $content = array('chat_id' => $user->getId(), 'reply_markup' => $keyb, 'text' => $text);
    $telegram->sendMessage($content);
}

function showTeachCenters()
{
    global $telegram, $user, $texts, $centers;
    $textInf = $texts->getmText('choose_teach_center');
    $trCenters = $centers->getCenters($user->getDistrict(), $user->getSubject());
    $textNo = $texts->getmText('no_tc');
    if (!$trCenters) {
        $content = array('chat_id' => $user->getId(), 'text' => $textNo);
        $telegram->sendMessage($content);
    } else {
        sendTextWithKeyboardForInlineButton($trCenters, $textInf, "☑️");
        //$user->setPage(Pages::CENTER);
    }
}

function showAllTeachCenters()
{
    global $texts, $centers;
    $textInfo = $texts->getmText('choose_teach_center');
    //$user->setPage(0);
    $allCenters = $centers->getAllCenters();
    sendTextWithKeyboardForInlineButton($allCenters, $textInfo, "☑️");
}

function sendTextWithKeyboardForInlineButton($buttons, $text, $smile)
{
    global $telegram, $user;
    $option = [];
    foreach ($buttons as $item) {
        $option[] = [$telegram->buildInlineKeyboardButton($smile . $item . $smile, "", $item)];
    }
    $option[] = [$telegram->buildInlineKeyboardButton("⬅️","","⬅️"), $telegram->buildInlineKeyboardButton("➡️","","➡️")];
    $keyb = $telegram->buildInlineKeyBoard($option);
    $content = array('chat_id' => $user->getId(), 'text' => $text, 'reply_markup' => $keyb);
    $telegram->sendMessage($content);
}

function chooseButtons()
{
    global $telegram, $chat_id;

    $content = array('chat_id' => $chat_id, 'text' => "Iltimos, quyidagi tugmalardan birini tanlang.");
    $telegram->sendMessage($content);
}