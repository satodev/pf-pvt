<?php
session_write_close();
$auth = new Authentification();
if($auth->getEnableContent()){
    echo '<ul class="vertical medium-horizontal menu center">
        <li><a href="?p=back&opt=mailer">Mailer</a></li>
        <li><a href="?p=back&opt=imgs">Image System</a></li>
      </ul>';
    if($_GET && $_GET['opt']){
      if($_GET['opt'] == 'mailer'){
        $mailer = new Mailer();
        $mailer->init();
      } 
      if($_GET['opt'] == 'imgs'){
        $imageManager = new ImageManager();
        // $imageManager->goToFolder('compute');
        // $imageManager->createImageFolder('compute');
        $imageManager->getTreeMap();
        // $imageManager->interfaceTreeFolder();
        $imageManager->interfaceInputUrlBar();
        $imageManager->interfaceAccordion();
        // $imageManager->interfaceImageData();
        // echo '<p id="currentPosition">'.$imageManager->getFolderPosition().'</p>';
        $imageManager->goToFolder();
        
        // $imageManager->createImageFolder('myfilename');
        
        $imageManager->interfaceUpload();
      }
    }
}
?>

