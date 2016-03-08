<?php
//security POST
if($_POST['submit'] = 'Upload Image'){
    //load class
    include_once('../classes/ImageManager.class.php');
    //instance of class
    $im = new ImageManager();
    $im->goToFolder();
    //var
    $pattern = '/^image/';
    $accepted_files_index = array();
    $upload_size_limit = 5242880; //5Mo
    $moving_url = $im->interfaceFolderPosition();
    //is file img
    foreach($_FILES['fileUpload']['type'] as $key=>$d){
        preg_match($pattern, $d, $match);
        if($match){
            array_push($accepted_files_index, $key);
        }
    }
    //if file size too big, upper max upload time
    foreach($_FILES['fileUpload']['size'] as $k=> $s){
        if($s >= $upload_size_limit){
            unset($upload_size_limit, $k);
        }
    }
    foreach($_FILES['fileUpload']['error'] as $k => $e){
        if($e != 0){
            unset($upload_size_limit, $e);
        }
    }
    //moveuploadfile
    foreach($_FILES['fileUpload']['tmp_name'] as $k => $n){
        foreach($accepted_files_index as $ka){
            if(is_uploaded_file($n) && $k == $ka){
                $filename =  $moving_url.'/'.$_FILES['fileUpload']['name'][$ka];
                move_uploaded_file($n, $filename);
            }
        }
    }
    // var_dump($_FILES['fileUpload']['type']);
    echo '<p>final state</p>';
    foreach($accepted_files_index as $i){
        echo $_FILES['fileUpload']['name'][$i].'<br />';
    }
    $im->updateFile();
}