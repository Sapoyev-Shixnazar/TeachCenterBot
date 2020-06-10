<?php
//require_once "Texts.php";
class Users
{
    private $id;
    public function __construct($chat_id)
    {
        $this->id = $chat_id;
    }
     function getId(){
        return $this->id;
    }
    function setPage($data)
    {
        file_put_contents('users/' . $this->id . 'page.txt', $data);
    }

    function getPage()
    {
        return file_get_contents('users/' . $this->id . 'page.txt');
    }

    function setLanguage($content)
    {
        file_put_contents('users/' . $this->id . 'language.txt', $content);
    }

    function getLanguage()
    {
        return file_get_contents('users/' . $this->id . 'language.txt');
    }
    function setDistrict($data){
        file_put_contents('users/' . $this->id . 'district.txt', $data);
    }
    function getDistrict(){
        return file_get_contents('users/' . $this->id . 'district.txt');
    }
    function setSubject($data){
        file_put_contents('users/' . $this->id . 'subject.txt', $data);
    }
    function getSubject(){
        return file_get_contents('users/' . $this->id . 'subject.txt');
    }
    function setCenter($center){
        file_put_contents('users/' . $this->id . 'center.txt', $center);
    }
    function  getCenter(){
        return file_get_contents('users/' . $this->id . 'center.txt');
    }
    function setResultPage($number){
        file_put_contents('users/' . $this->id . 'resultpage.txt', $number);
    }
    function getResultPage(){
        return file_get_contents('users/' . $this->id . 'resultpage.txt');
    }
}
