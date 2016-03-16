<?php
class ImageManager
{
    //[OK] create main folder
    //[Test] create update delete subfolder
    //[ ] upload file (check php.ini if it's possible)
    //[Test] set/change location user
    //[Test] status method (where is user)
    //[ ] action bar (change dir, rename dir, upload file, add caption)
    //[ ] action bar root define (security access)
    
    public $root_folder_exists;
    public $root_folder;
    public $filter = ['index.php', '..', '.'];
    public $folder_position;
    
    public function __construct()
    {
       
        if(!$this->root_folder){
            $this->defineRootFolderName();    
        }
        if(!$this->root_folder_exists){
            $this->createImageManagerRootFolder();
        }
    }
    /*
    * set root_folder 
    */
    public function defineRootFolderName()
    {
        $this->root_folder = $_SERVER['DOCUMENT_ROOT'].'/data_img';
    }
    /*
    * create root folder
    */
    public function createImageManagerRootFolder()
    {
        if(!file_exists($this->root_folder) && $this->root_folder){
            mkdir($this->root_folder);
        }else{
            $this->root_folder_exists = true;
        }
    }
    /*
    * retreive folder status
    */
    public function retreiveImageData($current_folder = null)
    {
        if($current_folder == null)
        {
            $current_folder = $this->root_folder;
        }
        if($current_folder && is_dir($current_folder)){
            $folder = scandir($current_folder);
            foreach($folder as $f){
                foreach($this->filter as $fi){
                    if($fi == $f){
                        $key = array_search($f, $folder);
                        unset($folder[$key]);
                    }
                }
            }
            return $folder;
        }
    }
    /*
    * recursive retreive data of folder into array
    */
    public function dirToArray($dir){
   $result = array();

   $cdir = scandir($dir);
   foreach($cdir as $key => $value) {
       if (!in_array($value, array(".", ".."))) {
           if (is_dir($dir.DIRECTORY_SEPARATOR.$value)) {
               $result[$value] = $this->dirToArray($dir.DIRECTORY_SEPARATOR.$value);
           }
           else {
               $result[] = $value;
           }
       }
   }

   return $result;
   }
   /*
   *  
   */
    public function getTreeMap($url = null)
    {
        if (!$url) {
            $url = 'data_img';
        }
        $dir = $this->dirToArray($url);
        return $dir;
    }
    /*
    *  create new image folder
    */
    public function createImageFolder($folder_name)
    {
        if($folder_name && $this->folder_position && $this->root_folder_exists && !file_exists($this->folder_position.'/'.$folder_name)){
            mkdir($this->folder_position.'/'.$folder_name);
        }else{
            return 'image folder error';
        }
    }
    /*
    *   rename folder
    */
    public function renameImageFolder($folder_name ,$new_name)
    {
        if($folder_name && $new_name && is_dir($folder_name)){
            rename($folder_name, $new_name);
        }
    }
    /*
    * try delete folder
    */
    public function deleteImageFolder($folder_name)
    {
        try{
            rmdir($folder_name);
        }catch(Exception $e)
        {
            return $e->getMessage();
        }
    }
    /*
    *   retreive user position
    */
    public function getFolderPosition()
    {
        if($this->folder_position){
            if(!$this->folder_position && $this->folder_position == $this->root_folder && $this->folder_position == 0){
                return '/';
            }else{
                return $this->folder_position;
            }
        }
    }
    /*
    * go to specific folder location or root folder
    */
    public function goToFolder($folder = null)
    {
        if($folder && is_dir($this->root_folder.'/'.$folder)){
            $this->folder_position = $this->root_folder.'/'.$folder;
        }else{
            $this->folder_position = $this->root_folder;
        }
    }
    /*
    * file update
    */
    public function updateFile()
    {
        //detect if it's zip/tar.gz || 
        var_dump($_FILES);
    }
    /*
    * Query : get directory call
    */
    public function getDirectoryCall($arg)
    {
        $pattern = '/^\/*/i';
        preg_match($pattern, $arg, $match);
        if($match){
            $arg = substr_replace($arg, '', 0, strlen($match[0]));
        }
        if($arg){
            $this->goToFolder($arg);
        }
    }
    /*
    * Interface : curent folder data
    */
    public function interfaceImageData()
    {
        $folder = $this->retreiveImageData($this->getFolderPosition);
        if($folder){
            echo '<div id="interfaceImageData">';
            var_dump($folder);
            foreach($folder as $f){
                echo '<a>'.$f.'</a><br />';
            }
            echo '</div>';
        }
    }
    /*
    * Interface : write folder Position
    */
    public function interfaceFolderPosition()
    {
        $this->getFolderPosition();
    }
    /*
    *  Interface : change name folder
    */
    public function interfaceChangeFolderName()
    {
        
    }
    /*
    * Interface: upload file
    */
    public function interfaceUpload()
    {
        echo '<div class="callout">';
        echo '<form action="partials/uploadFile.php" method="POST" enctype="multipart/form-data">';
        echo '<input type="file" name="fileUpload[]" id="fileUpload" multiple>';
        echo '<input type="submit" value="Upload Image" name="submit">';
        echo '</form>';
        echo '</div>';
    }
    /*
    * Interface : directory
    */
    public function interfaceInputUrlBar()
    {
        echo '  
        <div class="input-group" id="interfaceInputUrlBar">
            <span class="input-group-label">/</span>
            <input type="text" name="urlBar" class="input-group-field" value="'.$this->getFolderPosition().'" placeholder="'.$this->getFolderPosition().'">
            <a class="input-group-button button" name="submit">Submit</a>
        </div>';
    }
    /*
    * Interface : tree map
    */
    public function interfaceTreeFolder($var = null)
    {
        echo '<div class="callout">';
        $this->parseFolder('data_img');
        echo '</div>';
    }
    public function interfaceAccordion($arg = null)
    {
            if($arg == null){
                $treeMap = $this->getTreeMap($arg);
            }else{
                $treeMap = $arg;
            }
            echo '<ul class="vertical menu" data-accordion-menu>';
            foreach($treeMap as $k=>$t){
                    if(is_array($t) && is_string($k) && !empty($t)){
                        echo '<li>';
                        echo '<a href="#">'.$k.'</a>';
                        echo ' <ul class="menu vertical nested">';
                        $this->interfaceAccordion($t);
                        echo '</ul></li>';
                    }else if (is_array($t) && is_string($k) && empty($t)){
                             echo '<li>';
                        echo '<a href="#">'.$k.'</a>';
                        echo '</li>';
                    }else{
                        echo '<li>';
                        echo '<a href="#">'.$t.'</a>';
                        echo '</li>';
                    }
            }
            echo '</ul>';
    }
}