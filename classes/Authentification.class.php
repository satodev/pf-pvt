<?php
class Authentification{
    private $session_name = 'sSession';
    private $enable_content = false;
    public function __construct()
    {
        $this->init();
    }
    public function init()
    {
        $this->verifAuthentificationExists();
        if($_GET && $_GET['d']){
            $this->destroySession();
            header('Location:/');
        }
    }
    public function verifAuthentificationExists()
    {
        session_start();
        if($_SESSION[$this->session_name]){
            $this->setEnableContent(true);
            return true;
        }
        if($_POST['user'] && $_POST['pwd']){
            $model = new Model();
            $name = $model->credentials();
            if($name && !$_SESSION[$this->session_name]){
                $this->createSession();
            }else{
                $this->throwAuthentificationForm();
            }
        }else{
            $this->throwAuthentificationForm();
        }
    }
    public function throwAuthentificationForm()
    {
        echo '<div class="small-6 medium-6 columns">';
        echo '<form action="" method="POST">';
        echo '<label>User : </label><input type="text" name="user">';
        echo '<label>Password : </label><input type="password" name="pwd">';
        echo '<input type="submit" value="Submit">';
        echo '</form></div>';
    }
    public function createSession()
    {
        session_start($this->session_name);
        $_SESSION[$this->session_name] = session_id();
        session_write_close();
        $this->setEnableContent(true);
        header('Location:/?p=back');
    }
    public function destroySession()
    {
        session_start($this->session_name);
        unset($_SESSION[$this->session_name]);
    }
    public function setEnableContent($status)
    {
        $this->enable_content = $status;
    }
    public function getEnableContent()
    {
        return $this->enable_content;
    }
}