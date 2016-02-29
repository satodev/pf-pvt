<?php
class Mailer{
    private $dir;
    private $data = array();
    private $json_data;
    private static $query;
    public function __construct()
    {
        
    }
    public function init()
    {
        $this->getFolderContent();
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
        $dir = scandir('data');
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
    public function searchMethod()
    {
        //search bar : filtering name, subject, email, date
    }
    public function createInterface()
    {
        $this->interfaceSearchBar();
        $this->interfaceAccordion();
        $this->interfaceChange();
        
    }
    public function interfaceSearchBar()
    {
        echo '<input type="text" name="searchBar" placeholder="SearchBar">';
    }
    public function interfaceAccordion()
    {
        if($this->data){
        foreach($this->data as $key=>$d){
        echo' <ul class="accordion" data-accordion data-allow-all-closed="true">
  <li class="accordion-item">
    <a href="#panel'.$key.'d" role="tab" class="accordion-title" id="panel'.$key.'d-heading" aria-controls="panel'.$key.'d">'.$d['name'].' : '.$d['from'].' : '.$d['subject'].' : '.$d['date'].'</a>
    <div id="panel'.$key.'d" class="accordion-content" role="tabpanel" data-tab-content aria-labelledby="panel'.$key.'d-heading">
      '.$d['message'].'
    </div>
  </li>
</ul>';
        }
        }else{
            echo '<div class="callout">Ta boite mail est vide</div>';
        }
    }
    public function interfaceChange()
    {
        if($this->data)
        {
            foreach($this->data as $key=>$d)
            {
                echo '<input type="textbox" name="tb_'.$key.'>';
                echo 'hello';
            }
        }
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