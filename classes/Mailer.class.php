<?php
class Mailer{
    private $dir;
    private $data = array();
    private $json_data;
    private static $query;
    public function __construct()
    {
        $this->getFolderContent();
    }
    public function init()
    {
        $this->getMessageData();
        $this->createInterface();    
    }
    public function getMessageData()
    {
       foreach($this->dir as $f){
          
          $url = $_SERVER['DOCUMENT_ROOT'].'/data/'.$f;
          $handle = fopen($url, 'c+');
            $data = fread($handle, filesize($url));
            $decode_data = json_decode($data, true);
            array_push($this->data, $decode_data);
       }
       return $decode_data;
    }
    public function getFolderContent()
    {
        $dir = scandir($_SERVER['DOCUMENT_ROOT'].'/data');
        $filter = ['index.php', '.', '..'];
        foreach($dir as $d){
            for($i = 0; $i< sizeof($filter); $i++){
                if($d == $filter[$i]){
                    $key = array_search($d, $dir);
                    unset($dir[$key]);
                }
            }
        }
        $this->dir = $dir;
        return $dir;
    }
    public function deleteMails()
    {
        foreach($this->dir as $d){
            unlink($_SERVER['DOCUMENT_ROOT'].'/data/'.$d);
        }
        echo 'mail file deleted';
    }
    public function createInterface()
    {
        $this->interfaceSearchBar();
        $this->interfaceMenuBar();
        $this->interfaceAccordion();
    }
    public function interfaceSearchBar()
    {
        echo '<input type="text" name="searchBar" placeholder="SearchBar">';
    }
    public function interfaceAccordion()
    {
        if($this->data){
        foreach($this->data as $key=>$d){
        echo' <ul class="accordion" data-accordion role="tablist">
  <li class="accordion-item">
    <a href="#panel1d" role="tab" class="accordion-title" id="panel1d-heading" aria-controls="panel1d">'.$d['name'].' : '.$d['from'].' : '.$d['subject'].' : '.$d['date'].'</a>
    <div id="panel1d" class="accordion-content" role="tabpanel" data-tab-content aria-labelledby="panel1d-heading">
      '.$d['message'].'
    </div>
  </li>
</ul>';
        }
        }else{
            echo '<div class="callout secondary">Boite mail vide</div>';
        }
    }
    public function interfaceMenuBar()
    {
        echo '<div class="callout clearfix">';
        echo '<a id="mail_delete" class="button float-right">Supprimer tout</a>';
        echo '</div>';
    }
    public function queryDeleteMails()
    {
        $this->deleteMails();
    }
    public function getQuery()
    {
        echo Mailer::$query;
    }
    public static function getSearchQuery()
    {
        Mailer::$query = $_GET['query'];
    }
   
}