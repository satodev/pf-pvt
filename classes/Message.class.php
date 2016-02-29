<?php
class Message{
    private $file_name;
    private $content;
    private $iterator = 0;
    private $folder;
    public function __construct()
    {
        if($_POST && $_POST['name'] && $_POST['email'] && $_POST['sujet'] && $_POST['message']){
            if($this->verifData()){
                $this->setFileName();
                $this->getData();
                $this->createFile();
            }else{
                $this->setState('data_verif_problem');
            }
        }else{
            $this->setState('form_problem');
        }
    }
    public function setFileName()
    {
        $this->file_name = $_POST['name'];
    }
    public function setContent($content)
    {
        $this->content = $content;
    }
    public function getter()
    {
        return $this->file_name;
    }
    public function setState($state)
    {
        $this->state = $state;
    }
    public function getState()
    {
        return $this->state;
    }
    public function verifData()
    {
        if($this->verifMail() && $this->verifDataLength($_POST['name'], 100) && $this->verifDataLength($_POST['sujet'], 100) && $this->verifDataLength($_POST['message'], 1000)){
            return true;
        }else{
            $this->setState('data format wrong');
            return false;
        }
    }
    public function getData()
    {
        $mail_form = array('name' => $_POST['name'], 'from' => $_POST['email'], 'subject'=> $_POST['sujet'], 'message' => $_POST['message'], 'date' => date('c'));
        $final = json_encode($mail_form);
        $this->setContent($final);
    }
    public function createFile()
    {
        if($this->file_name){
            if(!is_file($_SERVER['DOCUMENT_ROOT'].'/data/'.$_POST['name'].'_'.date('c').'.json')){
                $this->writeInFile();
                echo $this->file_name.' created<br />';
                $this->setState('true');
                return true;
            }else{
                $this->setState('file_write_problem');
                return false;
            }
        }
    }
    public function writeInFile()
    {
        if($this->content){
         $handle = fopen($_SERVER['DOCUMENT_ROOT'].'/data/'.$_POST['name'].'_'.date('c').'.json', 'c+');
          $str = $this->content;
          $result = fwrite($handle,$str, strlen($str));
        }
    }
    public function getFilesInData()
    {
        $folder = scandir($_SERVER['DOCUMENT_ROOT'].'/data/');
        $this->folder = $folder;
    }
    public function verifMail()
    {
        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            return true;
        }else{
            return false;
        }
    }
    public function verifDataLength($data, $limit)
    {
        if($data && strlen($data) < $limit){
            return true;
        }else{
            return false;
        }
    }
}