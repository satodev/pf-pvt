<?php
//include
include_once('../classes/ImageManager.class.php');
//class instance
$im = new ImageManager();
//get type of call
if($_GET && $_GET['im_call']){
 $im->getDirectoryCall($_GET['im_call']);
 //call ajax retreive
 echo $im->getFolderPosition(); 
}