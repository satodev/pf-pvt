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
        $imageManager->interfaceImageData();
        $imageManager->goToFolder();
        $imageManager->interfaceUpload();
        // $imageManager->createImageFolder('myfilename');
        echo '<form mehtod="" action="">';
        echo '<input type="text" value="'.$imageManager->interfaceFolderPosition().'">';
        echo '<button class="button submit">';
        echo $imageManager->interfaceFolderPosition();
      }
    }
}
?>

