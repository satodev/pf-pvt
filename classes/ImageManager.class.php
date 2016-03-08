<?php
class ImageManager
{
    //[OK] create main folder
    //[Test] create update delete subfolder
    //[ ] upload file (check php.ini if it's possible)
    //[Test] set/change location user
    //[Test] status method (where is user)
    //[ ] action bar (change dir, rename dir, upload file, add caption)
    
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
            echo '<p class="callout secondary">createImageManagerRootFolder error : folder exists || root_folder name doesn\'t</p>';   
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
            return $this->folder_position;
        }else{
            return false;
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
    * Interface : curent folder data
    */
    public function interfaceImageData()
    {
        $folder = $this->retreiveImageData($this->getFolderPosition);
        if($folder){
            var_dump($folder);
        }
    }
    /*
    * Interface : write folder Position
    */
    public function interfaceFolderPosition()
    {
        return $this->getFolderPosition();
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
        echo '<form action="partials/uploadFile.php" method="POST" enctype="multipart/form-data">';
        echo '<input type="file" name="fileUpload[]" id="fileUpload" multiple>';
        echo '<input type="submit" value="Upload Image" name="submit">';
        echo '</form>';
    }
}