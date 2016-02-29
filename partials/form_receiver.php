<?php
if($_POST){
    include_once('../classes/Message.class.php');
    $m = new Message();
    if($m->getState()){
        $state = $m->getState();
    }
    echo $state;
}
function redirect($filename, $state){
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/?p='.$filename.'&send='.$state.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/?p='.$filename.'&send='.$state.'" />';
        echo '</noscript>';
}
redirect('contact', $state);