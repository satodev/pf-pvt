<?php
class Model
{
    private $user_admin = 'sroot';
    private $user_pwd = 'spwd';
    private $engine = 'mysql'; 
    private $host = 'localhost';
    private $db_name = 'pf-pvt';
    private $user = 'satodev';
    private $pwd = 'satodev@4591';
    private $pdo;
    public function __construct()
    {
        $this->createPdo();
        $this->createDataBase();
        $this->createTableUser();
        $this->insertFirstAdminUser();
        
    }
    public function createPdo()
    {
        $dns = $this->engine.':dbname='.$this->db_name.";host=".$this->host; 
        try{
        $pdo = new PDO($dns, $this->user, $this->pwd);
        }catch(Exception $e){
            echo '<div class="alert callout">Authentification a la base de donnée impossible</div>';
            die();
        }
        $this->pdo = $pdo;
    }
    public function credentials()
    {
        if($_POST && $_POST['user'] && $_POST['pwd']){
                $name = $_POST['user'];
                $password = $_POST['pwd'];
               $name =  $this->selectUser($_POST['user'], $_POST['pwd']);
               return $name;
        }
    }
    public function selectUser($name, $pwd)
    {
        try{
        $pdo = $this->pdo;
        $sql = "SELECT `name` FROM `user` WHERE name ='$name' AND password='$pwd'";
        $handle = $pdo->prepare($sql);
        $handle->execute();
        $result = $handle->fetchAll(PDO::FETCH_COLUMN);
        return $result;
        }catch(Exception $e){
            echo '<div clas="alert callout">'.$e->getMessage().'</div>';
            die();
        }
    }
    public function insertFirstAdminUser()
    {
        $name_exists = $this->selectUser($this->user_admin, $this->user_pwd);
        if($name_exists){
            return true;
        }else{
            echo 'empty satodev';
            try{
            $pdo = $this->pdo;
            $sql = "INSERT INTO `user`(`name`, `password`) VALUES ('".$this->user_admin."', '".$this->user_pwd."')";
            $handle = $pdo->prepare($sql);
            $handle->execute();
            }catch(Exception $e){
                echo $e->getMessage();
                die();
            }
        }
    }
    public function createTableUser()
    {
        $pdo = $this->pdo;
        try{
        $handle = $pdo->prepare('CREATE TABLE IF NOT EXISTS user (
                                id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
                                name VARCHAR(255) NOT NULL,
                                password VARCHAR(255) NOT NULL)'
        );
        $response = $handle->execute();
        }catch(Eception $e){
            echo '<div class="alert callout">Couldn\'t create User Table</div>';
            die();
        }
    }
    public function createDataBase()
    {
        $pdo = $this->pdo;
        try{
        $handle = $pdo->prepare('CREATE DATABASE IF NOT EXISTS `pf-pvt`');
        $result = $handle->execute();
        }catch(Exception $e){
            echo '<div class="alert callout">Couldn\'t create Database</div>';
            die();
        }
    }
    public function truncateTable($table_name)
    {
        if($table_name)
        {
            try{
            $sql = 'TRUNCATE '. $table_name;
            $pdo = $this->pdo;
            $handle = $pdo->prepare($sql);
            $handle->execute();
            return true;
            }catch(Exception $e)
            {
                echo '<div class="alert callout">'.$e->getMessage().'</div>';
                die();
            }
        }
    }
}